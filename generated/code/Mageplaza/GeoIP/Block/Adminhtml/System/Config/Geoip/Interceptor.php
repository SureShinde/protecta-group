<?php
namespace Mageplaza\GeoIP\Block\Adminhtml\System\Config\Geoip;

/**
 * Interceptor class for @see \Mageplaza\GeoIP\Block\Adminhtml\System\Config\Geoip
 */
class Interceptor extends \Mageplaza\GeoIP\Block\Adminhtml\System\Config\Geoip implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Mageplaza\GeoIP\Helper\Data $helperData, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $helperData, $data);
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
