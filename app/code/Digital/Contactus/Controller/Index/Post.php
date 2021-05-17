<?php
namespace Digital\Contactus\Controller\Index;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use Digital\Contactus\Controller\AbstractAction;

class Post extends \Magento\Framework\App\Action\Action	
{	

	 const XML_PATH_CUSTOMER_EMAIL  = 'contactus/view/email_template';
	 const XML_PATH_ADMIN_EMAIL  = 'contactus/view/admin_email'; 
	 const XML_PATH_EMAIL_SENDER = 'contact/email/sender_email_identity';
	
	public function __construct(
        Context $context,
		\Magento\Framework\Controller\ResultFactory $resultFactory,
		\Magento\Framework\Translate\Inline\StateInterface $StateInterface,
		\Magento\Store\Model\StoreManagerInterface $StoreManagerInterface,
		\Digital\Contactus\Helper\Data $helperContactus,
		\Digital\Contactus\Model\Contactus $_contactusModel,
		
		\Digital\Contactus\Helper\Email $emailHelper		
    ){
        parent::__construct($context);		
		$this->resultFactory = $resultFactory;
		$this->StateInterface = $StateInterface;
		$this->StoreManagerInterface = $StoreManagerInterface;
		$this->_contactusModel = $_contactusModel;
		
		$this->helperContactus = $helperContactus;
		$this->EmailHelper = $emailHelper;
    }
	public function execute()
	{
		$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
		$post 			= $this->getRequest()->getPostValue();

		if (!$post) {
			$this->_redirect('*/*/');
			return;
		}	
		$name 		= $this->getRequest()->getPost('name');		
		$email 		= $this->getRequest()->getPost('email'); 		
		$phone    = $this->getRequest()->getPost('phone');		
		$company 	= $this->getRequest()->getPost('company');
		$message 	= $this->getRequest()->getPost('message');
		
		
		try {
			$error = false;			
			$this->_contactusModel->setData('name',$name);			
			$this->_contactusModel->setData('email',$email);			
			$this->_contactusModel->setData('phone',$phone);			
			$this->_contactusModel->setData('company',$company);
			$this->_contactusModel->setData('message',$message);
			
			
			if (!isset($post['name']) && !\Zend_Validate::is(trim($post['name']), 'NotEmpty')) {
				$error = true;
			}						
			if (!isset($post['email']) && !\Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
				$error = true;
			}			
			if ($post['g-recaptcha-response'] == '' && isset($post['g-recaptcha-response'])){
				$error = true;
			} 
			if ($error) {
				throw new \Exception();
			}

			$postObject = new \Magento\Framework\DataObject();			
			$postObject->setData($post);
			$postObject->setData('name',$name);
			
			
			/* Receiver Detail  */
			 $receiveremail = $this->helperContactus->Recipientemail();
			
			$receiverInfo = [
				'name' => 'Contact Us',
				'email' => $receiveremail, /*'test12.23digital@gmail.com',*/
			];

				 $sendername = $this->helperContactus->GeneralName();
				 $senderemail = $this->helperContactus->GeneralEmail(); 
			
			$senderInfo = [
				'name' => $sendername,
				'email' => $senderemail,
			];				
			
			// Data base store data
			//var_dump($post); exit();
			$this->_contactusModel->save();			
			
			$customerInfo = [
				'name' =>   $name,
				'email' => $email,
			];		
			
			/*Email to admin start*/
			$this->EmailHelper->contactEnquiryMailSendMethod($postObject,$senderInfo,$receiverInfo); 	
			/*Email to admin end*/
			
			/*Email to customer start*/
			$this->EmailHelper->contactMailSendMethodToCustomer($postObject,$senderInfo,$customerInfo);	
			/*Email to customer end*/			
			
			$this->messageManager->addSuccess(__("Your enquiry has been submitted and will be responded to as soon as possible."));
		} catch (\Exception $e) {
			$this->messageManager->addError(__('We can\'t process your request right now. Sorry, that\'s all we know.'));
			//$this->messageManager->addError($e->getMessage());
		} 		
		$resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }
}
