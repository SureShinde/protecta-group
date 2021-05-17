<?php

namespace Digital\CustomAPI\Observer\Subaccount;

use Magento\Framework\Registry;
use Magento\Framework\Event\Observer;
use Digital\CustomAPI\Services\Customer;
use Digital\CustomAPI\Helper\CustomLogger;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\Event\ObserverInterface;
use Digital\CustomAPI\Services\NetSuiteServices;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Cminds\MultiUserAccounts\Helper\View as ViewHelper;
use Magento\Framework\Exception\AuthenticationException;
use Cminds\MultiUserAccounts\Api\Data\SubaccountInterface;
use Cminds\MultiUserAccounts\Model\Config as ModuleConfig;
use Magento\Customer\Model\Session\Proxy as CustomerSession;
use Magento\Customer\Api\CustomerRepositoryInterface as CustomerRepository;

/**
 * Cminds MultiUserAccounts before customer save observer.
 * Will be executed on "subaccount_save_before" event.
 *
 * @category Cminds
 * @package  Cminds_MultiUserAccounts
 * @author   Piotr Pierzak <piotr@cminds.com>
 */
class SaveBefore implements ObserverInterface
{
    /**
     * Customer session object.
     *
     * @var CustomerSession
     */
    private $customerSession;

    /**
     * Module config object.
     *
     * @var ModuleConfig
     */
    private $moduleConfig;

    /**
     * View helper object.
     *
     * @var ViewHelper
     */
    private $viewHelper;

    /**
     * Customer repository object.
     *
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * Customer factory object.
     *
     * @var CustomerFactory
     */
    private $customerFactory;

    /**
     * Registry Object.
     *
     * @var Registry
     */
    private $registry;

    /**
     * @var CustomerRepositoryInterface
     */
    private $_customerRepository;

    /**
     * Object constructor.
     *
     * @param CustomerSession     $customerSession     Customer session object.
     * @param ModuleConfig        $moduleConfig        Module config object.
     * @param ViewHelper          $viewHelper          View helper object.
     * @param CustomerRepository  $customerRepository  Customer repository object.
     * @param CustomerFactory     $customerFactory     Customer factory object.
     * @param Registry            $registry            Registry Object.
     */
    public function __construct(
        CustomerSession $customerSession,
        ModuleConfig $moduleConfig,
        ViewHelper $viewHelper,
        CustomerRepository $customerRepository,
        CustomerFactory $customerFactory,
        Registry $registry,
        CustomerRepositoryInterface $customerRepositoryInterface
    ) {
        $this->customerSession = $customerSession;
        $this->moduleConfig = $moduleConfig;
        $this->viewHelper = $viewHelper;
        $this->customerRepository = $customerRepository;
        $this->customerFactory = $customerFactory;
        $this->registry = $registry;
        $this->_customerRepository = $customerRepositoryInterface;
    }

    /**
     * Check permission in before save event handler.
     *
     * @param Observer $observer Observer object.
     *
     * @return SaveBefore
     * @throws \Magento\Framework\Exception\State\InputMismatchException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws AuthenticationException
     */
    public function execute(Observer $observer)
    {
        try {
            //code...
            //@TODO check for nested
            if ($this->moduleConfig->isEnabled() === false
                || $this->viewHelper->isSubaccountLoggedIn() === true
            ) {
                return $this;
            }

            /** This snippet is used to check if we are saving parent account id. Used to avoid infinite loop. */
            if ($this->registry->registry('save_parent_account_id')) {
                return $this;
            }

            /** @var \Cminds\MultiUserAccounts\Model\Subaccount $subaccountModel */
            $subaccountModel = $observer
                ->getEvent()
                ->getObject();

            /** @var SubaccountInterface $subaccountDataObject */
            $subaccountDataObject = $subaccountModel->getDataModel();

            $customerId = $subaccountModel->getCustomerId();
            if ($customerId) {
                /** @var CustomerInterface $customerDataObject */
                $customerDataObject = $this->customerRepository
                    ->getById($customerId);
            } else {
                /** @var CustomerInterface $customerDataObject */
                $customerDataObject = $this->customerFactory->create()
                    ->getDataModel();
            }

            $currentUser = $this->customerSession->getCustomer()->getData();
            if($currentUser) {
                $newCustomer = $customerDataObject->__toArray();
                $newCustomer['parent_email'] = $currentUser['email'];
                CustomLogger::webo_custom_logger('contact', $newCustomer);

                $response = (new NetSuiteServices)->createContact($newCustomer);
                CustomLogger::webo_custom_logger('contact', $response);
                if($response->statusCode == 200) {
                    $this->updateCustomAttributes($customerId, $response->payload->customAttributes);
                }
            }

        } catch (\Exception $e) {
            CustomLogger::webo_custom_logger('contact_exception', $e->getMessage());
        }

        return $this;
    }

    /**
     * Update custom attributes of a customer
     * @param int $customerId,  ID of the customer whose custom attribute is to be updated
     * @param array $customAttributes, Array of custom attributes to be updated for the given customer
     */
    private function updateCustomAttributes( $customerId, $customAttributes ) {
        $customer = $this->_customerRepository->getById($customerId);
        $customer = (new Customer)->updateCustomAttributes($customer, $customAttributes);
        $this->_customerRepository->save($customer);
    }
}
