<?php
namespace Meetanshi\Eway\Controller\Order\Cancel;

/**
 * Interceptor class for @see \Meetanshi\Eway\Controller\Order\Cancel
 */
class Interceptor extends \Meetanshi\Eway\Controller\Order\Cancel implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Payment\Gateway\Command\CommandPoolInterface $commandPool, \Psr\Log\LoggerInterface $logger, \Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Magento\Payment\Gateway\Data\PaymentDataObjectFactory $paymentDataObjectFactory, \Magento\Checkout\Model\Session $checkoutSession)
    {
        $this->___init();
        parent::__construct($context, $commandPool, $logger, $orderRepository, $paymentDataObjectFactory, $checkoutSession);
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
