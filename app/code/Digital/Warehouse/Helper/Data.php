<?php

/**
 * Warehouse data helper
 */
namespace Digital\Warehouse\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Path to store config where count of warehouse posts per page is stored
     *
     * @var string
     */
    
	const XML_PATH_ENABLE 	  = "warehouse/view/enabled";
	const XML_PATH_SITEKEY   = "warehouse/view/recapcha_sitekey";
	const XML_PATH_SECRETKEY = "warehouse/view/recapcha_secretkey";
	const XML_PATH_RECIPIENT_EMAIL = "warehouse/view/recipient_email";
	const XML_PATH_GENERAL_NAME = 'trans_email/ident_general/name';
    const XML_PATH_GENERAL_EMAIL = 'trans_email/ident_general/email';
    const XML_PATH_INVENTORY_STATUS = 'warehouse/view/inventory_status_qty';
	
    protected $httpFactory;
    protected $_storeManager;	
	protected $customerSession;	
	protected $inlineTranslation;
    protected $formKey;
   // protected $_helper;
    
    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,    
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Framework\HTTP\Adapter\FileTransferFactory $httpFactory,        
        \Magento\Store\Model\StoreManagerInterface $storeManager,		
        \Magento\Customer\Model\Session $customerSession,
		\Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
		\Magento\CatalogInventory\Api\StockStateInterface $stockItem,
		\Magento\Store\Model\StoreManagerInterface $storeInterface
		//\Digital\Warehouse\Helper\Data $helper     
    ) {
        $this->_scopeConfig = $scopeConfig;        
        $this->formKey = $formKey;        
        $this->httpFactory = $httpFactory;        
        $this->_storeManager = $storeManager;        
		$this->_customerSession = $customerSession;
		$this->inlineTranslation = $inlineTranslation;
		$this->stockItem = $stockItem;
		$this->_storeInterface = $storeInterface;
		//$this->_helper = $helper;
        parent::__construct($context);
    }
    
   
    public function getFormKey()
	{
		return $this->formKey->getFormKey();
	}
    
	public function isEnabled()
    {		
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
		return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLE,$storeScope);
    }
	public function Sitekey()
    {		
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
		return $this->scopeConfig->getValue(self::XML_PATH_SITEKEY,$storeScope);
    }
	public function Secretkey()
    {		
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
		return $this->scopeConfig->getValue(self::XML_PATH_SECRETKEY,$storeScope);
    }
	public function Recipientemail()
    {		
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
		return $this->scopeConfig->getValue(self::XML_PATH_RECIPIENT_EMAIL,$storeScope);
    }
	public function GeneralName()
	{
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
 		return $this->scopeConfig->getValue(self::XML_PATH_GENERAL_NAME, $storeScope);
    }
	
	public function GeneralEmail()
	{
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
 		return $this->scopeConfig->getValue(self::XML_PATH_GENERAL_EMAIL, $storeScope);
    }
	
	public function isCustomerLoggedIn()
	{
		 return $this->_customerSession;
	}
	
	public function CustomerEmail()
    {	
		return trim($this->_customerSession->getCustomer()->getEmail());		
    }
	
    public function getCustomerPhone()
    {	
		return trim($this->_customerSession->getCustomer()->getPhone());		
    }	
	
	public function getBaseUrl()
    { 
        $storeId = $this->_storeManager->getDefaultStoreView()->getStoreId();
    	$url = $this->_storeManager->getStore($storeId)->getUrl();
		return $url;
    }
    public function setMessage($status,$message)
	{
		$this->_customerSession->setWarehouseMessageStatus($status);
		 $this->_customerSession->setWarehouseMessage($message);
	}
	public function getWarehouseMessage()
	{
		 return $this->_customerSession->getWarehouseMessage();
	}
	public function getWarehouseMessageStatus()
	{
		 return $this->_customerSession->getWarehouseMessageStatus();
	}
    public function resetSessionMessage(){
		$this->_customerSession->setWarehouseMessageStatus('');
		 $this->_customerSession->setWarehouseMessage('');
	}

	public function getWarehouseImage(){
        $media_dir =  $this->_storeInterface
            ->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        return $media_dir.'/Digital/Warehousebanner/'.$this->getImageName();
    } 

	public function getImageName(){
        return $this->scopeConfig->getValue('warehouse/view/admin_image', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
	
	
	function getCustomerSession()
	{
		return $this->_customerSession;
	}
	
	
	public function isNetSuitecustomer()
    {
			if($this->_customerSession->isLoggedIn())
			{
				$customer = $this->_customerSession->getCustomer();
				if($customer->getGroupId() != 3)
				{
					return true;
				}
			}
    }


    public function showAccountTermsPaymentMethod()
    {
			if($this->_customerSession->isLoggedIn())
			{
				$customer = $this->_customerSession->getCustomer();
				if(trim($customer->getNsTerms()) != 'Prepaid' && trim($customer->getNsTerms()) != '')
				{
					return true;
				}
			}
    }

    public function showVipIconBeforePrice()
    {
			if($this->_customerSession->isLoggedIn())
			{
				$customer = $this->_customerSession->getCustomer();
				if($customer->getGroupId() == 7)
				{
					return true;
				}
			}
    }


    public function getCurrentCustomerIdForTierPrice()
    {
    	if($this->_customerSession->isLoggedIn())
		{
    		return $this->_customerSession->getCustomer()->getGroupId();
    	}
    	else
    	{
    		return 3;
    	}
	}

	
	
	public function QtyStatusThreshold()
	{
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
 		$qty_status_threshold = $this->scopeConfig->getValue(self::XML_PATH_INVENTORY_STATUS, $storeScope);
		if($qty_status_threshold!='')
		{
			return $qty_status_threshold;	
		}
		else
		{
			return 0;
		}
		
    }
	
	public function checkCartStoreSection($_item)
	{
		$customerSession = $this->getCustomerSession();
		$current_selected_store = $customerSession->getLocationSession();
		$cart_qty = $_item->getQty();
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$simple_product = $objectManager->create('Magento\Catalog\Model\Product')->load($_item->getProduct()->getId());
		
		if($current_selected_store=='sydney')
		{
			if($cart_qty <= $simple_product->getPgSydneyQty())
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		elseif($current_selected_store=='melbourne')
		{
			if($cart_qty <= $simple_product->getPgMelbourneQty())
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		elseif($current_selected_store=='brisbane')
		{
			if($cart_qty <= $simple_product->getPgBrisbaneQty())
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		elseif($current_selected_store=='perth')
		{
			if($cart_qty <= $simple_product->getPgPerthQty())
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	public function getCurrentLocationQtyStatus($simple_product)
	{
		$qty_status = '';
		$qty_threshold = $this->QtyStatusThreshold();		
		//$product_total_qty = $this->stockItem->getStockQty($simple_product->getId(), $simple_product->getStore()->getWebsiteId());

		$stockItem = $simple_product->getExtensionAttributes()->getStockItem();
		$product_total_qty = $stockItem->getQty();
		

		if($product_total_qty >= $qty_threshold)
		{
			$qty_status = 'Available';
		}
		else
		{
			$qty_status = 'Low In Stock';
		}
				
		return $qty_status;
	}
	
	public function getCurrentLocationQtyMessage($simple_product)
	{
		$qty_message = '';
		
		$customerSession = $this->getCustomerSession();
		$current_selected_store = $customerSession->getLocationSession();
		
		$product_profile = $simple_product->getAttributeText('pg_product_profile');
		
		$current_status = $this->getCurrentLocationQtyStatus($simple_product);
		$qty_threshold = $this->QtyStatusThreshold();
		
		if($current_selected_store=='sydney')
		{
						if($current_status=='Available')
						{
								if($simple_product->getPgSydneyQty() > 0)
								{						
										if($product_profile=='Standard' || $product_profile=='Bulky')
										{					
											$qty_message = 'Same Day (by 5pm) if ordered by 2pm';
										}
										elseif($product_profile=='Hoarding')
										{					
											$qty_message = 'Same Day (by 5pm) if ordered by 12pm';
										}				
								}
								else
								{
										$other_three_qty = $simple_product->getPgBrisbaneQty() + $simple_product->getPgMelbourneQty() + $simple_product->getPgPerthQty();
										if($other_three_qty >= $qty_threshold)
										{
											$qty_message = 'Via National Road Freight';
										}
										else
										{
											$qty_message = '<span class="alt_contact_us">Contact Us</span><span class="show_alt_prod_span"> or click here for alternate products</span>';
										}							
								}
						}
						else
						{
							$qty_message = '<span class="alt_contact_us">Contact Us</span><span class="show_alt_prod_span"> or click here for alternate products</span>';
						}			
		}
		elseif($current_selected_store=='melbourne')
		{
						if($current_status=='Available')
						{
								if($simple_product->getPgMelbourneQty() > 0)
								{						
										if($product_profile=='Standard' || $product_profile=='Bulky')
										{					
											$qty_message = 'Same Day (by 5pm) if ordered by 2pm';
										}
										elseif($product_profile=='Hoarding')
										{					
											$qty_message = 'Same Day (by 5pm) if ordered by 12pm';
										}				
								}
								else
								{
										$other_three_qty = $simple_product->getPgBrisbaneQty() + $simple_product->getPgSydneyQty() + $simple_product->getPgPerthQty();
										if($other_three_qty >= $qty_threshold)
										{
											$qty_message = 'Via National Road Freight';
										}
										else
										{
											$qty_message = '<span class="alt_contact_us">Contact Us</span><span class="show_alt_prod_span"> or click here for alternate products</span>';
										}							
								}
						}
						else
						{
							$qty_message = '<span class="alt_contact_us">Contact Us</span><span class="show_alt_prod_span"> or click here for alternate products</span>';
						}			
		}
		
		elseif($current_selected_store=='brisbane')
		{
				if($current_status=='Available')
				{
						if($simple_product->getPgBrisbaneQty() > 0)
						{						
								if($product_profile=='Standard' || $product_profile=='Bulky')
								{					
									$qty_message = 'Same Day (by 5pm) if ordered by 2pm';
								}
								elseif($product_profile=='Hoarding')
								{					
									$qty_message = 'Same Day (by 5pm) if ordered by 12pm';
								}				
						}
						else
						{
								$other_three_qty = $simple_product->getPgSydneyQty() + $simple_product->getPgMelbourneQty() + $simple_product->getPgPerthQty();
								if($other_three_qty >= $qty_threshold)
								{
									$qty_message = 'Via National Road Freight';
								}
								else
								{
									$qty_message = '<span class="alt_contact_us">Contact Us</span><span class="show_alt_prod_span"> or click here for alternate products</span>';
								}							
						}
				}
				else
				{
					$qty_message = '<span class="alt_contact_us">Contact Us</span><span class="show_alt_prod_span"> or click here for alternate products</span>';
				}			
		}
		elseif($current_selected_store=='perth')
		{
						if($current_status=='Available')
						{
								if($simple_product->getPgPerthQty() > 0)
								{						
										if($product_profile=='Standard' || $product_profile=='Bulky')
										{					
											$qty_message = 'Same Day (by 5pm) if ordered by 2pm';
										}
										elseif($product_profile=='Hoarding')
										{					
											$qty_message = 'Same Day (by 5pm) if ordered by 12pm';
										}				
								}
								else
								{
										$other_three_qty = $simple_product->getPgBrisbaneQty() + $simple_product->getPgSydneyQty() + $simple_product->getPgMelbourneQty();
										if($other_three_qty >= $qty_threshold)
										{
											$qty_message = 'Via National Road Freight';
										}
										else
										{
											$qty_message = '<span class="alt_contact_us">Contact Us</span><span class="show_alt_prod_span"> or click here for alternate products</span>';
										}							
								}
						}
						else
						{
							$qty_message = '<span class="alt_contact_us">Contact Us</span><span class="show_alt_prod_span"> or click here for alternate products</span>';
						}			
		}
		
			
		
		return $qty_message;
	}	
	
	
	/*public function getParentGroupProductUrl($simple_product_id)
	{
			$parentUrl = '';
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
			$connection = $resource->getConnection();
			$sql = "SELECT parent_id FROM `catalog_product_relation` where `child_id` =".$simple_product_id;
			$result = $connection->fetchAll($sql);
			if(isset($result[0]['parent_id']) && (int)$result[0]['parent_id'] > 0 )
			{
				 $parentProduct = $objectManager->create('Magento\Catalog\Model\Product')->load($result[0]['parent_id']);
				 $parentUrl	= $parentProduct->getUrlModel()->getUrl($parentProduct);
			}
			else
			{
				$simpleProduct = $objectManager->create('Magento\Catalog\Model\Product')->load($simple_product_id);
				$parentUrl	= $simpleProduct->getUrlModel()->getUrl($simpleProduct);	
			}
		return $parentUrl;
		
	}*/
	
	
	
}
