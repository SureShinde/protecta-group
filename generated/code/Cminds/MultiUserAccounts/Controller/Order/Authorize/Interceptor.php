<?php
namespace Cminds\MultiUserAccounts\Controller\Order\Authorize;

/**
 * Interceptor class for @see \Cminds\MultiUserAccounts\Controller\Order\Authorize
 */
class Interceptor extends \Cminds\MultiUserAccounts\Controller\Order\Authorize implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Cminds\MultiUserAccounts\Model\Config $moduleConfig, \Magento\Quote\Model\QuoteFactory $quoteFactory, \Cminds\MultiUserAccounts\Model\Service\Order\ApproveRequest $approveRequest, \Magento\Customer\Model\Session\Proxy $customerSession, \Cminds\MultiUserAccounts\Helper\View $viewHelper)
    {
        $this->___init();
        parent::__construct($context, $moduleConfig, $quoteFactory, $approveRequest, $customerSession, $viewHelper);
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
