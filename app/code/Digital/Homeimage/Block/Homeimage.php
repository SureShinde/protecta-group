<?php
namespace Digital\Homeimage\Block;
use Magento\Framework\ObjectManagerInterface;
class Homeimage extends \Magento\Framework\View\Element\Template {
	protected function _prepareLayout() {
        return parent::_prepareLayout();
    }
	
	protected $_homeimage;
    protected $_bannerHelper;
 	protected $bannerFor = array(\Digital\Homeimage\Helper\Data::DESKTOP_VALUE,\Digital\Homeimage\Helper\Data::COMBINE_VALUE);
 	protected $device = 0;
    protected $_bannerCollection = null;
	
    public function __construct(
    	\Magento\Catalog\Block\Product\Context $context,
    	\Digital\Homeimage\Model\Homeimage $homeimage,
        ObjectManagerInterface $objectManager,
        \Digital\Homeimage\Helper\Data $bannerHelper,
    	array $data = [])
    {
        parent::__construct($context, $data);
         $this->_homeimage = $homeimage;
         $this->objectManager = $objectManager;
        $this->_bannerHelper = $bannerHelper;
    }
    protected function _getBannerCollection() {
        if ($this->_bannerCollection === null) {
 			//$bannerFor = $this->checkDevice();
            $bannerCollection = $this->_homeimage->getCollection()
            	->addFieldToFilter("status",\Digital\Homeimage\Model\Status::STATUS_ENABLED)
            	//->addFieldToFilter("banner_use",array("in" => $bannerFor))
                ->setOrder('sort_order',"ASC")
                ->addFieldToSelect('*');
            $this->_bannerCollection = $bannerCollection;
        }
        return $this->_bannerCollection;
    }
    public function getLoadedBannerCollection() {
        return $this->_getBannerCollection();
    }
    public function isEnabled() {
         return $this->_bannerHelper->isEnabled();
    }
    public function checkDevice() {
    	$device = $this->_bannerHelper->checkDevice();
    	if($device == 1) {
            /*For Mobile and Combine Banner*/
    		return $this->_bannerHelper->getMobileArray();
    	} elseif($device == 2) {
            /*For Tablet and Combine Banner*/
            return $this->_bannerHelper->getTabletArray();
        }
        /*For Desktop and Combine Banner*/
        return $this->_bannerHelper->getDesktopArray();
    }
    public function getImageUrl($image = '') {
        $media_dir = $this->objectManager->get('Magento\Store\Model\StoreManagerInterface')
            ->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $media_dir.$image;
    }
}