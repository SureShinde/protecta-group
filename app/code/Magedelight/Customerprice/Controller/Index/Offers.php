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

namespace Magedelight\Customerprice\Controller\Index;


class Offers extends \Magento\Framework\App\Action\Action
{
    const MD_LAYER = 'mdlayer';
    protected $scopeConfig;    

    /**
     * @param \Magento\Framework\View\Result\PageFactory         $resultPageFactory
     * @param \Magento\Framework\DataObject                      $requestObject
     * @param \Magento\Framework\App\Action\Context              $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig     
     */
    public function __construct(
    \Magento\Framework\View\Result\PageFactory $resultPageFactory, 
    \Magento\Framework\DataObject $requestObject, 
    \Magento\Framework\App\Action\Context $context, 
    \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,     
    \Magento\Catalog\Model\Layer\Resolver $layerResolver
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->_requestObject = $requestObject;
        $this->scopeConfig = $scopeConfig;        
        $this->layerResolver = $layerResolver;
    }

    public function execute()
    {
        $this->layerResolver->create(self::MD_LAYER);
        $resultPage = $this->resultPageFactory->create();

        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $layout = $this->scopeConfig->getValue('customerprice/general/layout', $storeScope);

        if ($layout != 'empty') {
            $resultPage->getConfig()->addBodyClass('page-products');
        }
        if ($layout == '1column' || $layout == '3columns') {
            $resultPage->getConfig()->addBodyClass('page-with-filter');
        }

        $resultPage->getConfig()->setPageLayout($layout);

        $ObjectManager= \Magento\Framework\App\ObjectManager::getInstance();
        $context = $ObjectManager->get('Magento\Framework\App\Http\Context');
        $isLoggedIn = $context->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
        
        if ($isLoggedIn) {
            return $resultPage;
        } else {
            $resultRedirect = $this->resultRedirectFactory->create();

            return $resultRedirect->setPath('customer/account/login');
        }
    }
}
