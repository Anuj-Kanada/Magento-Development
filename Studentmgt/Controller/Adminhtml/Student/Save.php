<?php
namespace Brainvire\Studentmgt\Controller\Adminhtml\Student;

use Magento\Backend\App\Action;
use Magento\Backend\Model\Session;
use Brainvire\Studentmgt\Model\StudentFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Save Action class
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var StudentFactory
     */
    protected $studentModel;

    /**
     * @var Session
     */
    protected $adminsession;

    /**
     * @var DataPersistorInterface 
     */
    protected $dataPersistor;

    /**
     * @param Action\Context $context
     * @param Student $studentModel
     * @param Session $adminsession
     * @param Session $adminsession

     */
    public function __construct(
        Action\Context $context,
        StudentFactory $studentModel,
        Session $adminsession,
        DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
        $this->studentModel = $studentModel;
        $this->adminsession = $adminsession;
        $this->dataPersistor = $dataPersistor;
    }

    /**
     * Save record
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $studentData = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $student = $this->studentModel->create();
            $student->setData($studentData);
            $student->save();
            $this->messageManager->addSuccess(__('The data has been saved.'));
            if ($this->getRequest()->getParam('back')) {
                if ($this->getRequest()->getParam('back') == 'add') {
                    return $resultRedirect->setPath('*/*/add');
                } else {
                    return $resultRedirect->setPath('*/*/edit', ['id' => ($student->getData('student_id')), '_current' => true]);
                }
            }
            return $resultRedirect->setPath('*/*/');
        } catch (\Magento\Framework\Exception\AlreadyExistsException $e) {
            $this->messageManager->addError(__("Email Already Exists! Please Check "));
        } catch (\Exception $e) {
            $this->messageManager->addError($e, __('Something went wrong while saving the data.'));
        }
        $this->dataPersistor->set('student_form', $studentData);
        return $resultRedirect->setPath(
            '*/*/add',
            ['_current' => true]
        );
    }
}