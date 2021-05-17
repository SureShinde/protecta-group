<?php

namespace Digital\CustomAPI\Model;

class CustomerGroup implements \Digital\CustomAPI\Api\CustomerGroupInterface
{    
    /**
     * Get Customer Groups function
     *
     * @api
     * @param string $param
     * @return string
     */
    public function getcustomergroups($param)
    {

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $groupOptions = $objectManager->get('\Magento\Customer\Model\ResourceModel\Group\Collection')->toOptionArray();
        
        return $groupOptions;
        
    }	
}