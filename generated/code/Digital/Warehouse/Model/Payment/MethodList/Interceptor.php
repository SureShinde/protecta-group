<?php
namespace Digital\Warehouse\Model\Payment\MethodList;

/**
 * Interceptor class for @see \Digital\Warehouse\Model\Payment\MethodList
 */
class Interceptor extends \Digital\Warehouse\Model\Payment\MethodList implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Payment\Helper\Data $paymentHelper, \Digital\Warehouse\Helper\Data $warehouse_helper, \Magento\Payment\Model\Checks\SpecificationFactory $specificationFactory)
    {
        $this->___init();
        parent::__construct($paymentHelper, $warehouse_helper, $specificationFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function getAvailableMethods(?\Magento\Quote\Api\Data\CartInterface $quote = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAvailableMethods');
        if (!$pluginInfo) {
            return parent::getAvailableMethods($quote);
        } else {
            return $this->___callPlugins('getAvailableMethods', func_get_args(), $pluginInfo);
        }
    }
}
