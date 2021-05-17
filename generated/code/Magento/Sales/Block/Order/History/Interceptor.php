<?php
namespace Magento\Sales\Block\Order\History;

/**
 * Interceptor class for @see \Magento\Sales\Block\Order\History
 */
class Interceptor extends \Magento\Sales\Block\Order\History implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory, \Magento\Customer\Model\Session $customerSession, \Magento\Sales\Model\Order\Config $orderConfig, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $orderCollectionFactory, $customerSession, $orderConfig, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrders()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getOrders');
        if (!$pluginInfo) {
            return parent::getOrders();
        } else {
            return $this->___callPlugins('getOrders', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getData($key = '', $index = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getData');
        if (!$pluginInfo) {
            return parent::getData($key, $index);
        } else {
            return $this->___callPlugins('getData', func_get_args(), $pluginInfo);
        }
    }
}
