<?php

namespace Dcs\Productenquiry\Model\ResourceModel\Productenquiry;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
  $this->_init('Dcs\Productenquiry\Model\Productenquiry', 'Dcs\Productenquiry\Model\ResourceModel\Productenquiry');
    }
}
