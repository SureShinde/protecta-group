<?php
namespace Digital\Warehouse\Controller\Index\Addtocart;

/**
 * Interceptor class for @see \Digital\Warehouse\Controller\Index\Addtocart
 */
class Interceptor extends \Digital\Warehouse\Controller\Index\Addtocart implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Controller\ResultFactory $resultFactory, \Magento\Framework\Translate\Inline\StateInterface $StateInterface, \Magento\Store\Model\StoreManagerInterface $StoreManagerInterface, \Digital\Warehouse\Helper\Data $helperWarehouse, \Digital\Warehouse\Model\Warehouse $_warehouseModel, \Magento\Framework\Data\Form\FormKey $formKey, \Magento\Checkout\Model\Cart $cart, \Magento\Catalog\Model\Product $product, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Digital\Warehouse\Helper\Email $emailHelper)
    {
        $this->___init();
        parent::__construct($context, $resultFactory, $StateInterface, $StoreManagerInterface, $helperWarehouse, $_warehouseModel, $formKey, $cart, $product, $resultJsonFactory, $emailHelper);
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
