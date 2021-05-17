<?php

namespace Digital\CustomAPI\Observer\Customer\RegisterSuccess;

use Magento\Framework\Event\Observer;
use Digital\CustomAPI\Services\Customer;
use Digital\CustomAPI\Helper\CustomLogger;
use Magento\Framework\Event\ObserverInterface;
use Digital\CustomAPI\Services\NetSuiteServices;
use Magento\Customer\Api\CustomerRepositoryInterface;

class SyncCustomerToNetsuite implements ObserverInterface
{
    /**
     * @var CustomerRepositoryInterface
     */
    private $_customerRepository;

    public function __construct(
        CustomerRepositoryInterface $customerRepositoryInterface
    ) {
        $this->_customerRepository = $customerRepositoryInterface;
    }

    public function execute(Observer $observer)
    {
        $customerObj = $observer->getEvent()->getCustomer();
        $customer = $this->_customerRepository->getById($customerObj->getId());

        $newCustomer = $customer->__toArray();
        CustomLogger::webo_custom_logger('register_customer', $newCustomer);
        try {
            $response = (new NetSuiteServices)->createCustomer($newCustomer);
            CustomLogger::webo_custom_logger('register_customer', $response);
            if($response->statusCode == 200) {
                $this->updateCustomAttributes($newCustomer['id'], $response->payload->customAttributes);
            }
        } catch (\Exception $e) {
            CustomLogger::webo_custom_logger('customer_exception', $e->getMessage());
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
