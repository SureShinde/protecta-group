<?php
namespace Bss\MultiWishlist\Controller\Index\MoveToWishlist;

/**
 * Interceptor class for @see \Bss\MultiWishlist\Controller\Index\MoveToWishlist
 */
class Interceptor extends \Bss\MultiWishlist\Controller\Index\MoveToWishlist implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \Bss\MultiWishlist\Helper\Data $helper, \Magento\Wishlist\Model\WishlistFactory $coreWishlist, \Magento\Wishlist\Model\Item $wishlistItem, \Magento\Wishlist\Model\Item\OptionFactory $optionFactory)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $helper, $coreWishlist, $wishlistItem, $optionFactory);
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
