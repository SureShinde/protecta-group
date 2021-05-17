<?php
namespace Dcs\Megamenuimg\Controller\Adminhtml\Category\Save;

class Plugin
{           
    //add thumnail field to $data for saving
    public function afterImagePreprocessing(\Magento\Catalog\Controller\Adminhtml\Category\Save $subject, $data)
    {
		// Menu Thumbnail Image
			if (isset($data['menu_thumbnail']) && is_array($data['menu_thumbnail'])) {				
				if (!empty($data['menu_thumbnail']['delete'])) {
					$data['menu_thumbnail'] = null;
				} else {
					if (isset($data['menu_thumbnail'][0]['name']) && isset($data['menu_thumbnail'][0]['tmp_name'])) {
						$data['menu_thumbnail'] = $data['menu_thumbnail'][0]['name'];
					} else {
						unset($data['menu_thumbnail']);
					}
				}
			}else{
				$data['menu_thumbnail'] = null;
			}
		// End Menu Thumbnail Image
		
		// Menu First Image
			if (isset($data['menu_first_img']) && is_array($data['menu_first_img'])) {				
				//echo '2';
				//exit;
				if (!empty($data['menu_first_img']['delete'])) {
					$data['menu_first_img'] = null;
				} else {
					if (isset($data['menu_first_img'][0]['name']) && isset($data['menu_first_img'][0]['tmp_name'])) {
						$data['menu_first_img'] = $data['menu_first_img'][0]['name'];
					} else {
						unset($data['menu_first_img']);
					}
				}
			}else{
				$data['menu_first_img'] = null;
			}
		// End Menu First Image
		
		
        //print_r($data);
		//exit;
        return $data;
    }

}
