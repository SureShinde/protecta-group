<?php
namespace Ebizmarts\MailChimp\Controller\Adminhtml\Stores\Delete;

/**
 * Interceptor class for @see \Ebizmarts\MailChimp\Controller\Adminhtml\Stores\Delete
 */
class Interceptor extends \Ebizmarts\MailChimp\Controller\Adminhtml\Stores\Delete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Ebizmarts\MailChimp\Model\MailChimpStoresFactory $storesFactory, \Ebizmarts\MailChimp\Helper\Data $helper)
    {
        $this->___init();
        parent::__construct($context, $registry, $resultPageFactory, $storesFactory, $helper);
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
