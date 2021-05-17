<?php
namespace Cminds\MultiUserAccounts\Controller\Account\EditPost;

/**
 * Interceptor class for @see \Cminds\MultiUserAccounts\Controller\Account\EditPost
 */
class Interceptor extends \Cminds\MultiUserAccounts\Controller\Account\EditPost implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \Magento\Customer\Api\AccountManagementInterface $customerAccountManagement, \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator, \Cminds\MultiUserAccounts\Api\SubaccountTransportRepositoryInterface $subaccountTransportRepository, \Cminds\MultiUserAccounts\Helper\View $viewHelper, \Cminds\MultiUserAccounts\Model\Config $moduleConfig, \Magento\Customer\Model\CustomerExtractor $customerExtractor)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $customerAccountManagement, $customerRepository, $formKeyValidator, $subaccountTransportRepository, $viewHelper, $moduleConfig, $customerExtractor);
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
