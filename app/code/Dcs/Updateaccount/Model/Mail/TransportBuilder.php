<?php
namespace Dcs\Updateaccount\Model\Mail;

use Magento\Framework\App\TemplateTypesInterface;
use Magento\Framework\Mail\MessageInterface; 
class TransportBuilder extends \Magento\Framework\Mail\Template\TransportBuilder
{
    public function addAttachment(
        $body,
        $filename    = null 
    ) {
        $this->message->createAttachment(
            $this->prepareAttchMessage(),
            'application/docx',
            \Zend_Mime::DISPOSITION_ATTACHMENT,
            \Zend_Mime::ENCODING_BASE64,
            $filename.'.docx'
        );
        return $this;
    }
    public function prepareAttchMessage()
    {
        $template = $this->getTemplate();
        $types = [
            TemplateTypesInterface::TYPE_TEXT => MessageInterface::TYPE_TEXT,
            TemplateTypesInterface::TYPE_HTML => MessageInterface::TYPE_HTML,
        ];

        return $body = $template->processTemplate();
         
    }
}
