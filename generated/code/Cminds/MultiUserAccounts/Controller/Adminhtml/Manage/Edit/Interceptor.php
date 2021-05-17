<?php
namespace Cminds\MultiUserAccounts\Controller\Adminhtml\Manage\Edit;

/**
 * Interceptor class for @see \Cminds\MultiUserAccounts\Controller\Adminhtml\Manage\Edit
 */
class Interceptor extends \Cminds\MultiUserAccounts\Controller\Adminhtml\Manage\Edit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Cminds\MultiUserAccounts\Api\SubaccountTransportRepositoryInterface $subaccountTransportRepository, \Cminds\MultiUserAccounts\Api\Data\SubaccountTransportInterfaceFactory $subaccountTransportDataFactory, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Registry $registry)
    {
        $this->___init();
        parent::__construct($context, $subaccountTransportRepository, $subaccountTransportDataFactory, $resultPageFactory, $registry);
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
