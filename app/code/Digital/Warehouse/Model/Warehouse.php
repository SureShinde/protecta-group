<?php

namespace Digital\Warehouse\Model;

/**
 * Warehouse Model
 *
 * @method \Digital\Warehouse\Model\Resource\Page _getResource()
 * @method \Digital\Warehouse\Model\Resource\Page getResource()
 */
class Warehouse extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Digital\Warehouse\Model\ResourceModel\Warehouse');
    }

}
