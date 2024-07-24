<?php
namespace Brainvire\Studentmgt\Controller\Adminhtml\Student;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Brainvire\Studentmgt\Model\ResourceModel\Student\CollectionFactory;


/**
 * MassDelete Action class
 */
class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Brainvire_Studentmgt::delete';

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Context           $context
     * @param Filter            $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
        ) {
            $this->filter = $filter;
            $this->collectionFactory = $collectionFactory;
            parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $collectionSize = $collection->getSize();
            foreach ($collection as $item) {
                $item->delete();
            }
            $this->messageManager->addSuccess(__('A total of %1 element(s) have been deleted.', $collectionSize));
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath('*/*/');
        } catch (Exception $e) {
            $this->messageManager->addError("Somthing Went Wrong % 1", $e->getMessage());
            $resultRedirect = $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('studentmgt/student/index');
        }
    }
}