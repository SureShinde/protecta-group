<?php

/**
 * Downloadcatalogue Resource Collection
 */
namespace Dcs\Downloadcatalogue\Model\ResourceModel\Downloadcatalogue;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Dcs\Downloadcatalogue\Model\Downloadcatalogue', 'Dcs\Downloadcatalogue\Model\ResourceModel\Downloadcatalogue');
    }
}
