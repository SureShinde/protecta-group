<?php
namespace Cminds\MultiUserAccounts\Controller\Adminhtml\Manage\Save;

/**
 * Interceptor class for @see \Cminds\MultiUserAccounts\Controller\Adminhtml\Manage\Save
 */
class Interceptor extends \Cminds\MultiUserAccounts\Controller\Adminhtml\Manage\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Cminds\MultiUserAccounts\Api\SubaccountTransportRepositoryInterface $subaccountTransportRepository, \Cminds\MultiUserAccounts\Api\Data\SubaccountTransportInterfaceFactory $subaccountTransportDataFactory, \Cminds\MultiUserAccounts\Model\AccountManagement $customerAccountManagement, \Magento\Customer\Model\CustomerRegistry $customerRegistry, \Magento\Framework\Reflection\DataObjectProcessor $dataProcessor, \Magento\Framework\Api\DataObjectHelper $dataObjectHelper, \Cminds\MultiUserAccounts\Model\Permission $permission)
    {
        $this->___init();
        parent::__construct($context, $subaccountTransportRepository, $subaccountTransportDataFactory, $customerAccountManagement, $customerRegistry, $dataProcessor, $dataObjectHelper, $permission);
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
