<?php
namespace Dotdigitalgroup\Email\Block\Adminhtml\Config\Dynamic\Wishlist\Related;

/**
 * Interceptor class for @see \Dotdigitalgroup\Email\Block\Adminhtml\Config\Dynamic\Wishlist\Related
 */
class Interceptor extends \Dotdigitalgroup\Email\Block\Adminhtml\Config\Dynamic\Wishlist\Related implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Dotdigitalgroup\Email\Helper\Data $dataHelper)
    {
        $this->___init();
        parent::__construct($context, $dataHelper);
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
