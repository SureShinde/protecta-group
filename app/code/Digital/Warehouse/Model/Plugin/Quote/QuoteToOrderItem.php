<?php
namespace Digital\Warehouse\Model\Plugin\Quote;
use Closure;
class QuoteToOrderItem
{
  public function aroundConvert(
        \Magento\Quote\Model\Quote\Item\ToOrderItem $subject,
        Closure $proceed,
        \Magento\Quote\Model\Quote\Item\AbstractItem $item,
        $additional = []
    ) {

        $orderItem = $proceed($item, $additional);
	  	$orderItem->setLocation($item->getLocation()); 
        return $orderItem;
    }
}
?>