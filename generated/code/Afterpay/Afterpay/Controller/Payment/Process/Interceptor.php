<?php
namespace Afterpay\Afterpay\Controller\Payment\Process;

/**
 * Interceptor class for @see \Afterpay\Afterpay\Controller\Payment\Process
 */
class Interceptor extends \Afterpay\Afterpay\Controller\Payment\Process implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Sales\Model\OrderFactory $orderFactory, \Magento\Quote\Model\QuoteFactory $quoteFactory, \Afterpay\Afterpay\Model\Config\Payovertime $afterpayConfig, \Afterpay\Afterpay\Model\Adapter\V1\AfterpayOrderTokenV1 $afterpayOrderTokenV1, \Magento\Framework\Json\Helper\Data $jsonHelper, \Afterpay\Afterpay\Helper\Data $helper, \Magento\Checkout\Model\Cart $cart, \Magento\Store\Model\StoreResolver $storeResolver, \Magento\Quote\Model\ResourceModel\Quote $quoteRepository, \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory)
    {
        $this->___init();
        parent::__construct($context, $checkoutSession, $orderFactory, $quoteFactory, $afterpayConfig, $afterpayOrderTokenV1, $jsonHelper, $helper, $cart, $storeResolver, $quoteRepository, $jsonResultFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        if (!$pluginInfo) {
            return parent::execute();
        } else {
            return $this->___callPlugins('execute', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        if (!$pluginInfo) {
            return parent::dispatch($request);
        } else {
            return $this->___callPlugins('dispatch', func_get_args(), $pluginInfo);
        }
    }
}
