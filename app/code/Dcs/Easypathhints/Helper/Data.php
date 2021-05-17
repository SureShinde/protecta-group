<?php
namespace Dcs\Easypathhints\Helper;


class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_ENABLED     = 'general/enabled';    

    public function getConfigPath(
        $xmlPath,
        $section = 'dcs_easypathhints'
    ) {
        return $section . '/' . $xmlPath;
    }

    public function isEnabled()
    {
        return $this->scopeConfig->getValue(
            $this->getConfigPath(self::XML_PATH_ENABLED),
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    } 

    public function shouldShowTemplatePathHints()
    {
        $isActive = $this->isEnabled();
        $tp = (int)$this->_getRequest()->getParam('tp');

        if ($tp == 1 && $isActive){
            return true;
        } 
        return false;
    }    
}
