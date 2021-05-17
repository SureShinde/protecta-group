<?php
namespace Cminds\MultiUserAccounts\Controller\Adminhtml\Customer\Approve;

/**
 * Interceptor class for @see \Cminds\MultiUserAccounts\Controller\Adminhtml\Customer\Approve
 */
class Interceptor extends \Cminds\MultiUserAccounts\Controller\Adminhtml\Customer\Approve implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Cminds\MultiUserAccounts\Model\Config $moduleConfig, \Magento\Framework\AuthorizationInterface $authorization, \Magento\Customer\Model\ResourceModel\CustomerRepository $customerRepository)
    {
        $this->___init();
        parent::__construct($context, $moduleConfig, $authorization, $customerRepository);
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
