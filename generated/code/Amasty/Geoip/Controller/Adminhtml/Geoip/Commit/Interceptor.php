<?php
namespace Amasty\Geoip\Controller\Adminhtml\Geoip\Commit;

/**
 * Interceptor class for @see \Amasty\Geoip\Controller\Adminhtml\Geoip\Commit
 */
class Interceptor extends \Amasty\Geoip\Controller\Adminhtml\Geoip\Commit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\Geoip\Model\Import $importModel, \Amasty\Geoip\Helper\Data $geoipHelper, \Magento\Framework\Json\Helper\Data $jsonHelper, \Magento\Framework\Filesystem\Driver\File $driverFile, \Amasty\Geoip\Model\Geolocation $geolocationModel)
    {
        $this->___init();
        parent::__construct($context, $importModel, $geoipHelper, $jsonHelper, $driverFile, $geolocationModel);
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
