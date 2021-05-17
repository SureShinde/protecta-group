<?php
namespace Dcs\CustomShippingPrice\Model\ResourceModel\CustomShippingPrice;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Dcs\CustomShippingPrice\Model\CustomShippingPrice', 'Dcs\CustomShippingPrice\Model\ResourceModel\CustomShippingPrice');
    }
}
