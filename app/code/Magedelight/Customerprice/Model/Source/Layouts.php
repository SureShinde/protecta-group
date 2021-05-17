<?php

/**
 * Magedelight
* Copyright (C) 2017 Magedelight <info@magedelight.com>
*
* @category Magedelight
* @package Magedelight_Customerprice
* @copyright Copyright (c) 2017 Mage Delight (http://www.magedelight.com/)
* @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
* @author Magedelight <info@magedelight.com>
 */

namespace Magedelight\Customerprice\Model\Source;

class Layouts
{
    protected $objectManager;
    protected $pageLayoutBuilder;

    /**
     * @param \Magento\Framework\View\Model\PageLayout\Config\BuilderInterface $pageLayoutBuilder
     */
    public function __construct(
    \Magento\Framework\View\Model\PageLayout\Config\BuilderInterface $pageLayoutBuilder
    ) {
        $this->pageLayoutBuilder = $pageLayoutBuilder;
    }

    public function toOptionArray()
    {
        $result = $this->pageLayoutBuilder->getPageLayoutsConfig()->toOptionArray(true);

        return $result;
    }
}
