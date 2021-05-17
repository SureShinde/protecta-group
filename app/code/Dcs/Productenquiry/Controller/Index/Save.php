<?php

namespace Dcs\Productenquiry\Controller\Index;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Save extends \Magento\Framework\App\Action\Action
{
	protected $_resultFactory;
    protected $_checkoutSession;
	protected $_urlBuilder;
	protected $_productenquiry;
	protected $_helperProductenquiry;
	
	const XML_PATH_CUSTOMER_EMAIL  = 'productenquiry/view/email_template';
	const XML_PATH_ADMIN_EMAIL  = 'productenquiry/view/admin_email'; 
	const XML_PATH_EMAIL_SENDER = 'productenquiry/email/sender_email_identity';
	
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
		\Magento\Framework\Controller\ResultFactory $resultFactory,
		\Magento\Checkout\Model\Session $checkoutSession,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Framework\UrlInterface $urlBuilder,
		\Dcs\Productenquiry\Helper\Data $helperProductenquiry,
		\Dcs\Productenquiry\Model\Productenquiry $productenquiry,
		\Dcs\Productenquiry\Helper\Email $emailHelper
	) {
		
        parent::__construct($context);
   		$this->resultFactory = $resultFactory;
		$this->_checkoutSession = $checkoutSession;
        $this->_storeManager = $storeManager;
		$this->_urlBuilder = $urlBuilder;
		$this->_productenquiry = $productenquiry;
		$this->_helperProductenquiry = $helperProductenquiry;
		$this->EmailHelper = $emailHelper;
    }
	
    public function execute()
    {
		$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
    	$post 			= $this->getRequest()->getPostValue();
    	
		$fullname 		= $this->getRequest()->getPost('fullname');
		$company	= $this->getRequest()->getPost('company');
		$phone 		= $this->getRequest()->getPost('phone');
		$email 		= $this->getRequest()->getPost('email'); 
		$comment 	= $this->getRequest()->getPost('comment'); 
		
		
		if (!$post) {
			$this->_redirect('*/*/');
			return;
		}	
		else
		{
			try
			{
				$error = false;
				if ($post['g-recaptcha-response'] == '' && isset($post['g-recaptcha-response'])){
				$error = true;
				} 
				if ($error) {
					throw new \Exception();
				}
				
				$postObject = new \Magento\Framework\DataObject();
				$postObject->setData($post);
				
				
				$receiveremail = $this->_helperProductenquiry->Recipientemail();
				
				$receiverInfo = [
					'name' => 'Product Enquiry',
					'email' => $receiveremail,
				];
				
				$sendername = $this->_helperProductenquiry->GeneralName();
				$senderemail = $this->_helperProductenquiry->GeneralEmail();
				
				$senderInfo = [
					'name' => $sendername,
					'email' => $senderemail,
				];		
				
				$customerInfo = [
					'name' =>   $fullname,
					'email' => $email,
				];
				
				
				$individualHtml = "";
				if($this->_checkoutSession->getEnquiryQuote())
				{
					$newQuoteProductsArray = $this->_checkoutSession->getEnquiryQuote();
					$products = serialize($newQuoteProductsArray);
					$this->_productenquiry->setData('products',$products);
					$this->_checkoutSession->unsEnquiryQuote();
					
						foreach($newQuoteProductsArray as $productdata)
						{
							$individualHtml .= $productdata['name']." [".$productdata['sku']."] "." (".$productdata['qty']."), ";
						}
					
					$postObject['products'] = rtrim($individualHtml, ', ');
				}
								
				$this->_productenquiry->setData('fullname',$fullname);
				$this->_productenquiry->setData('company',$company);
				$this->_productenquiry->setData('phone',$phone);
				$this->_productenquiry->setData('email',$email);
			    $this->_productenquiry->setData('comment',$comment);
				$this->_productenquiry->save();
				$this->messageManager->addSuccess(
				__('Thanks for product enquiry with us. We\'ll respond to you very soon.')
				);
				
													
				$this->EmailHelper->customerMailSendMethod($postObject,$senderInfo,$customerInfo);					
				$this->EmailHelper->adminEnquiryMailSendMethod($postObject,$senderInfo,$receiverInfo); 
				
			}
			catch (\Exception $e) 
			{
				$this->messageManager->addError(
					__('We can\'t process your request right now.')
				);
			}
		}
		
		
		$resultRedirect->setUrl($this->_storeManager->getStore()->getBaseUrl());
        return $resultRedirect;
    }
	
}
