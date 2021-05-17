<?php
namespace Digital\Contactus\Controller\Index\Post;

/**
 * Interceptor class for @see \Digital\Contactus\Controller\Index\Post
 */
class Interceptor extends \Digital\Contactus\Controller\Index\Post implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Controller\ResultFactory $resultFactory, \Magento\Framework\Translate\Inline\StateInterface $StateInterface, \Magento\Store\Model\StoreManagerInterface $StoreManagerInterface, \Digital\Contactus\Helper\Data $helperContactus, \Digital\Contactus\Model\Contactus $_contactusModel, \Digital\Contactus\Helper\Email $emailHelper)
    {
        $this->___init();
        parent::__construct($context, $resultFactory, $StateInterface, $StoreManagerInterface, $helperContactus, $_contactusModel, $emailHelper);
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
