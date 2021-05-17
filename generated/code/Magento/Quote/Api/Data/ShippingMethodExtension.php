<?php
namespace Magento\Quote\Api\Data;

/**
 * Extension class for @see \Magento\Quote\Api\Data\ShippingMethodInterface
 */
class ShippingMethodExtension extends \Magento\Framework\Api\AbstractSimpleObject implements ShippingMethodExtensionInterface
{
    /**
     * @return string|null
     */
    public function getTitle()
    {
        return $this->_get('title');
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->setData('title', $title);
        return $this;
    }
}
