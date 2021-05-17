<?php
    
namespace Digital\Warehouse\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;

class Location implements ObserverInterface
{
	protected $_request;
	
	public function __construct(
    	\Magento\Framework\App\RequestInterface $request,
		\Magento\Catalog\Model\Product $product,
		\Digital\Warehouse\Helper\Data $helperWarehouse
	)
	{
		$this->_request = $request;
		$this->product = $product;
		$this->helperWarehouse = $helperWarehouse;
	}
	public function execute(\Magento\Framework\Event\Observer $observer) 
	{
		$item 	= $observer->getEvent()->getData('quote_item');         
		$item 	= ( $item->getParentItem() ? $item->getParentItem() : $item );
		
		//$this->_request->getParam('test'); 
		
		$_product = $this->product->load($item->getProduct()->getId()); 
		
		$qty = $item->getQty();
		
		$customerSession = $this->helperWarehouse->getCustomerSession();
		$selected_location = $customerSession->getLocationSession();
		if(isset($selected_location) && $selected_location!='')
		{			
				if($selected_location=='sydney')
				{
					if($qty <= $_product->getPgSydneyQty())
					{
						$item->setLocation($selected_location);
					}
					else
					{
						$item->setLocation('other');
					}
				}
				elseif($selected_location=='melbourne')
				{
					if($qty <= $_product->getPgMelbourneQty())
					{
						$item->setLocation($selected_location);
					}
					else
					{
						$item->setLocation('other');
					}
				}
				elseif($selected_location=='brisbane')
				{
					if($qty <= $_product->getPgBrisbaneQty())
					{
						$item->setLocation($selected_location);
					}
					else
					{
						$item->setLocation('other');
					}
				}
				elseif($selected_location=='perth')
				{
					if($qty <= $_product->getPgPerthQty())
					{
						$item->setLocation($selected_location);
					}
					else
					{
						$item->setLocation('other');
					}
				}
		}
		
		
	}
}

?>