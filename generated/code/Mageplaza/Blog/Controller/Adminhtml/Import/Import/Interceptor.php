<?php
namespace Mageplaza\Blog\Controller\Adminhtml\Import\Import;

/**
 * Interceptor class for @see \Mageplaza\Blog\Controller\Adminhtml\Import\Import
 */
class Interceptor extends \Mageplaza\Blog\Controller\Adminhtml\Import\Import implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Mageplaza\Blog\Model\Import\WordPress $wordPress, \Mageplaza\Blog\Model\Import\AheadWorksM1 $aheadWorksM1, \Mageplaza\Blog\Model\Import\MageFanM2 $mageFanM2, \Mageplaza\Blog\Helper\Data $blogHelper, \Magento\Framework\Registry $registry)
    {
        $this->___init();
        parent::__construct($context, $wordPress, $aheadWorksM1, $mageFanM2, $blogHelper, $registry);
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
