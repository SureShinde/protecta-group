<?php
namespace Amasty\Acart\Controller\Adminhtml\Reports\Ajax;

/**
 * Interceptor class for @see \Amasty\Acart\Controller\Adminhtml\Reports\Ajax
 */
class Interceptor extends \Amasty\Acart\Controller\Adminhtml\Reports\Ajax implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Amasty\Acart\Model\StatisticsManagement $statisticsManagement, \Amasty\Acart\Model\Date $date, \Psr\Log\LoggerInterface $logger, \Magento\Store\Model\StoreManagerInterface $storeManager)
    {
        $this->___init();
        parent::__construct($context, $resultJsonFactory, $statisticsManagement, $date, $logger, $storeManager);
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
