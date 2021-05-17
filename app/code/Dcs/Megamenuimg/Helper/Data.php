<?php
namespace Dcs\Megamenuimg\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	protected $_customerSession;

    public function __construct(
	    \Magento\Catalog\Model\CategoryFactory $categoryFactory,
    	\Magento\Customer\Model\Session $customerSession
    )
    {
		$this->_categoryFactory = $categoryFactory;
        $this->_customerSession = $customerSession;
    }

    public function isCustomerLogin()
    {
        return $this->_customerSession->isLoggedIn();
    }
    public function getCustomer()
    {
        return $this->_customerSession->getCustomer();
    }
	public function getCategoryUrl($id)
    {
		/*$_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$object_manager = $_objectManager->create('Magento\Catalog\Model\Category')->load($id);
		$cat_url = $object_manager->getUrl();
		return $cat_url;*/
	    return $category = $this->_categoryFactory->create()->load($id);
    }
}
