<?php
namespace Magento\AdobeStockAdminUi\Controller\Adminhtml\System\Config\TestConnection;

/**
 * Interceptor class for @see \Magento\AdobeStockAdminUi\Controller\Adminhtml\System\Config\TestConnection
 */
class Interceptor extends \Magento\AdobeStockAdminUi\Controller\Adminhtml\System\Config\TestConnection implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\AdobeStockClientApi\Api\ClientInterface $client, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Magento\AdobeImsApi\Api\ConfigInterface $config)
    {
        $this->___init();
        parent::__construct($context, $client, $resultJsonFactory, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function execute() : \Magento\Framework\Controller\ResultInterface
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
