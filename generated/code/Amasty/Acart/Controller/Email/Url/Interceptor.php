<?php
namespace Amasty\Acart\Controller\Email\Url;

/**
 * Interceptor class for @see \Amasty\Acart\Controller\Email\Url
 */
class Interceptor extends \Amasty\Acart\Controller\Email\Url implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Amasty\Acart\Model\UrlManager $urlManager, \Amasty\Acart\Model\RuleQuote $ruleQuote, \Amasty\Acart\Model\ResourceModel\RuleQuote $ruleQuoteResource, \Amasty\Acart\Model\ResourceModel\History\CollectionFactory $historyCollectionFactory, \Magento\Customer\Model\Session $customerSession, \Magento\Checkout\Model\SessionFactory $checkoutSessionFactory, \Magento\Customer\Model\CustomerFactory $customerFactory, \Magento\Quote\Model\QuoteFactory $quoteFactory, \Amasty\Acart\Model\App\Response\Redirect $redirect, \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager, \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $cookieMetadataFactory)
    {
        $this->___init();
        parent::__construct($context, $urlManager, $ruleQuote, $ruleQuoteResource, $historyCollectionFactory, $customerSession, $checkoutSessionFactory, $customerFactory, $quoteFactory, $redirect, $cookieManager, $cookieMetadataFactory);
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
