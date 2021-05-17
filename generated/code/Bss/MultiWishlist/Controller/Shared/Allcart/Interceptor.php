<?php
namespace Bss\MultiWishlist\Controller\Shared\Allcart;

/**
 * Interceptor class for @see \Bss\MultiWishlist\Controller\Shared\Allcart
 */
class Interceptor extends \Bss\MultiWishlist\Controller\Shared\Allcart implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Wishlist\Controller\Shared\WishlistProvider $wishlistProvider, \Magento\Wishlist\Model\ItemCarrier $itemCarrier, \Bss\MultiWishlist\Helper\Data $dataHelper, \Bss\MultiWishlist\Model\ItemCarrier $itemCarrierModel)
    {
        $this->___init();
        parent::__construct($context, $wishlistProvider, $itemCarrier, $dataHelper, $itemCarrierModel);
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
