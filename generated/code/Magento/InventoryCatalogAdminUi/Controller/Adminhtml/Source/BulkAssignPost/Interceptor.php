<?php
namespace Magento\InventoryCatalogAdminUi\Controller\Adminhtml\Source\BulkAssignPost;

/**
 * Interceptor class for @see \Magento\InventoryCatalogAdminUi\Controller\Adminhtml\Source\BulkAssignPost
 */
class Interceptor extends \Magento\InventoryCatalogAdminUi\Controller\Adminhtml\Source\BulkAssignPost implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\InventoryCatalogApi\Api\BulkSourceAssignInterface $bulkSourceAssign, \Magento\InventoryCatalogAdminUi\Model\BulkSessionProductsStorage $bulkSessionProductsStorage, \Magento\InventoryCatalogAdminUi\Model\BulkOperationsConfig $bulkOperationsConfig, \Magento\AsynchronousOperations\Model\MassSchedule $massSchedule, \Psr\Log\LoggerInterface $logger)
    {
        $this->___init();
        parent::__construct($context, $bulkSourceAssign, $bulkSessionProductsStorage, $bulkOperationsConfig, $massSchedule, $logger);
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
