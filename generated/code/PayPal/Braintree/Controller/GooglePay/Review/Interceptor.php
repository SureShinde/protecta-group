<?php
namespace PayPal\Braintree\Controller\GooglePay\Review;

/**
 * Interceptor class for @see \PayPal\Braintree\Controller\GooglePay\Review
 */
class Interceptor extends \PayPal\Braintree\Controller\GooglePay\Review implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \PayPal\Braintree\Model\GooglePay\Config $config, \Magento\Checkout\Model\Session $checkoutSession, \PayPal\Braintree\Model\GooglePay\Helper\QuoteUpdater $quoteUpdater)
    {
        $this->___init();
        parent::__construct($context, $config, $checkoutSession, $quoteUpdater);
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
