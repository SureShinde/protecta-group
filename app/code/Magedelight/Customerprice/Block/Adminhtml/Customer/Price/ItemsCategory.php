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

namespace Magedelight\Customerprice\Block\Adminhtml\Customer\Price;

use Magento\Quote\Model\Quote\Item;

/**
 * Adminhtml sales order create items block.
 *
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class ItemsCategory extends \Magento\Sales\Block\Adminhtml\Order\Create\AbstractCreate
{
    /**
     * Contains button descriptions to be shown at the top of accordion.
     *
     * @var array
     */
    protected $_buttons = [];

    /**
     * Define block ID.
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('customer_category_items_items');
    }

    /**
     * Accordion header text.
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        return __('Price per customer by category');
    }

    /**
     * Returns all visible items.
     *
     * @return Item[]
     */
    public function getItems()
    {
        return $this->getQuote()->getAllVisibleItems();
    }

    /**
     * Add button to the items header.
     *
     * @param array $args
     */
    public function addButton($args)
    {
        $this->_buttons[] = $args;
    }

    public function getReadOnly()
    {
        return false;
    }

    /**
     * Return HTML code of the block.
     *
     * @return string
     */
    protected function _toHtml()
    {
        return parent::_toHtml();
    }
    
    public function getExistsCategory() {
        $customerId = $this->getRequest()->getParam('id');
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $optionCollection = $objectManager->create('\Magedelight\Customerprice\Model\Categoryprice')
                ->getCollection()
                ->addFieldToSelect('*')->addFieldToFilter('customer_id', array('eq' => $customerId))
                ->setOrder('category_id');
        $exists= [];
        foreach ($optionCollection as  $option) {   
            $exists[] = $option['category_id'];
        }
        return json_encode($exists);
    }
}
