<?php

namespace Cminds\MultiUserAccounts\Controller\Account;

use Cminds\MultiUserAccounts\Helper\View as ViewHelper;
use Cminds\MultiUserAccounts\Model\Config as ModuleConfig;
use Magento\Customer\Model\AuthenticationInterface;
use Magento\Customer\Model\Customer\Mapper;
use Magento\Customer\Model\EmailNotificationInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\CustomerExtractor;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\InvalidEmailOrPasswordException;
use Magento\Framework\Exception\State\UserLockedException;
use Cminds\MultiUserAccounts\Api\SubaccountTransportRepositoryInterface;

/**
 * Cminds MultiUserAccounts di config.
 *
 * @category Cminds
 * @package  Cminds_MultiUserAccounts
 * @author   Piotr Pierzak <piotr@cminds.com>
 */
class EditPost extends \Magento\Customer\Controller\AbstractAccount
{
    /**
     * Form code for data extractor
     */
    const FORM_DATA_EXTRACTOR_CODE = 'customer_account_edit';

    /**
     * @var AccountManagementInterface
     */
    protected $customerAccountManagement;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var Validator
     */
    protected $formKeyValidator;

    /**
     * @var SubaccountTransportRepositoryInterface
     */
    private $subaccountTransportRepository;

    /**
     * @var CustomerExtractor
     */
    protected $customerExtractor;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var \Magento\Customer\Model\EmailNotificationInterface
     */
    private $emailNotification;

    /**
     * @var AuthenticationInterface
     */
    private $authentication;

    /**
     * @var Mapper
     */
    private $customerMapper;

    /**
     * View helper object.
     *
     * @var ViewHelper
     */
    private $viewHelper;

    /**
     * Module config object.
     *
     * @var ModuleConfig
     */
    private $moduleConfig;

    /**
     * EditPost constructor.
     *
     * @param Context $context
     * @param Session $customerSession
     * @param AccountManagementInterface $customerAccountManagement
     * @param CustomerRepositoryInterface $customerRepository
     * @param Validator $formKeyValidator
     * @param SubaccountTransportRepositoryInterface $subaccountTransportRepository
     * @param ViewHelper $viewHelper
     * @param ModuleConfig $moduleConfig
     * @param CustomerExtractor $customerExtractor
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        AccountManagementInterface $customerAccountManagement,
        CustomerRepositoryInterface $customerRepository,
        Validator $formKeyValidator,
        SubaccountTransportRepositoryInterface $subaccountTransportRepository,
        ViewHelper $viewHelper,
        ModuleConfig $moduleConfig,
        CustomerExtractor $customerExtractor
    ) {
        parent::__construct($context);
        $this->session = $customerSession;
        $this->customerAccountManagement = $customerAccountManagement;
        $this->customerRepository = $customerRepository;
        $this->formKeyValidator = $formKeyValidator;
        $this->subaccountTransportRepository = $subaccountTransportRepository;
        $this->customerExtractor = $customerExtractor;
        $this->viewHelper = $viewHelper;
        $this->moduleConfig = $moduleConfig;
    }

    /**
     * Get authentication
     *
     * @return AuthenticationInterface
     */
    private function getAuthentication()
    {

        if (!($this->authentication instanceof AuthenticationInterface)) {
            return ObjectManager::getInstance()->get(
                \Magento\Customer\Model\AuthenticationInterface::class
            );
        } else {
            return $this->authentication;
        }
    }

    /**
     * Get email notification
     *
     * @return EmailNotificationInterface
     * @deprecated 100.1.0
     */
    private function getEmailNotification()
    {
        if (!($this->emailNotification instanceof EmailNotificationInterface)) {
            return ObjectManager::getInstance()->get(
                EmailNotificationInterface::class
            );
        } else {
            return $this->emailNotification;
        }
    }

    /**
     * Change customer email or password action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $subuserId = '';
        $customerId = '';
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $validFormKey = $this->formKeyValidator->validate($this->getRequest());

        if ($validFormKey && $this->getRequest()->isPost()) {

            if($this->viewHelper->isSubaccountLoggedIn() === true && $this->moduleConfig->isSharedSessionEnabled() === true) {
                $customerId = $this->session->getSubaccountData()->getCustomerId();
                $subuserId = $this->session->getSubaccountData()->getCustomerId();
            } else {
                $customerId = $this->session->getCustomerId();
            }

            $currentCustomerDataObject = $this->getCustomerDataObject($customerId);
            $customerCandidateDataObject = $this->populateNewCustomerDataObject(
                $this->_request,
                $currentCustomerDataObject
            );

            try {
                // whether a customer enabled change email option
                $this->processChangeEmailRequest($currentCustomerDataObject);

                if($this->viewHelper->isSubaccountLoggedIn() === true && $this->moduleConfig->isSharedSessionEnabled() === true) {
                    $email = $this->session->getSubaccountData()->getEmail();                    
                } else {
                    $email = $currentCustomerDataObject->getEmail();
                }
                
                // whether a customer enabled change password option
                $isPasswordChanged = $this->changeCustomerPassword($email);

                $this->customerRepository->save($customerCandidateDataObject);
                $this->getEmailNotification()->credentialsChanged(
                    $customerCandidateDataObject,
                    $email,
                    $isPasswordChanged
                );
                
                if($subuserId) {
                    $subaccountTransportDataObject = $this->subaccountTransportRepository
                        ->getById($subuserId);
                    $this->session
                        ->setSubaccountData($subaccountTransportDataObject);
                }
                $this->dispatchSuccessEvent($customerCandidateDataObject);
                $this->messageManager->addSuccess(__('You saved the account information.'));
                return $resultRedirect->setPath('customer/account');
            } catch (InvalidEmailOrPasswordException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (UserLockedException $e) {
                $message = __(
                    'You did not sign in correctly or your account is temporarily disabled.'
                );
                $this->session->logout();
                $this->session->start();
                $this->messageManager->addError($message);
                return $resultRedirect->setPath('customer/account/login');
            } catch (InputException $e) {
                $this->messageManager->addError($e->getMessage());
                foreach ($e->getErrors() as $error) {
                    $this->messageManager->addError($error->getMessage());
                }
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e);
            }

            $this->session->setCustomerFormData($this->getRequest()->getPostValue());
        }

        return $resultRedirect->setPath('*/*/edit');
    }

    /**
     * Account editing action completed successfully event
     *
     * @param \Magento\Customer\Api\Data\CustomerInterface $customerCandidateDataObject
     * @return void
     */
    private function dispatchSuccessEvent(\Magento\Customer\Api\Data\CustomerInterface $customerCandidateDataObject)
    {
        $this->_eventManager->dispatch(
            'customer_account_edited',
            ['email' => $customerCandidateDataObject->getEmail()]
        );
    }

    /**
     * Get customer data object
     *
     * @param int $customerId
     *
     * @return \Magento\Customer\Api\Data\CustomerInterface
     */
    private function getCustomerDataObject($customerId)
    {
        return $this->customerRepository->getById($customerId);
    }

    /**
     * Create Data Transfer Object of customer candidate
     *
     * @param \Magento\Framework\App\RequestInterface $inputData
     * @param \Magento\Customer\Api\Data\CustomerInterface $currentCustomerData
     * @return \Magento\Customer\Api\Data\CustomerInterface
     */
    private function populateNewCustomerDataObject(
        \Magento\Framework\App\RequestInterface $inputData,
        \Magento\Customer\Api\Data\CustomerInterface $currentCustomerData
    ) {
        $attributeValues = $this->getCustomerMapper()->toFlatArray($currentCustomerData);
        $customerDto = $this->customerExtractor->extract(
            self::FORM_DATA_EXTRACTOR_CODE,
            $inputData,
            $attributeValues
        );
        $customerDto->setId($currentCustomerData->getId());
        if (!$customerDto->getAddresses()) {
            $customerDto->setAddresses($currentCustomerData->getAddresses());
        }
        if (!$inputData->getParam('change_email')) {
            $customerDto->setEmail($currentCustomerData->getEmail());
        }

        return $customerDto;
    }

    /**
     * Change customer password
     *
     * @param string $email
     * @return boolean
     * @throws InvalidEmailOrPasswordException|InputException
     */
    protected function changeCustomerPassword($email)
    {
        $isPasswordChanged = false;
        if ($this->getRequest()->getParam('change_password')) {
            $currPass = $this->getRequest()->getPost('current_password');
            $newPass = $this->getRequest()->getPost('password');
            $confPass = $this->getRequest()->getPost('password_confirmation');
            if ($newPass != $confPass) {
                throw new InputException(__('Password confirmation doesn\'t match entered password.'));
            }

            $isPasswordChanged = $this->customerAccountManagement->changePassword($email, $currPass, $newPass);
        }

        return $isPasswordChanged;
    }

    /**
     * Process change email request
     *
     * @param \Magento\Customer\Api\Data\CustomerInterface $currentCustomerDataObject
     * @return void
     * @throws InvalidEmailOrPasswordException
     * @throws UserLockedException
     */
    private function processChangeEmailRequest(\Magento\Customer\Api\Data\CustomerInterface $currentCustomerDataObject)
    {
        if ($this->getRequest()->getParam('change_email')) {
            // authenticate user for changing email
            try {
                $this->getAuthentication()->authenticate(
                    $currentCustomerDataObject->getId(),
                    $this->getRequest()->getPost('current_password')
                );
            } catch (InvalidEmailOrPasswordException $e) {
                throw new InvalidEmailOrPasswordException(__('The password doesn\'t match this account.'));
            }
        }
    }

    /**
     * Get Customer Mapper instance
     *
     * @return Mapper
     *
     * @deprecated 100.1.3
     */
    private function getCustomerMapper()
    {
        if ($this->customerMapper === null) {
            $this->customerMapper = ObjectManager::getInstance()->get(\Magento\Customer\Model\Customer\Mapper::class);
        }
        return $this->customerMapper;
    }
}
