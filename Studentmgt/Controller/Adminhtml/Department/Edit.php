<?php
namespace Brainvire\Studentmgt\Controller\Adminhtml\Department;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Edit class
 */
class Edit extends \Magento\Backend\App\Action
{
    /**
     * Resource constant
     */
    const ADMIN_RESOURCE = 'Brainvire_Studentmgt::edit';

    /**
     * PageFactory variable
     *
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Constructor function
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Execute function
     *
     * @return void
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Edit Record'));
        return $resultPage;
    }
}