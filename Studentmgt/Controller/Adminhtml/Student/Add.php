<?php
namespace Brainvire\Studentmgt\Controller\Adminhtml\Student;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Add class
 */
class Add extends \Magento\Backend\App\Action
{
    /**
     * PageFactory variable
     *
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
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
     * Abtract function
     *
     * @return mixed
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Add New Student'));
        return $resultPage;
    }
}
