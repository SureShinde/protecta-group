<?php
namespace Vertex\Tax\Block\Adminhtml\Config\Form\Field\FlexibleDateFields;

/**
 * Interceptor class for @see \Vertex\Tax\Block\Adminhtml\Config\Form\Field\FlexibleDateFields
 */
class Interceptor extends \Vertex\Tax\Block\Adminhtml\Config\Form\Field\FlexibleDateFields implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Vertex\Tax\Block\Adminhtml\Config\Form\Field\FlexibleFieldUtilities $utilities, \Vertex\Tax\Block\Adminhtml\Config\Form\Field\FieldSource\OptionProvider $optionProvider, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $utilities, $optionProvider, $data);
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
