<?php
namespace Dcs\CustomShippingPrice\Model\ResourceModel;

class CustomShippingZone extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('digital_zone', 'id');
    }
}