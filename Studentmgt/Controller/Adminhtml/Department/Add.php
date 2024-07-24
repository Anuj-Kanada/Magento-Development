<?php
namespace Brainvire\Studentmgt\Controller\Adminhtml\Department;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Add class
 */
class Add extends \Magento\Backend\App\Action
{
    /**
     * PageFactory 
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
     * @return mixed
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Add Department'));
        return $resultPage;
    }
}