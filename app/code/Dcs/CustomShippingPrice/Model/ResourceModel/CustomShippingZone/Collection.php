<?php
namespace Dcs\CustomShippingPrice\Model\ResourceModel\CustomShippingZone;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Dcs\CustomShippingPrice\Model\CustomShippingZone', 'Dcs\CustomShippingPrice\Model\ResourceModel\CustomShippingZone');
    }
}
