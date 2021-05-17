<?php
namespace Cminds\MultiUserAccounts\Controller\Order\Approve;

/**
 * Interceptor class for @see \Cminds\MultiUserAccounts\Controller\Order\Approve
 */
class Interceptor extends \Cminds\MultiUserAccounts\Controller\Order\Approve implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Cminds\MultiUserAccounts\Model\Config $moduleConfig, \Cminds\MultiUserAccounts\Helper\Email $emailHelper, \Magento\Customer\Model\CustomerRegistry $customerRegistry, \Magento\Quote\Model\QuoteFactory $quoteFactory, \Magento\Framework\DataObjectFactory $dataObjectFactory, \Cminds\MultiUserAccounts\Helper\View $viewHelper, \Cminds\MultiUserAccounts\Helper\OrderCreate $orderHelper, \Magento\Customer\Model\Session $customerSession, \Cminds\MultiUserAccounts\Api\SubaccountTransportRepositoryInterface $subaccountTransportRepositoryInterface)
    {
        $this->___init();
        parent::__construct($context, $moduleConfig, $emailHelper, $customerRegistry, $quoteFactory, $dataObjectFactory, $viewHelper, $orderHelper, $customerSession, $subaccountTransportRepositoryInterface);
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
