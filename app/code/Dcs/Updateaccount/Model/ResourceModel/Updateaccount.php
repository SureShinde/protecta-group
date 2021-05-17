<?php
namespace Dcs\Updateaccount\Model\ResourceModel;

class Updateaccount extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('dcs_updateaccount', 'updateaccount_id');
    }
}