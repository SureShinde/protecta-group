<?php

namespace Dcs\Downloadcatalogue\Model\ResourceModel;

/**
 * Downloadcatalogue Resource Model
 */
class Downloadcatalogue extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('dcs_downloadcatalogue', 'downloadcatalogue_id');
    }
}
