<?php
namespace Magefan\LoginAsCustomer\Controller\Adminhtml\Login\Login;

/**
 * Interceptor class for @see \Magefan\LoginAsCustomer\Controller\Adminhtml\Login\Login
 */
class Interceptor extends \Magefan\LoginAsCustomer\Controller\Adminhtml\Login\Login implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, ?\Magefan\LoginAsCustomer\Model\Login $loginModel = null, ?\Magento\Backend\Model\Auth\Session $authSession = null, ?\Magento\Store\Model\StoreManagerInterface $storeManager = null, ?\Magento\Framework\Url $url = null, ?\Magefan\LoginAsCustomer\Model\Config $config = null, ?\Magento\Customer\Api\CustomerRepositoryInterface $customerRepository = null)
    {
        $this->___init();
        parent::__construct($context, $loginModel, $authSession, $storeManager, $url, $config, $customerRepository);
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
