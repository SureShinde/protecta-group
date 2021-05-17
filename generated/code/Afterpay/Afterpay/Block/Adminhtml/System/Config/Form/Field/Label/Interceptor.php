<?php
namespace Afterpay\Afterpay\Block\Adminhtml\System\Config\Form\Field\Label;

/**
 * Interceptor class for @see \Afterpay\Afterpay\Block\Adminhtml\System\Config\Form\Field\Label
 */
class Interceptor extends \Afterpay\Afterpay\Block\Adminhtml\System\Config\Form\Field\Label implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Afterpay\Afterpay\Helper\Data $helper)
    {
        $this->___init();
        parent::__construct($context, $helper);
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
