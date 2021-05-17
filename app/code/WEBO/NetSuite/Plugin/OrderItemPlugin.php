<?php
namespace WEBO\NetSuite\Plugin;

use WEBO\NetSuite\Helper\CustomLogger;


class OrderItemPlugin {

    /**
     * @var \Magento\Sales\Api\Data\OrderItemExtensionFactory
     */
    private $orderItemExtensionFactory;
    private $productFactory;

    public function __construct(
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\App\ResourceConnection $_resourceconnection,
        \Dcs\CustomShippingPrice\Model\Carrier\CustomShipping $_customShipping,
        \Magento\Sales\Api\Data\OrderItemExtensionFactory $orderItemExtensionFactory

    ) {
        $this->productFactory = $productFactory;
        $this->_resourceconnection = $_resourceconnection;
        $this->_customShipping = $_customShipping;
        $this->orderItemExtensionFactory = $orderItemExtensionFactory;
    }
    public function afterGetExtensionAttributes(\Magento\Sales\Api\Data\OrderItemInterface $subject, $result)
    {
        $final_result = '';

        $zone_number = $subject->getPgDeliveryZone();
        if($zone_number) /// zone number found....
        {

            $zone_row_array = $this->_customShipping->getCheckFirstPriority($zone_number);

            foreach($zone_row_array as $zone_item)
            {
                $region_name = $zone_item;  ///Perth    = WA, Brisbane = QLD, Melbourne = VIC, Sydney = NSW
                if($region_name)
                {
                    $final_result = $this->getCheckProductAvailableInStore($region_name,$subject);
                    if($final_result){ break; }
                }
            }
        }
        else   //// Pickup or no zone number found....
        {
            $current_selected_store = $subject->getPgDeliveryLocation();
            if($current_selected_store=='sydney')
            {
                $final_result = 'Silverwater PGA';
            }
            elseif($current_selected_store=='melbourne')
            {
                $final_result = 'Tullamarine PGA';
            }
            elseif($current_selected_store=='brisbane')
            {
                $final_result = 'Eagle Farm PGA';
            }
            elseif($current_selected_store=='perth')
            {
                $final_result = 'Canning Vale PGA';
            }
            else
            {
                $final_result = '';
            }
        }


        $orderItemExtension = $this->orderItemExtensionFactory->create();
        $orderItemExtension->setItemDeliveryLocation($final_result);
        $subject->setExtensionAttributes($orderItemExtension);
        return $result;
    }

    public function getCheckProductAvailableInStore($region_name,$item)
    {
        $cart_qty = $item->getQtyOrdered();

        $simple_product = $this->productFactory->create();
        $simple_product->load($item->getProductId());
        if($region_name=='NSW')
        {
            if($cart_qty <= $simple_product->getPgSydneyQty())
            {
                return 'Silverwater PGA';
            }
        }
        else if($region_name=='QLD')
        {
            if($cart_qty <= $simple_product->getPgBrisbaneQty())
            {
                return 'Eagle Farm PGA';
            }
        }
        else if($region_name=='VIC')
        {
            if($cart_qty <= $simple_product->getPgMelbourneQty())
            {
                return 'Tullamarine PGA';
            }
        }
        else if($region_name=='WA')
        {
            if($cart_qty <= $simple_product->getPgPerthQty())
            {
                return 'Canning Vale PGA';
            }
        }
        $simple_product = '';

        return;
    }
}
