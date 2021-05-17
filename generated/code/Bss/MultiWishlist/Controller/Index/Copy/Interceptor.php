<?php
namespace Bss\MultiWishlist\Controller\Index\Copy;

/**
 * Interceptor class for @see \Bss\MultiWishlist\Controller\Index\Copy
 */
class Interceptor extends \Bss\MultiWishlist\Controller\Index\Copy implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Bss\MultiWishlist\Helper\Data $helper, \Magento\Wishlist\Model\Item $wishlistItem, \Magento\Wishlist\Model\WishlistFactory $coreWishlist, \Magento\Customer\Model\Session $customerSession, \Magento\Wishlist\Model\Item\OptionFactory $optionFactory)
    {
        $this->___init();
        parent::__construct($context, $helper, $wishlistItem, $coreWishlist, $customerSession, $optionFactory);
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
