<?php

namespace Digital\CustomAPI\Services;

use WEBO\NetSuite\Helper\CustomLogger;

class Customer {

    /**
     * Load all the customer groups from database
     */
    public function getAllCustomerGroup() {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $groupOptions = $objectManager->get('\Magento\Customer\Model\ResourceModel\Group\Collection')->toOptionArray();

        return $groupOptions;
    }

    /**
     * Matches the customers group from NetSuite to the customer group in database,
     * If match found returns the id of the group, else returs base price ID i.e 3
     * @param string $groupName, Customer group name set in NetSuite
     * @return int ID of the group the customer is associated with
     */
    public function getCustomerGroupId( $groupName ) {
        $customerGroup = $this->getAllCustomerGroup();
        if($customerGroup) {
            foreach($customerGroup as $customerGroup) {
                if(strtolower($customerGroup['label']) == strtolower($groupName)) {
                    return $customerGroup['value'];
                }
            }
        }

        return 3; //base price group id
    }

    /**
     * Update custom attributes of a customer
     * @param int $customer,  customer object whose custom attribute is to be updated
     * @param array $customAttributes, Array of custom attributes to be updated for the given customer
     */
    public function updateCustomAttributes( $customer, $customAttributes ) {
        foreach($customAttributes as $customAttribute) {
            if(isset($customAttribute->value)) {
                $customer->setCustomAttribute($customAttribute->attributeCode, $customAttribute->value);

                if($customAttribute->attributeCode == 'ns_price_level') {
                    $customerGroup = $this->getCustomerGroupId($customAttribute->value);
                    $customer->setGroupId($customerGroup);
                }
            }
        }

        return $customer;
    }
}
