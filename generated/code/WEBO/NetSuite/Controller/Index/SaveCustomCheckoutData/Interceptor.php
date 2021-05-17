<?php
namespace WEBO\NetSuite\Controller\Index\SaveCustomCheckoutData;

/**
 * Interceptor class for @see \WEBO\NetSuite\Controller\Index\SaveCustomCheckoutData
 */
class Interceptor extends \WEBO\NetSuite\Controller\Index\SaveCustomCheckoutData implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Json\Helper\Data $jsonHelper, \Magento\Framework\DataObjectFactory $dataObjectFactory, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Magento\Quote\Api\CartTotalRepositoryInterface $cartTotalRepositoryInterface, \Magento\Checkout\Model\Sidebar $sidebar)
    {
        $this->___init();
        parent::__construct($context, $jsonHelper, $dataObjectFactory, $resultJsonFactory, $cartTotalRepositoryInterface, $sidebar);
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
