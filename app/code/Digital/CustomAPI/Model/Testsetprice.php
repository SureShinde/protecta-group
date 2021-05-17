<?php

namespace Digital\CustomAPI\Model;

class Testsetprice implements \Digital\CustomAPI\Api\TestsetpriceInterface
{   
	
	/**
      * setcustomerpricing function
      *
      * @api
      * @param mixed $param
      * @return array
     */
    
    public function setcustomerpricing($param)
    {
		$customerId = trim($param['customerId']);
		$item_array = $param['itemPricing'];
		$result = array();
		
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		
		if($customerId > 0 && count($item_array)>0)
		{
			$customer = $objectManager->create('Magento\Customer\Model\Customer')->load($customerId);
			$cust_name = $customer->getName();
			$cust_email = $customer->getEmail();
			
			
				$Customerprice_discount_already = $objectManager->create('Magedelight\Customerprice\Model\Customerprice')->getCollection()->addFieldToFilter('customer_id', array('eq' => $customerId));
				if(count($Customerprice_discount_already)>0)  /// update existing row
				{
						foreach($Customerprice_discount_already as $disc_item)
						{
							$disc_item->delete();
						}
				}
			
			
			foreach($item_array as $item)
			{
				$itemId = trim($item['itemId']);
				$new_price = trim($item['price']);
				if(isset($item['qty']))
				{
					$qty = trim($item['qty']);
				}
				else
				{
					$qty = 1;
				}
								
				$product = $objectManager->create('Magento\Catalog\Model\Product')->load($itemId);
				$prod_name = $product->getName();
				$prod_price = $product->getPrice();
				
				if($cust_name!='' && $cust_email!='' && $prod_name!='')
				{
												   
						$Customerprice_discount = $objectManager->create('Magedelight\Customerprice\Model\Customerprice')->getCollection()
							->addFieldToFilter('customer_id', array('eq' => $customerId))
							->addFieldToFilter('product_id', array('eq' => $itemId))
							->addFieldToFilter('qty', array('eq' => $qty))
						;
						if(count($Customerprice_discount)>0)  /// update existing row
						{
							foreach($Customerprice_discount as $single_item)
							{
								if(isset($single_item['customerprice_id']))
								{
									$model_load = '';
									$model_load = $objectManager->create('Magedelight\Customerprice\Model\Customerprice');
									$model_load->load($single_item['customerprice_id']);
									$model_load->setLogPrice($new_price);
									$model_load->setNewPrice($new_price);
									$model_load->save();
									$model_load = '';
								}
							}
						}
						else  /// create new row
						{
							
							$model_create = '';
							$model_create = $objectManager->create('Magedelight\Customerprice\Model\Customerprice');
							$model_create->setCustomerId($customerId);
							$model_create->setCustomerName($cust_name);
							$model_create->setCustomerEmail($cust_email);
							$model_create->setProductId($itemId);
							$model_create->setProductName($prod_name);
							$model_create->setPrice($prod_price);
							$model_create->setLogPrice($new_price);
							$model_create->setNewPrice($new_price);
							$model_create->setQty($qty);
							$model_create->save();
							$model_create = '';
						}
				}				
				
			}
			$result['status'] = 'success';
		}
		else
		{
			$result['status'] = 'error';
		}
		
		return $result;	
    }	
}