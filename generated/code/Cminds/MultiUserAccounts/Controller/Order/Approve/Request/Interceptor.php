<?php
namespace Cminds\MultiUserAccounts\Controller\Order\Approve\Request;

/**
 * Interceptor class for @see \Cminds\MultiUserAccounts\Controller\Order\Approve\Request
 */
class Interceptor extends \Cminds\MultiUserAccounts\Controller\Order\Approve\Request implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Checkout\Model\Session\Proxy $checkoutSession, \Magento\Customer\Model\Session\Proxy $customerSession, \Cminds\MultiUserAccounts\Helper\View $viewHelper, \Cminds\MultiUserAccounts\Model\Config $moduleConfig, \Cminds\MultiUserAccounts\Model\Service\Order\ApproveRequest $approveRequestService)
    {
        $this->___init();
        parent::__construct($context, $checkoutSession, $customerSession, $viewHelper, $moduleConfig, $approveRequestService);
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
}
