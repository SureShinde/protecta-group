<?php
namespace Dcs\Updateaccount\Model;

class Updateaccount extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Dcs\Updateaccount\Model\ResourceModel\Updateaccount');
    }

}
