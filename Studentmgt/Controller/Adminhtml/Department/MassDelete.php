<?php
namespace Brainvire\Studentmgt\Controller\Adminhtml\Department;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Brainvire\Studentmgt\Model\ResourceModel\Department\CollectionFactory;
use Brainvire\Studentmgt\Model\ResourceModel\Student\CollectionFactory as StudentCollectionFactory;
use Exception;

class MassDelete extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Brainvire_Studentmgt::delete';

    protected $filter;
    protected $collectionFactory;
    protected $studentCollectionFactory;

    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        StudentCollectionFactory $studentCollectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->studentCollectionFactory = $studentCollectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $collectionSize = $collection->getSize();
            $deletedCount = 0;

            foreach ($collection as $item) {
                // Check if department is allocated to any student
                $studentCollection = $this->studentCollectionFactory->create();
                $studentCollection->addFieldToFilter('department', $item->getId());

                if ($studentCollection->getSize() > 0) {
                    // Department is allocated, skip deletion
                    $this->messageManager->addError(__('Department "%1" is allocated to students and cannot be deleted.', $item->getDepartment()));
                } else {
                    // Department not allocated, proceed with deletion
                    $item->delete();
                    $deletedCount++;
                }
            }

            if ($deletedCount > 0) {
                $this->messageManager->addSuccess(__('Total %1 record(s) have been deleted.', $deletedCount));
            }

            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath('*/*/');

        } catch (Exception $e) {
            $this->messageManager->addError(__('Something went wrong: %1', $e->getMessage()));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('studentmgt/department/index');
        }
    }
}
