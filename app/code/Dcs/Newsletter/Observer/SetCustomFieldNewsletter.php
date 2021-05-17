<?php
namespace Dcs\Newsletter\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Model\Product\Type;
use Magento\Framework\App\RequestInterface;

class SetCustomFieldNewsletter implements ObserverInterface
{
    /**
     * Add Special Price on add to cart.
     *
     * @param Observer $observer
     * @return SetPriceForItem
     *
     */
        protected $_request;
    /**
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request){
            $this->_request = $request;

           
    }

     public function execute(\Magento\Framework\Event\Observer $observer)
     {
        
        $first_name = null;
        $subscriber = $observer->getEvent()->getSubscriber();
        if ($this->_request->getParam('first_name')) {
            $first_name = $this->_request->getParam('first_name'); 
        }
        
        $subscriber->setFirstName($first_name);
        

         return $this;
     }
}