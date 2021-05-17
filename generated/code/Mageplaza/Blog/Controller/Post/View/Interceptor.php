<?php
namespace Mageplaza\Blog\Controller\Post\View;

/**
 * Interceptor class for @see \Mageplaza\Blog\Controller\Post\View
 */
class Interceptor extends \Mageplaza\Blog\Controller\Post\View implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\Json\Helper\Data $jsonHelper, \Mageplaza\Blog\Model\CommentFactory $commentFactory, \Mageplaza\Blog\Model\LikeFactory $likeFactory, \Magento\Framework\Stdlib\DateTime\DateTime $dateTime, \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone, \Mageplaza\Blog\Helper\Data $helperBlog, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Customer\Api\AccountManagementInterface $accountManagement, \Magento\Customer\Model\Url $customerUrl, \Magento\Customer\Model\Session $customerSession, \Mageplaza\Blog\Model\TrafficFactory $trafficFactory, \Mageplaza\Blog\Model\PostFactory $postFactory)
    {
        $this->___init();
        parent::__construct($context, $resultForwardFactory, $storeManager, $jsonHelper, $commentFactory, $likeFactory, $dateTime, $timezone, $helperBlog, $resultPageFactory, $accountManagement, $customerUrl, $customerSession, $trafficFactory, $postFactory);
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
