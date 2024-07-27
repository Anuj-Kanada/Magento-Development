<?php

namespace Brainvire\CustomerMgt\Controller\Account;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Account\Redirect as AccountRedirect;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\Exception\EmailNotConfirmedException;
use Magento\Framework\Exception\InvalidEmailOrPasswordException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Model\Url as CustomerUrl;
use Psr\Log\LoggerInterface;
use Magento\Framework\Data\Form\FormKey\Validator;  
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Customer\Controller\Account\LoginPost as LoginPostOriginal;
use Magento\Customer\Model\CustomerFactory;

class LoginPost extends LoginPostOriginal implements HttpPostActionInterface
{
    protected $customerRepository;
    protected $encryptor;
    protected $searchCriteriaBuilder;
    protected $logger;
    protected $customerFactory;

    public function __construct(
        Context $context,
        Session $customerSession,
        ScopeConfigInterface $scopeConfig,
        AccountManagementInterface $customerAccountManagement,
        CustomerRepositoryInterface $customerRepository,
        AccountRedirect $accountRedirect,
        LoggerInterface $logger,
        StoreManagerInterface $storeManager,
        CustomerUrl $customerUrl,
        RedirectInterface $redirect,
        Validator $formKeyValidator,
        EncryptorInterface $encryptor,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CustomerFactory $customerFactory
    ) {
        $this->customerRepository = $customerRepository;
        $this->encryptor = $encryptor;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->logger = $logger;
        $this->customerFactory = $customerFactory;
        parent::__construct(
            $context,
            $customerSession,
            $customerAccountManagement,
            $customerUrl,
            $formKeyValidator,
            $accountRedirect,
            $scopeConfig,
            $customerRepository,
            $logger,
            $storeManager,
            $redirect
        );
    }

    public function execute()
    {
        $this->logger->info('Login attempt started.');
        
        if ($this->getRequest()->isPost()) {
            $login = $this->getRequest()->getPost('login');
            $this->logger->info('Login data received: ' . json_encode($login));

            if (!empty($login['username']) && !empty($login['password'])) {
                try {
                    $this->logger->info('Fetching customer by username: ' . $login['username']);
                    $customer = $this->getCustomerByUsername($login['username']);

                    if ($customer) {
                        $this->logger->info('Customer found: ID ' . $customer->getId());

                        if ($this->verifyPassword($customer, $login['password'])) {
                            $this->logger->info('Password verification successful.');
                            $this->customerSession->setCustomerDataAsLoggedIn($customer);
                            $this->customerSession->regenerateId();
                            return $this->accountRedirect->getRedirect();
                        } else {
                            $this->logger->error('Password verification failed.');
                            throw new InvalidEmailOrPasswordException(__('Invalid login or password.'));
                        }
                    } else {
                        $this->logger->error('No customer found with username: ' . $login['username']);
                        throw new InvalidEmailOrPasswordException(__('Invalid login or password.'));
                    }
                } catch (EmailNotConfirmedException $e) {
                    $this->messageManager->addErrorMessage(__('This account is not confirmed.'));
                    $this->logger->error($e->getMessage());
                } catch (InvalidEmailOrPasswordException $e) {
                    $this->messageManager->addErrorMessage(__('Invalid login or password.'));
                    $this->logger->error($e->getMessage());
                } catch (NoSuchEntityException $e) {
                    $this->messageManager->addErrorMessage(__('Invalid login or password.'));
                    $this->logger->error($e->getMessage());
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage($e->getMessage());
                    $this->logger->error($e->getMessage());
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage(__('An error occurred while processing your request. Please try again later.'));
                    $this->logger->error($e->getMessage());
                }
            } else {
                $this->messageManager->addErrorMessage(__('A login and a password are required.'));
                $this->logger->error('Login and password are required fields.');
            }
        }
        return $this->accountRedirect->getRedirect();
    }

    protected function getCustomerByUsername($username)
    {
        try {
            if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
                $this->logger->info('Username is an email.');
                return $this->customerRepository->get($username);
            } else {
                $this->logger->info('Username is a mobile number.');
                $searchCriteria = $this->searchCriteriaBuilder->addFilter('mobile_number', $username, 'eq')->create();
                $customerList = $this->customerRepository->getList($searchCriteria);
                $items = $customerList->getItems();
                if (count($items)) {
                    $this->logger->info('Customer found by mobile number.');
                    return reset($items);
                }
                $this->logger->error('No customer found with mobile number: ' . $username);
                return null;
            }
        } catch (NoSuchEntityException $e) {
            $this->logger->error($e->getMessage());
            return null;
        }
    }

    protected function verifyPassword($customer, $password)
    {
        $this->logger->info('Verifying password for customer ID: ' . $customer->getId());
        $customerModel = $this->customerFactory->create()->load($customer->getId());
        $passwordHash = $customerModel->getPasswordHash();
        if (!$passwordHash) {
            $this->logger->error('Customer ID ' . $customer->getId() . ' does not have a password hash.');
            return false;
        }
        return $this->encryptor->validateHash($password, $passwordHash);
    }
}
