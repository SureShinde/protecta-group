<?php
namespace Dcs\Productenquiry\Controller\Index\Save;

/**
 * Interceptor class for @see \Dcs\Productenquiry\Controller\Index\Save
 */
class Interceptor extends \Dcs\Productenquiry\Controller\Index\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Controller\ResultFactory $resultFactory, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\UrlInterface $urlBuilder, \Dcs\Productenquiry\Helper\Data $helperProductenquiry, \Dcs\Productenquiry\Model\Productenquiry $productenquiry, \Dcs\Productenquiry\Helper\Email $emailHelper)
    {
        $this->___init();
        parent::__construct($context, $resultFactory, $checkoutSession, $storeManager, $urlBuilder, $helperProductenquiry, $productenquiry, $emailHelper);
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
