<?php

namespace Digital\Contactus\Model;

/**
 * Contactus Model
 *
 * @method \Digital\Contactus\Model\Resource\Page _getResource()
 * @method \Digital\Contactus\Model\Resource\Page getResource()
 */
class Contactus extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Digital\Contactus\Model\ResourceModel\Contactus');
    }

}
