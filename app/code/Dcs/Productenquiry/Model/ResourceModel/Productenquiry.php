<?php

namespace Dcs\Productenquiry\Model\ResourceModel;

class Productenquiry extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('productenquiry', 'enquiry_id');
    }
}
