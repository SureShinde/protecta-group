<?php
namespace Amasty\Acart\Controller\Adminhtml\Rule\TestEmail;

/**
 * Interceptor class for @see \Amasty\Acart\Controller\Adminhtml\Rule\TestEmail
 */
class Interceptor extends \Amasty\Acart\Controller\Adminhtml\Rule\TestEmail implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\Acart\Model\RuleFactory $ruleFactory, \Amasty\Acart\Model\QuoteEmailFactory $quoteEmailFactory, \Magento\Quote\Model\QuoteFactory $quoteFactory, \Amasty\Acart\Model\RuleQuoteFromRuleAndQuoteFactory $ruleQuoteFactory, \Amasty\Acart\Model\ResourceModel\History\CollectionFactory $historyCollectionFactory, \Psr\Log\LoggerInterface $logger)
    {
        $this->___init();
        parent::__construct($context, $ruleFactory, $quoteEmailFactory, $quoteFactory, $ruleQuoteFactory, $historyCollectionFactory, $logger);
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
