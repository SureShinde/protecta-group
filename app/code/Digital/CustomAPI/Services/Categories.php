<?php

namespace Digital\CustomAPI\Services;

use Digital\CustomAPI\Helper\Data;
use Digital\CustomAPI\Helper\CustomLogger;
use Digital\CustomAPI\Services\NetSuiteServices;

class Categories {

    protected $classes;
    protected $groups;
    protected $subGroups;

    public function __construct() {
        $this->baseUrl = (new Data)->getBaseUrl();
    }

    /**
     * Get All Categories from database
     *
     * @return array, an array of default categories with their childrens
     */
    public function getCategories()
    {
        $url = $this->baseUrl . 'rest/default/V1/categories';
        $authorization = 'Authorization: Bearer xfc9y8dazdxvq8yiuv0scy2rz0ds4r37';

        $crl = curl_init();
        curl_setopt($crl, CURLOPT_URL, $url);
        curl_setopt($crl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json' ,
            $authorization
        ));
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($crl);
        $res = json_decode($response,true);
        curl_close($crl);

        if($res != null) {
            return $res['children_data'];
        }

        throw new \Exception('Can not fetch categories');
    }

    /**
     * Get all categories from database
     * and create an any array of classes, groups and sub-groups
     *
     * @return void
     * */
    public function setClassGroupSubgroup() {
        try {
            $categories = $this->getCategories();
            foreach($categories as $category) {
                if($category['name'] == 'Products') {
                    foreach($category['children_data'] as $class) {
                        $this->classes[strtolower($class['name'])] = $class['id'];
                        foreach($class['children_data'] as $group) {
                            $this->groups[strtolower($group['name'])] = $group['id'];
                            foreach($group['children_data'] as $sub_group) {
                                $this->subGroups[strtolower($sub_group['name'])] = $sub_group['id'];
                            }
                        }
                    }
                }
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * Check if class, group or sub-group already exists in the database
     *
     * @param string    $catName, category name to check
     * @param string    $catType, class|group|subgroup
     * @return false|object, returns false if does not exist, else returns class|group|sub-group object
     */
    public function getCategoryIfExists( $catName, $catType ) {

        if($catType == 'class') {
            if(isset($this->classes[strtolower($catName)]))
            {
                return $this->classes[strtolower($catName)];

            }
        } else if($catType == 'group') {
            if(isset($this->groups[strtolower($catName)])) {
                return $this->groups[strtolower($catName)];
            }
        }
        // else {
        //     if(isset($this->subGroups[strtolower($catName)])) {
        //         return $this->subGroups[strtolower($catName)];
        //     }
        // }

        return false;
    }

    /**
     * Compare the categories between NetSuite and database,
     * Create a new category if does not exits on database
     *
     * @param array
     * @return void
     */
    public function syncCategories( $categories ) {

        $netSuiteCategories = [];

        foreach($categories->classes as $class) {
            $nsclass['name'] = $class->name;
            $nsclass['children'] = [];
            foreach($categories->group as $group) {
                if($class->itemID == $group->parentId) {
                    $nsgroup['name'] = $group->name;
                    $nsgroup['children'] = $this->getChildren($group, $categories->subgroup);
                    $nsclass['children'][] = $nsgroup;
                }
            }
            array_push($netSuiteCategories, $nsclass);
        }

        // for class
        foreach($netSuiteCategories as $category) {
            if(strpos($category['name'], '-OLD') == false){
                $catName = $category['name'];
                $parentCatId = $this->createCategory($catName, 'class', 4);
                // for group
                foreach($category['children'] as $group) {
                    if(strpos($group['name'], '-OLD') == false){
                        $catName = $group['name'];
                        $parentGroupId = $this->createCategory($catName, 'group', $parentCatId);
                        // for subgroup
                        // foreach($group['children'] as $subgroup) {
                        //     if(strpos($subgroup, '-OLD') == false){
                        //         $this->createCategory($subgroup, 'subgroup', $parentGroupId);
                        //     }
                        // }
                    }
                }
            }

        }
    }

    /**
     * Create new category
     *
     * @param string    $catName, name of the category to create
     * @param string    $catType, type of category to create, class|group|subgroup
     * @param integer   $parentCatId, parent category Id of the new category
     * @return integer      new category id
     */
    public function createCategory( $catName, $catType, $parentCatId = 4) {
        if (!$catName) return;

        if($this->getCategoryIfExists( $catName, $catType )) {
            return $this->getCategoryIfExists( $catName, $catType );
        }

        $catName = strtolower($catName);

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $data = array(
            'data' => [
                "parent_id" =>  $parentCatId,
                "name" => ucwords($catName),
                "is_active" => true,
                // "position" => 4,
                "include_in_menu" => true,
            ]
        );

        $categoryManager = $objectManager->create('\Magento\Catalog\Model\Category', $data);

        $categoryManager->setCustomAttributes([
            "display_mode"=> "Products",
            "is_anchor"=> "1",
            "custom_use_parent_settings"=> "0",
            "custom_apply_to_products"=> "0",
            "automatic_sorting"=> "0",
            "url_key"=> str_replace(' ', '-', str_replace(array( '(', ')' ), '', $catName)),
            "url_path"=> str_replace(' ', '-', str_replace(array( '(', ')' ), '', $catName)),
        ]);

        $repository = $objectManager->get(\Magento\Catalog\Api\CategoryRepositoryInterface::class);
        $newCategory = $repository->save($categoryManager);

        return $newCategory['entity_id'];
    }

    public function getChildren($group, $subgroups) {
        $childrens = [];
        foreach($subgroups as $subgroup) {
            if($group->itemID == $subgroup->parentId) {
                array_push($childrens, $subgroup->name);
            }
        }

        return $childrens;
    }

	public function execute() {
        try {
            // Get class, group and sub-groups from NetSuite
            $nscategories = (new NetSuiteServices)->getCategories();

            $this->setClassGroupSubgroup();

            $this->syncCategories($nscategories);

        } catch (\Exception $e) {
            CustomLogger::webo_custom_logger('categories_sync', $e->getMessage());
        }
    }
}
