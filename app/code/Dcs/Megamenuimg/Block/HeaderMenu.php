<?php 
namespace Dcs\Megamenuimg\Block; 

class HeaderMenu extends \Magento\Framework\View\Element\Template 
{
	 
	protected $objectManager;

	protected $_catalogHelper;

	protected$_catagoryFactory;

	protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
	 
    public function __construct(
    	\Magento\Catalog\Block\Product\Context $context, 
    	\Magento\Catalog\Helper\Category $catalogHelper,
    	\Magento\Catalog\Model\Category $catagoryFactory,
        \Magento\Framework\ObjectManagerInterface $objectManager,
		\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productFactory,
		\Magento\Catalog\Block\Product\ListProduct $listProduct,
    	array $data = []) 
    {
        parent::__construct($context, $data); 
         $this->objectManager = $objectManager;
         $this->_catagoryFactory = $catagoryFactory;
         $this->_catalogHelper = $catalogHelper;
		 $this->_productFactory   = $productFactory;
		 $this->listProduct = $listProduct;
    }  
     
    public function getImageUrl($image = ''){
        $media_dir = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        if($image){
        	return $media_dir."catalog/category/".$image;
        }
    }

    public function getApplicationsCategory()
    {
		$parentCatId = 3;		
		$categoryRepository = $this->objectManager->create('Magento\Catalog\Model\CategoryRepository');
		$parentcategories = $categoryRepository->get($parentCatId);
		$categories = $parentcategories->getChildrenCategories();
		return $categories;
    }
	
	public function getProductsCategory()
    {
		$parentCatId = 4;		
		$categoryRepository = $this->objectManager->create('Magento\Catalog\Model\CategoryRepository');
		$parentcategories = $categoryRepository->get($parentCatId);
		$categories = $parentcategories->getChildrenCategories();
		return $categories;
    }
	
	public function getHomePageCategory()
    {	
		$categoryFactory = $this->objectManager->create('Magento\Catalog\Model\ResourceModel\Category\CollectionFactory');
		$categories = $categoryFactory->create()->addAttributeToSelect('*')->addFieldToFilter('is_active', 1)->addFieldToFilter('show_on_homepage', 1);
		$categories->getSelect()->limit(6);
		return $categories;		
    }
	
	public function getnoImageCategory()
    {
		$no_cat_image = $this->objectManager->get('Magento\Store\Model\StoreManagerInterface')
                    ->getStore()
                    ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'catogary_noimage.jpg';
		return $no_cat_image;
	}
	
	public function getHomepagePopularProductCollection()
	{
	   $productCollection = $this->_productFactory->create();
	   $productCollection->addAttributeToSelect('*') 
	   					 ->addAttributeToFilter('pg_popular_product',1) 
	   					 ->addAttributeToFilter('visibility', \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH)
    					 ->addAttributeToFilter('status',\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED)
    	 				 ->setPageSize(10)
    	 				 ->setOrder('id','DESC');
	   return $productCollection;
	}
	
	public function getHomepageNewReleasesProductCollection()
	{
	   $productCollection = $this->_productFactory->create();
	   $productCollection->addAttributeToSelect('*') 
	   					 ->addAttributeToFilter('pg_new_release',1) 
	   					 ->addAttributeToFilter('visibility', \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH)
    					 ->addAttributeToFilter('status',\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED)
    	 				 ->setPageSize(10)
    	 				 ->setOrder('id','DESC');
	   return $productCollection;
	}
	
	public function getCategoryListsThumbnails()
	{		
		$category_curr = $this->objectManager->get(\Magento\Framework\Registry::class)->registry('current_category');	
		$categoryFactory = $this->objectManager->get('\Magento\Catalog\Model\CategoryFactory');		
		$category = $categoryFactory->create()->load($category_curr->getId());
		$childrenCategories = $category->getChildrenCategories();
		if(count($childrenCategories)>0)
		{
			return $childrenCategories;
		}
		else
		{
			return;
		}		
	}
	
	
	public function getProductPrice($product){
		return $this->listProduct->getProductPrice($product);
	}

	public function getImage($product ,$image = ''){
		return $this->listProduct->getImage($product,$image);
	}
	
	public function getAddToCartUrl($product){
		return $this->listProduct->getAddToCartUrl($product);
	}
	
	

    public function getCategoryData($category_id = 0)
    {
    	return $this->_catagoryFactory->load($category_id);
    }

    public function getCategoryUrl($category = array())
    {
    	return $this->_catalogHelper->getCategoryUrl($category);
    }
}
