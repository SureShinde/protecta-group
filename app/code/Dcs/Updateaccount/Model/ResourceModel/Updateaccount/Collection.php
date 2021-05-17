<?php
namespace Dcs\Updateaccount\Model\ResourceModel\Updateaccount;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Dcs\Updateaccount\Model\Updateaccount', 'Dcs\Updateaccount\Model\ResourceModel\Updateaccount');
    }
}
