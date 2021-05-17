<?php

namespace Dcs\Downloadcatalogue\Block;

/**
 * Downloadcatalogue content block
 */
class Downloadcatalogue extends \Magento\Framework\View\Element\Template
{
    /**
     * Downloadcatalogue collection
     *
     * @var Dcs\Downloadcatalogue\Model\ResourceModel\Downloadcatalogue\Collection
     */
     //const NOT_LOGIN_CUSTOMER_GROUP = 0;
    protected $_downloadcatalogueCollection = null;
    
    /**
     * Downloadcatalogue factory
     *
     * @var \Dcs\Downloadcatalogue\Model\DownloadcatalogueFactory
     */
    protected $_downloadcatalogueCollectionFactory;
    
    /** @var \Dcs\Downloadcatalogue\Helper\Data */
    protected $_dataHelper;
    protected $_filesystem ;
    protected $_imageFactory;
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Dcs\Downloadcatalogue\Model\ResourceModel\Downloadcatalogue\CollectionFactory $downloadcatalogueCollectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Dcs\Downloadcatalogue\Model\ResourceModel\Downloadcatalogue\CollectionFactory $downloadcatalogueCollectionFactory,
        \Dcs\Downloadcatalogue\Helper\Data $dataHelper,
        \Magento\Customer\Model\Session $customerSession,  
        \Magento\Framework\Image\AdapterFactory $imageFactory,
        array $data = []
    ) {
        $this->_downloadcatalogueCollectionFactory = $downloadcatalogueCollectionFactory;
		$this->_filesystem = $context->getFileSystem();               
        $this->_imageFactory = $imageFactory; 
        $this->_customerSession = $customerSession;
        $this->_dataHelper = $dataHelper;
        parent::__construct(
            $context,
            $data
        );
    }
	
	public function isEnabledModule()
    {
		 return $this->_dataHelper->isEnabled();
    }
    public function getGroupId(){
		if($this->_customerSession->isLoggedIn()){
			return $customerGroup=$this->_customerSession->getCustomer()->getGroupId();
		}
		return 0;
	}
    /**
     * Retrieve downloadcatalogue collection
     *
     * @return Dcs\Downloadcatalogue\Model\ResourceModel\Downloadcatalogue\Collection
     */
    protected function _getCollection()
    {
        $collection = $this->_downloadcatalogueCollectionFactory->create();
		
		//$collection->addAttributeToFilter('status', 1);
        return $collection;
    }
    
    /**
     * Retrieve prepared downloadcatalogue collection
     *
     * @return Dcs\Downloadcatalogue\Model\ResourceModel\Downloadcatalogue\Collection
     */
    public function getCollection()
    {
        if (is_null($this->_downloadcatalogueCollection)) {
			$this->_downloadcatalogueCollection=$this->_getCollection();
			$field="status";
			$value="1";
            $this->_downloadcatalogueCollection->addFieldToFilter($field, $value);			
			$this->_downloadcatalogueCollection->setOrder('rank','asc');
			
        }

        return $this->_downloadcatalogueCollection;
    }
    
    /**
     * Fetch the current page for the downloadcatalogue list
     *
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->getData('current_page') ? $this->getData('current_page') : 1;
    }
    
    /**
     * Return URL to item's view page
     *
     * @param Dcs\Downloadcatalogue\Model\Downloadcatalogue $downloadcatalogueItem
     * @return string
     */
    public function getItemUrl($downloadcatalogueItem)
    {
        return $this->getUrl('*/*/view', array('id' => $downloadcatalogueItem->getId()));
    }
    
    /**
     * Return URL for resized Downloadcatalogue Item image
     *
     * @param Dcs\Downloadcatalogue\Model\Downloadcatalogue $item
     * @param integer $width
     * @return string|false
     */
    public function getImageUrl($item, $width=null,$height=null)
    {
        return $this->_dataHelper->resize($item, $width,$height);
    }
    
    /**
     * Get a pager
     *
     * @return string|null
     */
    public function getPager()
    {
        $pager = $this->getChildBlock('downloadcatalogue_list_pager');
        if ($pager instanceof \Magento\Framework\Object) {
            $downloadcataloguePerPage = $this->_dataHelper->getDownloadcataloguePerPage();

            $pager->setAvailableLimit([$downloadcataloguePerPage => $downloadcataloguePerPage]);
            $pager->setTotalNum($this->getCollection()->getSize());
            $pager->setCollection($this->getCollection());
            $pager->setShowPerPage(TRUE);
            $pager->setFrameLength(
                $this->_scopeConfig->getValue(
                    'design/pagination/pagination_frame',
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                )
            )->setJump(
                $this->_scopeConfig->getValue(
                    'design/pagination/pagination_frame_skip',
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                )
            );

            return $pager->toHtml();
        }

        return NULL;
    }
	
	 public function resize($image, $width = null, $height = null)
    {
        $absolutePath = $this->_filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath().$image;

        $imageResized = $this->_filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath('resized/'.$width.'/').$image;         
        //create image factory...
        $imageResize = $this->_imageFactory->create();         
        $imageResize->open($absolutePath);
        $imageResize->constrainOnly(TRUE);         
        $imageResize->keepTransparency(TRUE);         
        $imageResize->keepFrame(FALSE);         
        $imageResize->keepAspectRatio(FALSE);         
        $imageResize->resize($width,$height);  
        //destination folder                
        $destination = $imageResized ;    
        //save image      
        $imageResize->save($destination);         

        $resizedURL = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'resized/'.$width.'/'.$image;
        return $resizedURL;
  } 
}
