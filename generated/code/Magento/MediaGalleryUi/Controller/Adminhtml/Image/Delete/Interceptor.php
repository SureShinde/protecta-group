<?php
namespace Magento\MediaGalleryUi\Controller\Adminhtml\Image\Delete;

/**
 * Interceptor class for @see \Magento\MediaGalleryUi\Controller\Adminhtml\Image\Delete
 */
class Interceptor extends \Magento\MediaGalleryUi\Controller\Adminhtml\Image\Delete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\MediaGalleryUi\Model\DeleteImage $deleteImage, \Magento\MediaGalleryApi\Api\GetAssetsByIdsInterface $getAssetsByIds, \Magento\Cms\Model\Wysiwyg\Images\Storage $imagesStorage, \Psr\Log\LoggerInterface $logger)
    {
        $this->___init();
        parent::__construct($context, $deleteImage, $getAssetsByIds, $imagesStorage, $logger);
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
