<?php
namespace Mageplaza\DeliveryTime\Block\Adminhtml\Config\Backend\DeliveryTime;

/**
 * Interceptor class for @see \Mageplaza\DeliveryTime\Block\Adminhtml\Config\Backend\DeliveryTime
 */
class Interceptor extends \Mageplaza\DeliveryTime\Block\Adminhtml\Config\Backend\DeliveryTime implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Framework\Data\Form\Element\Factory $elementFactory, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $elementFactory, $data);
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
