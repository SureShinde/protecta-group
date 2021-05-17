<?php

/**
 * Contactus Resource Collection
 */
namespace Digital\Contactus\Model\ResourceModel\Contactus;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Digital\Contactus\Model\Contactus', 'Digital\Contactus\Model\ResourceModel\Contactus');
    }
}
