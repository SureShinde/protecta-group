<?php
/**
 * Copyright © 2016 Dcs. All rights reserved.
 * See MS-LICENSE.txt for license details.
 */
namespace Dcs\CustomShippingPrice\Block\Adminhtml\System\Config\Fieldset;

use Magento\Backend\Block\Template;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Module\ModuleList\Loader;
use Dcs\CustomShippingPrice\Helper\Config as Helper;

class Hint extends Template implements RendererInterface
{
    /**
     * @var string
     */
   /* protected $_template = 'Dcs_CustomShippingPrice::system/config/fieldset/hint.phtml'; */
    
    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    protected $_metaData;
    
    /**
     * @var \Magento\Framework\Module\ModuleList\Loader
     */
    protected $_loader;

    /**
     * @var \Dcs\CustomShippingPrice\Helper\Config
     */
    protected $_helper;
    
    /**
     * @param Context $context
     * @param ProductMetadataInterface $productMetaData
     * @param Loader $loader
     * @param Helper $helper
     * @param array $data
     */
    public function __construct(
        Context $context,
        ProductMetadataInterface $productMetaData,
        Loader $loader,
        Helper $helper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_metaData = $productMetaData;
        $this->_loader = $loader;
        $this->_helper = $helper;
    }

    /**
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return mixed
     */
    public function render(AbstractElement $element)
    {
        return $this->toHtml();
    }

    public function getModuleName()
    {
        return $this->_helper->getConfigModule('module_name');
    }
    
    public function getVersion()
    {
        $modules = $this->_loader->load();
        $v = "";
        if (isset($modules['Dcs_CustomShippingPrice'])) {
            $v = "v" . $modules['Dcs_CustomShippingPrice']['setup_version'];
        }
        
        return $v;
    }

    public function getModulePage()
    {
        return $this->_helper->getConfigModule('module_page_link');
    }
}
