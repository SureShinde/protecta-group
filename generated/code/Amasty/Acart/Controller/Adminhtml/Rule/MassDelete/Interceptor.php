<?php
namespace Amasty\Acart\Controller\Adminhtml\Rule\MassDelete;

/**
 * Interceptor class for @see \Amasty\Acart\Controller\Adminhtml\Rule\MassDelete
 */
class Interceptor extends \Amasty\Acart\Controller\Adminhtml\Rule\MassDelete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Psr\Log\LoggerInterface $logger, \Magento\Ui\Component\MassAction\Filter $filter, \Amasty\Acart\Model\ResourceModel\Rule\CollectionFactory $collectionFactory)
    {
        $this->___init();
        parent::__construct($context, $logger, $filter, $collectionFactory);
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
