<?php
namespace Cminds\MultiUserAccounts\CustomerData\Customer;

/**
 * Interceptor class for @see \Cminds\MultiUserAccounts\CustomerData\Customer
 */
class Interceptor extends \Cminds\MultiUserAccounts\CustomerData\Customer implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer, \Magento\Customer\Helper\View $customerViewHelper, \Magento\Customer\Model\Session\Proxy $customerSession, \Cminds\MultiUserAccounts\Model\Config $moduleConfig, \Cminds\MultiUserAccounts\Helper\View $viewHelper)
    {
        $this->___init();
        parent::__construct($currentCustomer, $customerViewHelper, $customerSession, $moduleConfig, $viewHelper);
    }

    /**
     * {@inheritdoc}
     */
    public function getSectionData()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSectionData');
        if (!$pluginInfo) {
            return parent::getSectionData();
        } else {
            return $this->___callPlugins('getSectionData', func_get_args(), $pluginInfo);
        }
    }
}
