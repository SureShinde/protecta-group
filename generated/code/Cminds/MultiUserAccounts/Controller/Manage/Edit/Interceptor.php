<?php
namespace Cminds\MultiUserAccounts\Controller\Manage\Edit;

/**
 * Interceptor class for @see \Cminds\MultiUserAccounts\Controller\Manage\Edit
 */
class Interceptor extends \Cminds\MultiUserAccounts\Controller\Manage\Edit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session\Proxy $session, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Api\DataObjectHelper $dataObjectHelper, \Cminds\MultiUserAccounts\Api\SubaccountTransportRepositoryInterface $subaccountTransportRepository, \Cminds\MultiUserAccounts\Api\Data\SubaccountTransportInterfaceFactory $subaccountTransportDataFactory)
    {
        $this->___init();
        parent::__construct($context, $session, $resultPageFactory, $dataObjectHelper, $subaccountTransportRepository, $subaccountTransportDataFactory);
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
