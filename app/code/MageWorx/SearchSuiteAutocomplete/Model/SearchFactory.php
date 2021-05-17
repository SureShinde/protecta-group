<?php


namespace MageWorx\SearchSuiteAutocomplete\Model;

use Digital\CustomAPI\Helper\CustomLogger;
use Magento\Framework\ObjectManagerInterface as ObjectManager;

/**
 * SearchFactory class for Search model
 */
class SearchFactory
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager = null;

    /**
     * @var string
     */
    protected $map;

    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param array $map
     */
    public function __construct(
        ObjectManager $objectManager,
        array $map = []
    ) {
        $this->objectManager = $objectManager;
        $this->map           = $map;
    }

    /**
     *
     * @param string $param
     * @param array $arguments
     * @return \MageWorx\SearchSuiteAutocomplete\Model\SearchInterface
     * @throws \UnexpectedValueException
     */
    public function create($param, array $arguments = [])
    {
        $this->map['category'] = "MageWorx\\SearchSuiteAutocomplete\\Model\\Search\\Category";

        if (isset($this->map[$param])) {
            $instance = $this->objectManager->create($this->map[$param], $arguments);
        } else {
            $instance = $this->objectManager->create(
                '\MageWorx\SearchSuiteAutocomplete\Model\Search\Category',
                $arguments
            );
        }

        if (!$instance instanceof \MageWorx\SearchSuiteAutocomplete\Model\SearchInterface) {
            throw new \UnexpectedValueException(
                'Class ' . get_class(
                    $instance
                ) . ' should be an instance of \MageWorx\SearchSuiteAutocomplete\Model\SearchInterface'
            );
        }

        return $instance;
    }
}
