<?php
namespace Dcs\CustomShippingPrice\Model\ResourceModel;

class CustomShippingPrice extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('digital_matrixrate', 'id');
    }
}