<?php
namespace Brainvire\Studentmgt\Controller\Adminhtml\Department;

    use Magento\Backend\App\Action;
    use Magento\Backend\Model\Session;
    use Brainvire\Studentmgt\Model\DepartmentFactory;
    use Magento\Framework\App\Request\DataPersistorInterface;

    /**
     * Save class
     */
    class Save extends \Magento\Backend\App\Action
    {   
        /**
         * @var DepartmentFactory
         */
        protected $departmentModel;

        /**
         * @var Session
         */
        protected $adminsession;

        protected $dataPersistor;

        /**
         * @param Action\Context $context
         * @param department $departmentModel
         * @param Session $adminsession
         * @param Session $adminsession
         */
        public function __construct(
            Action\Context $context,
            DepartmentFactory $departmentModel,
            Session $adminsession,
            DataPersistorInterface $dataPersistor
        ) {
            parent::__construct($context);
            $this->departmentModel = $departmentModel;
            $this->adminsession = $adminsession;
            $this->dataPersistor = $dataPersistor;
        }

        /**
         * Save record action
         *
         * @return \Magento\Backend\Model\View\Result\Redirect
         */
        public function execute()
        {
            $departmentData = $this->getRequest()->getPostValue();
            $resultRedirect = $this->resultRedirectFactory->create();
            try {
                $department = $this->departmentModel->create();
                $department->setData($departmentData);
                $department->save();
                $this->messageManager->addSuccess(__('The data has been saved.'));
                $this->adminsession->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    if ($this->getRequest()->getParam('back') == 'add') {
                        return $resultRedirect->setPath('*/*/add');
                    } else {
                        return $resultRedirect->setPath('*/*/edit', ['department_id' => ($department->getData('department_id')), '_current' => true]);
                    }
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\AlreadyExistsException $e) {
                $this->messageManager->addError(__("Department name is Already Exists! Please Check "));
            } catch (\Exception $e) {
                $this->messageManager->addError($e, __('Something went wrong while saving the data.'));
            }
            $this->dataPersistor->set('department_form', $departmentData);
            return $resultRedirect->setPath('*/*/add', ['_current' => true]);
            return $resultRedirect->setPath('*/*/edit', ['department_id' => $this->getRequest()->getParam('department_id')]);
        }
    }
    