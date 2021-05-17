<?php

/**
 * Warehouse Resource Collection
 */
namespace Digital\Warehouse\Model\ResourceModel\Warehouse;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Digital\Warehouse\Model\Warehouse', 'Digital\Warehouse\Model\ResourceModel\Warehouse');
    }
}
