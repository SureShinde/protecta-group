<?php
namespace Cminds\MultiUserAccounts\Controller\Manage\EditPost;

/**
 * Interceptor class for @see \Cminds\MultiUserAccounts\Controller\Manage\EditPost
 */
class Interceptor extends \Cminds\MultiUserAccounts\Controller\Manage\EditPost implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session\Proxy $customerSession, \Cminds\MultiUserAccounts\Api\SubaccountTransportRepositoryInterface $subaccountTransportRepository, \Cminds\MultiUserAccounts\Api\Data\SubaccountTransportInterfaceFactory $subaccountTransportDataFactory, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator, \Magento\Framework\Reflection\DataObjectProcessor $dataProcessor, \Magento\Framework\Api\DataObjectHelper $dataObjectHelper, \Cminds\MultiUserAccounts\Model\Permission $permission, \Cminds\MultiUserAccounts\Model\AccountManagement $customerAccountManagement, \Magento\Customer\Model\CustomerRegistry $customerRegistry, \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository, \Cminds\MultiUserAccounts\Model\Config $moduleConfig, \Cminds\MultiUserAccounts\Helper\View $viewHelper, \Cminds\MultiUserAccounts\Block\Manage\Table $manageList, \Magento\Customer\Model\CustomerFactory $customerFactory, \Cminds\MultiUserAccounts\Helper\Email $emailHelper)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $subaccountTransportRepository, $subaccountTransportDataFactory, $formKeyValidator, $dataProcessor, $dataObjectHelper, $permission, $customerAccountManagement, $customerRegistry, $customerRepository, $moduleConfig, $viewHelper, $manageList, $customerFactory, $emailHelper);
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
