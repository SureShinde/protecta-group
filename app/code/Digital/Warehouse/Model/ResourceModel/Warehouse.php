<?php

namespace Digital\Warehouse\Model\ResourceModel;

/**
 * Warehouse Resource Model
 */
class Warehouse extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('digital_warehouse', 'warehouse_id');
    }
}
