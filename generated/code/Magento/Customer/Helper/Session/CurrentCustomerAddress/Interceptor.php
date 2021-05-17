<?php
namespace Magento\Customer\Helper\Session\CurrentCustomerAddress;

/**
 * Interceptor class for @see \Magento\Customer\Helper\Session\CurrentCustomerAddress
 */
class Interceptor extends \Magento\Customer\Helper\Session\CurrentCustomerAddress implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer, \Magento\Customer\Api\AccountManagementInterface $accountManagement)
    {
        $this->___init();
        parent::__construct($currentCustomer, $accountManagement);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultBillingAddress()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getDefaultBillingAddress');
        if (!$pluginInfo) {
            return parent::getDefaultBillingAddress();
        } else {
            return $this->___callPlugins('getDefaultBillingAddress', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultShippingAddress()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getDefaultShippingAddress');
        if (!$pluginInfo) {
            return parent::getDefaultShippingAddress();
        } else {
            return $this->___callPlugins('getDefaultShippingAddress', func_get_args(), $pluginInfo);
        }
    }
}
