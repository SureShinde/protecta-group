<?php

namespace Digital\CustomAPI\Model;
class Test implements \Digital\CustomAPI\Api\TestInterface
{    
    /**
     * Test function
     *
     * @api
     * @param string $param
     * @return string
     */
    public function customerpricing($param)
    {
		$customerId = trim($param);
		$product_array = array();
		$result_array = array();
		$data = array();
		
		
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $Customerprice_discount = $objectManager->create('Magedelight\Customerprice\Model\Customerprice')->getCollection()
                ->addFieldToFilter('customer_id', array('eq' => $customerId))
               ;
		
		if(count($Customerprice_discount)>0){
			$i = 0;
			
			foreach($Customerprice_discount as $item){			
				$product_array[$i] = array(                
                    'itemId'        => $item['product_id'],
                    'price' => $item['new_price'],
                    'qty'     => $item['qty']					
					);				
				$i++;
			}
			
			
		}
		$data['customerId'] = $customerId;
		$data['itemPricing'] = $product_array;
		
		
        array_push($result_array, $data);
		
        return $result_array;
        
    }	
}