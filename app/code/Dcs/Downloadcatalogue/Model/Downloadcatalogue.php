<?php

namespace Dcs\Downloadcatalogue\Model;

//use Dcs\Downloadcatalogue\Api\Data\GridInterface;

/**
 * Downloadcatalogue Model
 *
 * @method \Dcs\Downloadcatalogue\Model\Resource\Page _getResource()
 * @method \Dcs\Downloadcatalogue\Model\Resource\Page getResource()
 */
class Downloadcatalogue extends \Magento\Framework\Model\AbstractModel //implements GridInterface
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Dcs\Downloadcatalogue\Model\ResourceModel\Downloadcatalogue');
    }

	
}
