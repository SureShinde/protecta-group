<?php
namespace Amasty\Acart\Block\Adminhtml\System\Config\Field\DisableLogging;

/**
 * Interceptor class for @see \Amasty\Acart\Block\Adminhtml\System\Config\Field\DisableLogging
 */
class Interceptor extends \Amasty\Acart\Block\Adminhtml\System\Config\Field\DisableLogging implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Amasty\Geoip\Model\Import $import, \Amasty\Geoip\Helper\Data $geoipHelper, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $import, $geoipHelper, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'render');
        if (!$pluginInfo) {
            return parent::render($element);
        } else {
            return $this->___callPlugins('render', func_get_args(), $pluginInfo);
        }
    }
}
