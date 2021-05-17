<?php
namespace Cminds\MultiUserAccounts\Controller\Manage\Index;

/**
 * Interceptor class for @see \Cminds\MultiUserAccounts\Controller\Manage\Index
 */
class Interceptor extends \Cminds\MultiUserAccounts\Controller\Manage\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Cminds\MultiUserAccounts\Model\Config $moduleConfig, \Magento\Customer\Model\Session $customerSession, \Cminds\MultiUserAccounts\Helper\View $viewHelper)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $moduleConfig, $customerSession, $viewHelper);
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
