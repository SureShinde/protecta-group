<?php
namespace Dcs\Megamenuimg\Model\Category\DataProvider;

class Plugin
{       
    protected $_storeManager;

    public function __construct(        
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {       
        $this->_storeManager = $storeManager;    
    }

    //retrieve thumnail data for output
    public function afterGetData(\Magento\Catalog\Model\Category\DataProvider $subject, $result)
    {
        $category = $subject->getCurrentCategory();
        $categoryData = $result[$category->getId()];
		
		/*echo '1';
		echo '<pre>';
			print_r($categoryData);
		echo '</pre>';
		exit;*/

        // Menu Thumbnail
		if (isset($categoryData['menu_thumbnail'])) {
            unset($categoryData['menu_thumbnail']);
            $categoryData['menu_thumbnail'][0]['name'] = $category->getData('menu_thumbnail');
            $categoryData['menu_thumbnail'][0]['url'] = $this->getImageUrl($category->getData('menu_thumbnail'));
        }
		
		// Menu First Image
		if (isset($categoryData['menu_first_img'])) {
            unset($categoryData['menu_first_img']);
            $categoryData['menu_first_img'][0]['name'] = $category->getData('menu_first_img');
            $categoryData['menu_first_img'][0]['url'] = $this->getImageUrl($category->getData('menu_first_img'));
        }
		
        $result[$category->getId()] = $categoryData;
        
        return $result;
    }

    protected function getImageUrl($imageName){
        $url = $this->_storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            ) . 'catalog/category/' . $imageName;
        return $url;
    }
}
