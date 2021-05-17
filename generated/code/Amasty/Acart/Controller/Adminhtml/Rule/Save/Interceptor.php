<?php
namespace Amasty\Acart\Controller\Adminhtml\Rule\Save;

/**
 * Interceptor class for @see \Amasty\Acart\Controller\Adminhtml\Rule\Save
 */
class Interceptor extends \Amasty\Acart\Controller\Adminhtml\Rule\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\Acart\Model\RuleFactory $ruleFactory, \Amasty\Acart\Model\SalesRuleFactory $salesRuleFactory, \Amasty\Base\Model\Serializer $serializer, \Psr\Log\LoggerInterface $logger)
    {
        $this->___init();
        parent::__construct($context, $ruleFactory, $salesRuleFactory, $serializer, $logger);
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
