<?php

namespace WEBO\NetSuite\Helper;

use WEBO\NetSuite\Helper\CustomLogger;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;

class SendSyncFailedEmail
{
    protected $transportBuilder;
    protected $storeManager;
    protected $inlineTranslation;

    public function sendEmail($message)
    {
        // this is an example and you can change template id,fromEmail,toEmail,etc as per your need.
        $templateId = 'netsuite_sync_fail_template';
        $fromEmail = 'jagdish.kunwar@webo.digital';
        $fromName = 'Admin';
        $toEmail = 'jagdish.kunwar@webo.digital';
        $storeManager = \Magento\Store\Model\StoreManagerInterface::getInstance();

        try {
            $templateOptions = array(
                'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                'store' => $storeManager->getStore()->getId()
            );
            $templateVars = array(
                'store' => $storeManager->getStore(),
                'customer_name' => 'Jagdish Kunwar',
                'message'	=> $message
            );

            $storeId = $storeManager->getStore()->getId();

            $from = ['email' => $fromEmail, 'name' => $fromName];
            $inlineTranslation = \Magento\Framework\Translate\Inline\StateInterface::getInstance();
            $inlineTranslation->suspend();

            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $templateOptions = [
                'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                'store' => $storeId
            ];

            $transportBuilder = \Magento\Framework\Mail\Template\TransportBuilder::getInstance();
            $transport = $transportBuilder->setTemplateIdentifier($templateId, $storeScope)
                ->setTemplateOptions($templateOptions)
                ->setTemplateVars($templateVars)
                ->setFrom($from)
                ->addTo($toEmail)
                ->getTransport();
            $transport->sendMessage();
            $inlineTranslation->resume();
        } catch (\Exception $e) {
            CustomLogger::webo_custom_logger('email_failed', $e->getMessage());
        }
    }
}
