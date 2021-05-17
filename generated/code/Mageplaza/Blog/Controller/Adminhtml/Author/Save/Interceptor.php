<?php
namespace Mageplaza\Blog\Controller\Adminhtml\Author\Save;

/**
 * Interceptor class for @see \Mageplaza\Blog\Controller\Adminhtml\Author\Save
 */
class Interceptor extends \Mageplaza\Blog\Controller\Adminhtml\Author\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $registry, \Mageplaza\Blog\Model\AuthorFactory $authorFactory, \Mageplaza\Blog\Helper\Image $imageHelper)
    {
        $this->___init();
        parent::__construct($context, $registry, $authorFactory, $imageHelper);
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
