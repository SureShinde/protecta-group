<?php
namespace Digital\Warehouse\Controller\Index;
 
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;
 
 
class Alternateproduct extends \Magento\Framework\App\Action\Action
{    
    protected $_resultPageFactory; 
    protected $_resultJsonFactory;
	protected $product;
 
    public function __construct(
		Context $context,
		PageFactory $resultPageFactory,
		JsonFactory $resultJsonFactory,
		\Magento\Catalog\Model\Product $product
	)
    {
 		parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
        $this->_resultJsonFactory = $resultJsonFactory;
		$this->product = $product;
 
        
    }
 
    public function execute()
    {
        $result = $this->_resultJsonFactory->create();
        $resultPage = $this->_resultPageFactory->create();       
 
        $all_up_products = array();
		
		
			$productId = $this->getRequest()->getParam('id');
			$currentProduct = $this->product->load($productId);
			if($productId!='' && $currentProduct)
			{
				$upsellProducts = $currentProduct->getUpSellProducts();				
				if (!empty($upsellProducts))
				{
					    $k = 1;
						foreach ($upsellProducts as $upsellprod)
						{
							if($k <=6)
							{
								$all_up_products[] = $upsellprod->getId();
							}
							$k++;
						}
				}
				
			}
		
		$data = array('all_upsell_products_id'=>$all_up_products);
 
        $block = $resultPage->getLayout()
                ->createBlock('Magento\Catalog\Block\Product\View')
                ->setTemplate('Magento_Catalog::product/view/alternate_product.phtml')
                ->setData('data',$data)
                ->toHtml();
 
        $result->setData(['output' => $block, 'status' => 'success']);
        return $result;
    }
 
}