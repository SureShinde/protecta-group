<?php
namespace Ebizmarts\MailChimp\Controller\Adminhtml\Lists\Get;

/**
 * Interceptor class for @see \Ebizmarts\MailChimp\Controller\Adminhtml\Lists\Get
 */
class Interceptor extends \Ebizmarts\MailChimp\Controller\Adminhtml\Lists\Get implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Ebizmarts\MailChimp\Helper\Data $helper, \Magento\Framework\Encryption\Encryptor $encryptor)
    {
        $this->___init();
        parent::__construct($context, $helper, $encryptor);
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
