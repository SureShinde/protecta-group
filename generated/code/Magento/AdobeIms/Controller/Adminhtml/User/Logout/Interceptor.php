<?php
namespace Magento\AdobeIms\Controller\Adminhtml\User\Logout;

/**
 * Interceptor class for @see \Magento\AdobeIms\Controller\Adminhtml\User\Logout
 */
class Interceptor extends \Magento\AdobeIms\Controller\Adminhtml\User\Logout implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\AdobeImsApi\Api\LogOutInterface $logOut)
    {
        $this->___init();
        parent::__construct($context, $logOut);
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
