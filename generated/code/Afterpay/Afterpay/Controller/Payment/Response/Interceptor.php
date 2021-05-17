<?php
namespace Afterpay\Afterpay\Controller\Payment\Response;

/**
 * Interceptor class for @see \Afterpay\Afterpay\Controller\Payment\Response
 */
class Interceptor extends \Afterpay\Afterpay\Controller\Payment\Response implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory, \Magento\Checkout\Model\Session $checkoutSession, \Afterpay\Afterpay\Model\Response $response, \Afterpay\Afterpay\Helper\Data $helper, \Afterpay\Afterpay\Model\Adapter\V1\AfterpayOrderDirectCapture $directCapture, \Afterpay\Afterpay\Model\Adapter\V1\AfterpayOrderTokenCheck $tokenCheck, \Magento\Framework\Json\Helper\Data $jsonHelper, \Afterpay\Afterpay\Model\Config\Payovertime $afterpayConfig, \Magento\Quote\Model\QuoteManagement $quoteManagement, \Magento\Sales\Model\Order\Payment\Transaction\BuilderInterface $transactionBuilder, \Magento\Sales\Model\Order\Email\Sender\OrderSender $orderSender, \Magento\Sales\Model\OrderRepository $orderRepository, \Magento\Sales\Model\Order\Payment\Repository $paymentRepository, \Magento\Sales\Model\Order\Payment\Transaction\Repository $transactionRepository)
    {
        $this->___init();
        parent::__construct($context, $resultForwardFactory, $checkoutSession, $response, $helper, $directCapture, $tokenCheck, $jsonHelper, $afterpayConfig, $quoteManagement, $transactionBuilder, $orderSender, $orderRepository, $paymentRepository, $transactionRepository);
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
