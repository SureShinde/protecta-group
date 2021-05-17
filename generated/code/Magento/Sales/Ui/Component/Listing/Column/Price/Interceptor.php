<?php
namespace Magento\Sales\Ui\Component\Listing\Column\Price;

/**
 * Interceptor class for @see \Magento\Sales\Ui\Component\Listing\Column\Price
 */
class Interceptor extends \Magento\Sales\Ui\Component\Listing\Column\Price implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\UiComponent\ContextInterface $context, \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory, \Magento\Framework\Pricing\PriceCurrencyInterface $priceFormatter, array $components = [], array $data = [], ?\Magento\Directory\Model\Currency $currency = null)
    {
        $this->___init();
        parent::__construct($context, $uiComponentFactory, $priceFormatter, $components, $data, $currency);
    }

    /**
     * {@inheritdoc}
     */
    public function prepare()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'prepare');
        if (!$pluginInfo) {
            return parent::prepare();
        } else {
            return $this->___callPlugins('prepare', func_get_args(), $pluginInfo);
        }
    }
}
