<?php
namespace Magefan\LoginAsCustomer\Controller\Adminhtml\Login\Index;

/**
 * Interceptor class for @see \Magefan\LoginAsCustomer\Controller\Adminhtml\Login\Index
 */
class Interceptor extends \Magefan\LoginAsCustomer\Controller\Adminhtml\Login\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, ?\Magefan\LoginAsCustomer\Model\Login $loginModel = null)
    {
        $this->___init();
        parent::__construct($context, $loginModel);
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
