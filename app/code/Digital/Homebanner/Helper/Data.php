<?php
namespace Digital\Homebanner\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    const XML_PATH_ENABLED = 'homebanner_section/general/enable';

    const MOBILE_VALUE  = 0;

    const DESKTOP_VALUE = 1;

    const TABLET_VALUE  = 2;

    const COMBINE_VALUE = 3;

    const MOBILE_LABEL  = "Mobile";

    const DESKTOP_LABEL = "Desktop";

    const TABLET_LABEL  = "Tablet";

    //const COMBINE_LABEL = "Combine (Mobile,Tablet,Desktop)";
    const COMBINE_LABEL = "Both";

    /**
     * Retrieve option array
     *
     * @return string[]
     */
    public static function getOptionArray()
    {
        return [
			self::DESKTOP_VALUE => self::DESKTOP_LABEL,
			self::MOBILE_VALUE => self::MOBILE_LABEL,
			//self::TABLET_VALUE => self::TABLET_LABEL,
			self::COMBINE_VALUE => self::COMBINE_LABEL
		];
    }

    public function isEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
	public function checkDevice()
    {
        $iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
        $android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
        $mobile = strpos($_SERVER['HTTP_USER_AGENT'],"Mobile");
        $palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
        $berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
        $ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
        if ($iphone || ($android && $mobile) || $palmpre || $ipod || $berry == true)
        {
            return 1;
        }
		else
		{
        	return 0;
		}
    }

		public function checkDeviceNew()
		{
        	$userAgent = $_SERVER['HTTP_USER_AGENT'];
	        // Mobile
        	$iphone     = strpos($userAgent,"iPhone");
        	$android    = strpos($userAgent,"Android");
			$mobile     = strpos($userAgent,"Mobile");
			$palmpre    = strpos($userAgent,"webOS");
			$berry      = strpos($userAgent,"BlackBerry");
			$ipod       = strpos($userAgent,"iPod");
			// Tablet
			$ipad       = strpos(strtolower($userAgent),"ipad");
			$playbook   = strpos(strtolower($userAgent),"playbook");
			$kindle     = strpos(strtolower($userAgent),"kindle");
			$tablet     = strpos(strtolower($userAgent),"tablet");
			if ($iphone || ($android && $mobile) || $palmpre || $ipod || $berry == true){
				return 1; // mobile
			} elseif($ipad || ($android && $tablet) || $kindle || $playbook == true){
				return 2; // tablet
			}
			return 0; // desktop
    }



  /*  public function checkDevice()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        // Mobile
        $iphone     = strpos($userAgent,"iPhone");
        $android    = strpos($userAgent,"Android");
        $mobile     = strpos($userAgent,"Mobile");
        $palmpre    = strpos($userAgent,"webOS");
        $berry      = strpos($userAgent,"BlackBerry");
        $ipod       = strpos($userAgent,"iPod");
        // Tablet
        $ipad       = strpos(strtolower($userAgent),"ipad");
        $playbook   = strpos(strtolower($userAgent),"playbook");
        $kindle     = strpos(strtolower($userAgent),"kindle");
        $tablet     = strpos(strtolower($userAgent),"tablet");

        if ($iphone || ($android && $mobile) || $palmpre || $ipod || $berry == true){
            return 1;
        } elseif($ipad || ($android && $tablet) || $kindle || $playbook == true){
            return 2;
        }
        return 0;
    }
	*/
    public function getMobileArray(){
        return [self::MOBILE_VALUE , self::COMBINE_VALUE];
    }

    public function getDesktopArray(){
        return [self::DESKTOP_VALUE ,self::COMBINE_VALUE];
    }

    public function getTabletArray(){
        return [self::TABLET_VALUE ,self::COMBINE_VALUE];
    }
}
