<?php
namespace Dotdigitalgroup\Email\Controller\Adminhtml\Cron\MassDelete;

/**
 * Interceptor class for @see \Dotdigitalgroup\Email\Controller\Adminhtml\Cron\MassDelete
 */
class Interceptor extends \Dotdigitalgroup\Email\Controller\Adminhtml\Cron\MassDelete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Cron\Model\ResourceModel\Schedule $collectionResource, \Magento\Backend\App\Action\Context $context, \Magento\Ui\Component\MassAction\Filter $filter, \Dotdigitalgroup\Email\Model\ResourceModel\Cron\CollectionFactory $collectionFactory)
    {
        $this->___init();
        parent::__construct($collectionResource, $context, $filter, $collectionFactory);
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
