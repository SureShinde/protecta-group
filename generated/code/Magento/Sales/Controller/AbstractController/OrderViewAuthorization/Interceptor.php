<?php
namespace Magento\Sales\Controller\AbstractController\OrderViewAuthorization;

/**
 * Interceptor class for @see \Magento\Sales\Controller\AbstractController\OrderViewAuthorization
 */
class Interceptor extends \Magento\Sales\Controller\AbstractController\OrderViewAuthorization implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Customer\Model\Session $customerSession, \Magento\Sales\Model\Order\Config $orderConfig)
    {
        $this->___init();
        parent::__construct($customerSession, $orderConfig);
    }

    /**
     * {@inheritdoc}
     */
    public function canView(\Magento\Sales\Model\Order $order)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'canView');
        if (!$pluginInfo) {
            return parent::canView($order);
        } else {
            return $this->___callPlugins('canView', func_get_args(), $pluginInfo);
        }
    }
}
