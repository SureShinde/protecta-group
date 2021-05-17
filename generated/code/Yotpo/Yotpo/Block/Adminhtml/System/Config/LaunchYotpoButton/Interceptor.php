<?php
namespace Yotpo\Yotpo\Block\Adminhtml\System\Config\LaunchYotpoButton;

/**
 * Interceptor class for @see \Yotpo\Yotpo\Block\Adminhtml\System\Config\LaunchYotpoButton
 */
class Interceptor extends \Yotpo\Yotpo\Block\Adminhtml\System\Config\LaunchYotpoButton implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Yotpo\Yotpo\Model\Config $yotpoConfig, \Magento\Framework\App\Request\Http $request, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $yotpoConfig, $request, $data);
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