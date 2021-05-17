<?php

namespace Zdcs\Digital\Plugin\Carrier;

use Magento\Quote\Api\Data\ShippingMethodExtensionFactory;

/**
 * Class Description
 *
 */
class Description
{
    /**
     * @var ShippingMethodExtensionFactory
     */
    protected $extensionFactory;

    /**
     * Description constructor.
     * @param ShippingMethodExtensionFactory $extensionFactory
     */
    public function __construct(
        ShippingMethodExtensionFactory $extensionFactory,
        \Magento\Framework\App\ResourceConnection $_resourceconnection
    )
    {
        $this->extensionFactory = $extensionFactory;
        $this->_resourceconnection = $_resourceconnection;
    }

    /**
     * @param $subject
     * @param $result
     * @param $rateModel
     * @return mixed
     */
    public function afterModelToDataObject($subject, $result, $rateModel)
    {
        $extensionAttribute = $result->getExtensionAttributes() ?
            $result->getExtensionAttributes()
            :
            $this->extensionFactory->create()
        ;
        $method_code = $rateModel->getMethod();
        $shipping_description = '';
        $method_code_new = preg_replace('/[^0-9]/', '', $method_code);
        if($method_code_new)
        {
            $resource = $this->_resourceconnection;
            $readConnection = $resource->getConnection('core_read');
            $query_get_zone = "SELECT * FROM `digital_matrixrate` WHERE `internal_id`='".$method_code_new."'";
            $results_get_zone = $readConnection->fetchAll($query_get_zone);

            if(count($results_get_zone)>0)
            {
                $shipping_description = $results_get_zone[0]['shipping_description'];
            }
        }

		if($method_code == 'dcsshipping_standard')
		{
			$shipping_description = 'This shipping option must be selected for all Regional, Oversized or Special Requirement deliveries. Orders will be automatically classified as Regional and/or Oversized based on Items ordered or Delivery location specified. Shipping charges will be calculated and processed by our Customer First team after completing your online order.';
		}

        $extensionAttribute->setTitle($shipping_description);
        $result->setExtensionAttributes($extensionAttribute);
        return $result;
    }
}
