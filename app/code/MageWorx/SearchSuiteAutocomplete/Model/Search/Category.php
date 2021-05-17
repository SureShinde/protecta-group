<?php

namespace MageWorx\SearchSuiteAutocomplete\Model\Search;

use \Magento\Search\Model\QueryFactory;
use Magento\Store\Model\StoreManagerInterface;
use \Magento\Framework\ObjectManagerInterface as ObjectManager;
use \MageWorx\SearchSuiteAutocomplete\Helper\Data as HelperData;
use \MageWorx\SearchSuiteAutocomplete\Model\Source\AutocompleteFields;

/**
 * Product model. Return product data used in search autocomplete
 */
class Category implements \MageWorx\SearchSuiteAutocomplete\Model\SearchInterface
{
    /**
     * @var \MageWorx\SearchSuiteAutocomplete\Helper\Data
     */
    protected $helperData;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var \Magento\Search\Model\QueryFactory
     */
    private $queryFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Product constructor.
     *
     * @param StoreManagerInterface $storeManager
     * @param HelperData $helperData
     * @param ObjectManager $objectManager
     * @param QueryFactory $queryFactory
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        HelperData $helperData,
        ObjectManager $objectManager,
        QueryFactory $queryFactory
    ) {
        $this->storeManager       = $storeManager;
        $this->helperData         = $helperData;
        $this->objectManager      = $objectManager;
        $this->queryFactory       = $queryFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getResponseData()
    {
        $responseData['code'] = AutocompleteFields::CATEGORY;
        $responseData['data'] = [];

        // if (!$this->canAddToResult()) {
        //     return $responseData;
        // }

        $query                 = $this->queryFactory->get();
        $queryText             = $query->getQueryText();

        $responseData['data'] = $this->getCategoryCollection($queryText);

        return $responseData;
    }

    /**
     * Retrive product collection by query text
     *
     * @param string $queryText
     * @return mixed
     */
    protected function getCategoryCollection($queryText)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $categoryFactory = $this->objectManager->create('Magento\Catalog\Model\ResourceModel\Category\CollectionFactory');
        $categoryCollection = $categoryFactory->create()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('url_path')
            ->addAttributeToFilter('name',['like'=> "%".$queryText."%"])
            ->setStore($this->getStoreId());

        $products = [];
        $solutions = [];
        $baseUrl = $this->storeManager->getStore()->getBaseUrl();

        foreach ($categoryCollection as $key => $category){
            $urlInitial = explode('/', $category->getUrlPath())[0];
            if($urlInitial == 'solutions') {
                $solutions[$key]['name'] =  $category->getName();
                $solutions[$key]['url'] = $baseUrl .''. $category->getUrlPath() . '.html';
            } else if($urlInitial == 'products') {
                $products[$key]['name'] = $category->getName();
                $products[$key]['url'] = $baseUrl .''. $category->getUrlPath() . '.html';
            }
        }

        return [
            'products' => $products,
            'solutions' => $solutions
        ];
    }

    /**
     * @return int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getStoreId()
    {
        return $this->storeManager->getStore()->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function canAddToResult()
    {
        return in_array(AutocompleteFields::CATEGORY, $this->helperData->getAutocompleteFieldsAsArray());
    }
}
