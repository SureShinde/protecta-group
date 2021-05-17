<?php 

namespace Dcs\Newsletter\Controller\Subscriber;

class NewAction extends \Magento\Newsletter\Controller\Subscriber\NewAction
{
    
    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $session = $objectManager->get('Magento\Customer\Model\Session');
        if ($this->getRequest()->isPost() && $this->getRequest()->getPost('email')) {
            $email = (string)$this->getRequest()->getPost('email');

            try {
                $this->validateEmailFormat($email);
                $this->validateGuestSubscription();
                $this->validateEmailAvailable($email);

                $status = $this->_subscriberFactory->create()->subscribe($email);
                if ($status == \Magento\Newsletter\Model\Subscriber::STATUS_NOT_ACTIVE) {                    
                    /*$session->setMessageType('success');
                    $session->setNewsletterMessage('The confirmation request has been sent.');*/
					$this->messageManager->addSuccess(__('The confirmation request has been sent.'));
                } else {                    
                    /*$session->setMessageType('success');
                    $session->setNewsletterMessage('Thank you for your subscription.');*/
					$this->messageManager->addSuccess(__('Thank you for your subscription.'));
                }
            } catch (\Magento\Framework\Exception\LocalizedException $e) {                
                //$session->setMessageType('error');
                //$session->setNewsletterMessage('There was a problem with the subscription: This email address is already assigned to another user.');
				$this->messageManager->addException(
                    $e,
                    __('There was a problem with the subscription: %1', $e->getMessage())
                );
            } catch (\Exception $e) {                
                /*$session->setMessageType('error');
                $session->setNewsletterMessage('Something went wrong with the subscription.');*/
				$this->messageManager->addException($e, __('Something went wrong with the subscription.'));
            }
        }
        $this->getResponse()->setRedirect($this->_redirect->getRedirectUrl());
    }
}