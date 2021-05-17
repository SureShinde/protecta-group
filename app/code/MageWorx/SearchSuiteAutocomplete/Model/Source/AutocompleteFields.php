<?php

namespace MageWorx\SearchSuiteAutocomplete\Model\Source;

class AutocompleteFields
{
    const SUGGEST = 'suggest';

    const PRODUCT = 'product';

    const CATEGORY = 'category';

    /**
     *
     * @return array
     */
    public function toOptionArray()
    {
        $this->options = [
            ['value' => self::SUGGEST, 'label' => __('Suggested')],
            ['value' => self::PRODUCT, 'label' => __('Products')],
            ['value' => self::CATEGORY, 'label' => __('Categories')],
        ];

        return $this->options;
    }
}
