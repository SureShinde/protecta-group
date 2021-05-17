<?php

namespace Digital\Contactus\Model\ResourceModel;

/**
 * Contactus Resource Model
 */
class Contactus extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('digital_contactus', 'contactus_id');
    }
}
