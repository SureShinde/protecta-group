<?php

namespace Dcs\Easypathhints\Model\TemplateEngine\Plugin;

use Magento\Developer\Helper\Data as DevHelper;
use Magento\Developer\Model\TemplateEngine\Decorator\DebugHintsFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\TemplateEngineFactory;
use Magento\Framework\View\TemplateEngineInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Dcs\Easypathhints\Helper\Data as EasypathhintsHelper;

class DebugHints
{
    /**
     * XPath of configuration of the debug block names
     */
    const XML_PATH_DEBUG_TEMPLATE_HINTS_BLOCKS = 'dev/debug/template_hints_blocks';
    
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var DevHelper
     */
    protected $devHelper;

    /**
     * @var DebugHintsFactory
     */
    protected $debugHintsFactory;

    /**
     * XPath of configuration of the debug hints
     *
     * Allowed values:
     *     dev/debug/template_hints_storefront
     *     dev/debug/template_hints_admin
     *
     * @var string
     */
    protected $debugHintsPath;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param DevHelper $devHelper
     * @param DebugHintsFactory $debugHintsFactory
     * @param string $debugHintsPath
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        DevHelper $devHelper,
        DebugHintsFactory $debugHintsFactory,
        EasypathhintsHelper $helper,
        $debugHintsPath
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->devHelper = $devHelper;
        $this->_helper          = $helper;
        $this->debugHintsFactory = $debugHintsFactory;
        $this->debugHintsPath = $debugHintsPath;        
    }

    /**
     * Wrap template engine instance with the debugging hints decorator, depending of the store configuration
     *
     * @param TemplateEngineFactory $subject
     * @param TemplateEngineInterface $invocationResult
     *
     * @return TemplateEngineInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterCreate(
        TemplateEngineFactory $subject,
        TemplateEngineInterface $invocationResult
    ) {
        $storeCode = $this->storeManager->getStore()->getCode();
        if (($this->scopeConfig->getValue($this->debugHintsPath, ScopeInterface::SCOPE_STORE, $storeCode)
            && $this->devHelper->isDevAllowed()) || $this->_helper->shouldShowTemplatePathHints()) {
            $showBlockHints = $this->scopeConfig->getValue(
                self::XML_PATH_DEBUG_TEMPLATE_HINTS_BLOCKS,
                ScopeInterface::SCOPE_STORE,
                $storeCode
            );
            if(!$showBlockHints && $this->_helper->shouldShowTemplatePathHints()){
                $showBlockHints = true;
            }
            return $this->debugHintsFactory->create([
                'subject' => $invocationResult,
                'showBlockHints' => $showBlockHints,
            ]);
        }
        return $invocationResult;
    }
}
