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

namespace Magedelight\Customerprice\Controller\Adminhtml\Index;

use Magento\Framework\App\ResponseInterface;
use Magento\Config\Controller\Adminhtml\System\ConfigSectionChecker;
use Magento\Framework\App\Filesystem\DirectoryList;

class Export extends \Magento\Config\Controller\Adminhtml\System\AbstractConfig
{
    /**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $_fileFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
    protected $_customerFactory;

    /**
     * @param \Magento\Backend\App\Action\Context                              $context
     * @param \Magento\Config\Model\Config\Structure                           $configStructure
     * @param \Magento\Config\Controller\Adminhtml\System\ConfigSectionChecker $sectionChecker
     * @param \Magento\Framework\App\Response\Http\FileFactory                 $fileFactory
     * @param \Magento\Store\Model\StoreManagerInterface                       $storeManager
     */
    public function __construct(
    \Magento\Backend\App\Action\Context $context, \Magento\Config\Model\Config\Structure $configStructure, ConfigSectionChecker $sectionChecker, \Magento\Framework\App\Response\Http\FileFactory $fileFactory, \Magento\Customer\Model\CustomerFactory $customerFactory, \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
        $this->_fileFactory = $fileFactory;
        $this->_customerFactory = $customerFactory;
        parent::__construct($context, $configStructure, $sectionChecker);
    }

    /**
     * Export shipping table rates in csv format.
     *
     * @return ResponseInterface
     */
    public function execute()
    {
        $fileName = 'pricepercustomer.csv';
        $content = '';
        $_columns = array(
            'email', 'sku', 'qty', 'price', 'website',
        );
        $data = array();
        foreach ($_columns as $column) {
            $data[] = '"'.$column.'"';
        }
        $content .= implode(',', $data)."\n";

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $pricePerCustomer = $objectManager->create('\Magedelight\Customerprice\Model\Customerprice')->getCollection();

        foreach ($pricePerCustomer as $_pricePerCustomer) {
            $product = $objectManager->get('Magento\Catalog\Model\Product')->load(trim($_pricePerCustomer['product_id']));

            $customer = $this->_customerFactory->create()->load(trim($_pricePerCustomer['customer_id']));

            $data = array();
            $data[] = trim($_pricePerCustomer->getCustomerEmail());
            $data[] = trim($product->getSku());
            $data[] = trim($_pricePerCustomer->getQty());
            $data[] = trim($_pricePerCustomer->getLogPrice());
            $data[] = trim($customer->getWebsiteId());

            $content .= implode(',', $data)."\n";
        }

        return $this->_fileFactory->create($fileName, $content, DirectoryList::VAR_DIR);
    }
}
