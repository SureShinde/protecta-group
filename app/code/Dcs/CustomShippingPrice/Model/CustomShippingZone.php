<?php
namespace Dcs\CustomShippingPrice\Model;

class CustomShippingZone extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Dcs\CustomShippingPrice\Model\ResourceModel\CustomShippingZone');
    }

}
