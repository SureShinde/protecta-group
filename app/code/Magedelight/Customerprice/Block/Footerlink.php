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

namespace Magedelight\Customerprice\Block;

class Footerlink extends \Magento\Framework\View\Element\Html\Link
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param \Magento\Framework\View\Element\Template\Context   $context
     * @param array                                              $data
     */
    public function __construct(
    \Magento\Framework\View\Element\Template\Context $context,array $data = [])
    {
        parent::__construct($context, $data);
        $this->scopeConfig = $context->getScopeConfig();
    }

    public function getHref()
    {
        $ObjectManager= \Magento\Framework\App\ObjectManager::getInstance();
        $context = $ObjectManager->get('Magento\Framework\App\Http\Context');
        $isLoggedIn = $context->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);

        if ($isLoggedIn) {
            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $url = trim($this->scopeConfig->getValue('customerprice/general/identifier', $storeScope));

            return $this->getUrl($url);
        } else {
            return $this->getUrl('customer/account/login/');
        }
    }

    public function getLabel()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $label = $this->scopeConfig->getValue('customerprice/general/title', $storeScope);

        return __($label);
    }

    /**
     * {@inheritdoc}
     */
    protected function _toHtml()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $top_enable = $this->scopeConfig->getValue('customerprice/general/footer_enable', $storeScope);

        if (!$top_enable) {
            return '';
        }

        return parent::_toHtml();
    }
}
