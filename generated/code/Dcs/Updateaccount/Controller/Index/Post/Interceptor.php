<?php
namespace Dcs\Updateaccount\Controller\Index\Post;

/**
 * Interceptor class for @see \Dcs\Updateaccount\Controller\Index\Post
 */
class Interceptor extends \Dcs\Updateaccount\Controller\Index\Post implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Controller\ResultFactory $resultFactory, \Magento\Framework\Translate\Inline\StateInterface $StateInterface, \Magento\Store\Model\StoreManagerInterface $StoreManagerInterface, \Dcs\Updateaccount\Helper\Data $helperUpdateaccount)
    {
        $this->___init();
        parent::__construct($context, $resultFactory, $StateInterface, $StoreManagerInterface, $helperUpdateaccount);
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
