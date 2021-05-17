<?php

/**
 * Magedelight
* Copyright (C) 2017 Magedelight <info@magedelight.com>
*
* @category Magedelight
* @package Magedelight_Customerprice
* @copyright Copyright (c) 2017 Mage Delight (http://www.magedelight.com/)
* @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
* @author Magedelight <info@magedelight.com>
 */

namespace Magedelight\Customerprice\Model\Config\Backend;

/**
 * Backend model for shipping table rates CSV importing.
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Importcategory extends \Magento\Framework\App\Config\Value
{
    /**
     * @var \Magedelight\Customerprice\Model\ResourceModel\CustomerpriceFactory
     */
    protected $_customerpriceFactory;

    /**
     * @param \Magento\Framework\Model\Context                           $context
     * @param \Magento\Framework\Registry                                $registry
     * @param \Magento\Framework\App\Config\ScopeConfigInterface         $config
     * @param \Magento\Framework\App\Cache\TypeListInterface             $cacheTypeList
     * @param \Magedelight\Customerprice\Model\ResourceModel\CustomerpriceFactory $customerpriceFactory
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource    $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb              $resourceCollection
     * @param array                                                      $data
     */
    public function __construct(
    \Magento\Framework\Model\Context $context,
    \Magento\Framework\Registry $registry,
    \Magento\Framework\App\Config\ScopeConfigInterface $config,
    \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
    \Magedelight\Customerprice\Model\ResourceModel\CategorypriceFactory $categorypriceFactory,
    \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
    \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
    array $data = []
    ) {
        $this->_categorypriceFactory = $categorypriceFactory;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    /**
     * @return $this
     */
    public function afterSave()
    { 
        /** @var \Magento\OfflineShipping\Model\ResourceModel\Carrier\Tablerate $tableRate */
        $tableRate = $this->_categorypriceFactory->create();
        $tableRate->uploadAndImport($this);
        
         ///echo "hello";  exit();
        return parent::afterSave();
    }
}
