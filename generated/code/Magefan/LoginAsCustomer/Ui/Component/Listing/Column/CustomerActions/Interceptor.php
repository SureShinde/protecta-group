<?php
namespace Magefan\LoginAsCustomer\Ui\Component\Listing\Column\CustomerActions;

/**
 * Interceptor class for @see \Magefan\LoginAsCustomer\Ui\Component\Listing\Column\CustomerActions
 */
class Interceptor extends \Magefan\LoginAsCustomer\Ui\Component\Listing\Column\CustomerActions implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\UiComponent\ContextInterface $context, \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory, \Magento\Framework\UrlInterface $urlBuilder, \Magento\Framework\AuthorizationInterface $authorization, array $components = [], array $data = [])
    {
        $this->___init();
        parent::__construct($context, $uiComponentFactory, $urlBuilder, $authorization, $components, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function prepare()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'prepare');
        if (!$pluginInfo) {
            return parent::prepare();
        } else {
            return $this->___callPlugins('prepare', func_get_args(), $pluginInfo);
        }
    }
}
