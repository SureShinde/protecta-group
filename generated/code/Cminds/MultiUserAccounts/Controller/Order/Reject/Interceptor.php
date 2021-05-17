<?php
namespace Cminds\MultiUserAccounts\Controller\Order\Reject;

/**
 * Interceptor class for @see \Cminds\MultiUserAccounts\Controller\Order\Reject
 */
class Interceptor extends \Cminds\MultiUserAccounts\Controller\Order\Reject implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Cminds\MultiUserAccounts\Model\Config $moduleConfig, \Cminds\MultiUserAccounts\Helper\Email $emailHelper, \Magento\Customer\Model\CustomerRegistry $customerRegistry, \Magento\Quote\Model\QuoteFactory $quoteFactory, \Magento\Framework\DataObjectFactory $dataObjectFactory)
    {
        $this->___init();
        parent::__construct($context, $moduleConfig, $emailHelper, $customerRegistry, $quoteFactory, $dataObjectFactory);
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
