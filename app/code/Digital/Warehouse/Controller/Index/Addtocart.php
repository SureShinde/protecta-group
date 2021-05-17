<?php

namespace Digital\Warehouse\Controller\Index;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use Digital\Warehouse\Controller\AbstractAction;



class Addtocart extends \Magento\Framework\App\Action\Action	
{	
		protected $formKey;   
		protected $cart;
		protected $product;
	 
	public function __construct(
        Context $context,
		\Magento\Framework\Controller\ResultFactory $resultFactory,		
		\Magento\Framework\Translate\Inline\StateInterface $StateInterface,
		\Magento\Store\Model\StoreManagerInterface $StoreManagerInterface,
		\Digital\Warehouse\Helper\Data $helperWarehouse,
		\Digital\Warehouse\Model\Warehouse $_warehouseModel,		
		\Magento\Framework\Data\Form\FormKey $formKey,
		\Magento\Checkout\Model\Cart $cart,
		\Magento\Catalog\Model\Product $product,
		\Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
		
		\Digital\Warehouse\Helper\Email $emailHelper		
    ){
        parent::__construct($context);		
		$this->resultFactory = $resultFactory;		
		$this->StateInterface = $StateInterface;
		$this->StoreManagerInterface = $StoreManagerInterface;
		$this->_warehouseModel = $_warehouseModel;		
		$this->helperWarehouse = $helperWarehouse;		
		$this->formKey = $formKey;
		$this->cart = $cart;
		$this->product = $product;
		$this->_resultJsonFactory = $resultJsonFactory;	
		$this->EmailHelper = $emailHelper;
    }
	
	public function execute()
	{
		$result = array();
		try
		{
			$productId = $this->getRequest()->getParam('id');
			$qty = $this->getRequest()->getParam('prod_qty');
			
			if($productId!='' && $qty!='')
			{

				$params = array(
						'form_key' => $this->formKey->getFormKey(),
						'product' => $productId, //product Id
						'qty'   =>$qty //quantity of product                
					);              
				//Load the product based on productID   
				$_product = $this->product->load($productId);       
				$this->cart->addProduct($_product, $params);
				$this->cart->save();
				
				$message = __(
                            'You added %1 to your shopping cart.',
                            $_product->getName()
                        );
				
				$result = [
					'status' => 'success',
					'message' => $message,
				];
				
			}
			else
			{
				$result = [
					'status' => 'error',
					'message' => 'error',
				];
			}

			
		}
		catch (\Exception $e)
		{
               $result = [
					'status' => 'error',
					'message' => 'error',
				];
          }		
		
		$resultJson = $this->_resultJsonFactory->create();
        return $resultJson->setData($result);
		
		
    }
}
