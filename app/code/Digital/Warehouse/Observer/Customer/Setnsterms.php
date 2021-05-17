<?php

namespace Digital\Warehouse\Observer\Customer;

use Magento\Framework\Event\ObserverInterface;

class Setnsterms implements ObserverInterface
{
    
    protected $_customerRepositoryInterface;

    public function __construct(
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
    ) {
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $customer = $observer->getEvent()->getCustomer();        
        $customer->setCustomAttribute('ns_terms','Prepaid');
        $this->_customerRepositoryInterface->save($customer);     
    }
}