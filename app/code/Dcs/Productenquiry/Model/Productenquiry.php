<?php

namespace Dcs\Productenquiry\Model;


class Productenquiry extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Dcs\Productenquiry\Model\ResourceModel\Productenquiry');
    }

}
