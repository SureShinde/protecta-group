<?php
namespace Magento\Cms\Controller\Adminhtml\Block\Save;

/**
 * Interceptor class for @see \Magento\Cms\Controller\Adminhtml\Block\Save
 */
class Interceptor extends \Magento\Cms\Controller\Adminhtml\Block\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor, ?\Magento\Cms\Model\BlockFactory $blockFactory = null, ?\Magento\Cms\Api\BlockRepositoryInterface $blockRepository = null)
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $dataPersistor, $blockFactory, $blockRepository);
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
