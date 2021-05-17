<?php
namespace Dcs\Updateaccount\Controller\Index;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Action\Context;
use Dcs\Updateaccount\Controller\AbstractAction;
use Magento\Framework\Controller\ResultFactory;
use Magento\Store\Model\ScopeInterface;

class Post extends \Magento\Framework\App\Action\Action
{
	public function __construct(
        Context $context,
        \Magento\Framework\Controller\ResultFactory $resultFactory,
		\Magento\Framework\Translate\Inline\StateInterface $StateInterface,
		\Magento\Store\Model\StoreManagerInterface $StoreManagerInterface,
		\Dcs\Updateaccount\Helper\Data $helperUpdateaccount
    ) {
        parent::__construct($context);	
        $this->resultFactory = $resultFactory;
        $this->StateInterface = $StateInterface;
		$this->StoreManagerInterface = $StoreManagerInterface;
		$this->helperUpdateaccount = $helperUpdateaccount;
    }
		public function execute() {		 
			
		$post 				= $this->getRequest()->getPostValue();
		
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance(); 
		$customerSession = $objectManager->get('Magento\Customer\Model\Session');
		
		$customer_name = $customerSession->getCustomer()->getName(); 
		$customer_email = $customerSession->getCustomer()->getEmail();
		$customer_code 	= 'Test-123456';
		$customer_company = 'Test Company';
	
		$request_type 	= $this->getRequest()->getPost('request_type');
        $request_content = $this->getRequest()->getPost('request_content');
        
		$model = $this->_objectManager->create('Dcs\Updateaccount\Model\Updateaccount');
		$helper = $this->_objectManager->get('Dcs\Updateaccount\Helper\Data');		
	
		if (!$post) {
			$this->_redirect('*/*/');
			return;
		}
		try {
			$error = false;
			
			if($request_content=='' || $request_type=='')
			{
				$this->messageManager->addError(
						__('Invalid Fields Value.'));
				$this->_redirect('updateaccount/index');
				return;
			}
			 
			$model->setData('request_type',$request_type);
            $model->setData('request_content',$request_content);
			$model->setData('customer_name',$customer_name);
            $model->setData('customer_email',$customer_email);
            $model->setData('customer_code',$customer_code);
            $model->setData('customer_company',$customer_company);
            
			
			if (!\Zend_Validate::is(trim($post['request_type']), 'NotEmpty')) {
                $error = true;
            }
            if (!\Zend_Validate::is(trim($post['request_content']), 'NotEmpty')) {
                $error = true;
            }
            
						
			if(!isset($post['g-recaptcha-response']) || $post['g-recaptcha-response'] == ''){	
				$error = true;
			}
			
			if ($error) {				
				throw new \Exception();
			}

			try {
				
				// Receiver Detail
				
			$receiveremail = $helper->Recipientemail();
			$receivername = $helper->Recipientname();
			
				$receiverInfo = [
					'name' => $receivername,
					'email' => $receiveremail,
				];
				$sendername = $helper->GeneralName();
				$senderemail = $helper->GeneralEmail();
				
				$senderInfo = [
					'name' => $sendername,
					'email' => $senderemail,
				];
				// Assign values for your template variables 
				$emailTemplateVariables = array();
				$emailTemplateVariables = array(
					'customer_name'				=> $customer_name,
					'customer_email' 			=> $customer_email,
					'customer_code'   			=> $customer_code,
					'customer_company'			=> $customer_company,
					'request_type'				=> $request_type,
					'request_content'			=> $request_content,
                );			
				
				/* [ Admin Mail Send ]*/
				$this->_objectManager->get('Dcs\Updateaccount\Helper\Email')->updateaccountMailSendMethod($emailTemplateVariables,$senderInfo,$receiverInfo);
								
				
				$model->save(); 
				$this->helperUpdateaccount->setMessage(true,__('Your enquiry has been received and will be responded in 24-48 hours.'));
				
				$this->_redirect('updateaccount/index');
				return;
				

			}catch (\Exception $e) {
			$this->helperUpdateaccount->setMessage(true,__('We can\'t process your request right now. Sorry, that\'s all we know.'.$e->getMessage()));
			
			}

		} catch (\Exception $e) {	
			$this->helperUpdateaccount->setMessage(true,__('We can\'t process your request right now. Sorry, that\'s all we know.'.$e->getMessage()));
			
		}
		
		$this->_redirect('updateaccount/index');
		return;
    }
}
