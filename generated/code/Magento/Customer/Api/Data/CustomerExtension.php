<?php
namespace Magento\Customer\Api\Data;

/**
 * Extension class for @see \Magento\Customer\Api\Data\CustomerInterface
 */
class CustomerExtension extends \Magento\Framework\Api\AbstractSimpleObject implements CustomerExtensionInterface
{
    /**
     * @return boolean|null
     */
    public function getIsSubscribed()
    {
        return $this->_get('is_subscribed');
    }

    /**
     * @param boolean $isSubscribed
     * @return $this
     */
    public function setIsSubscribed($isSubscribed)
    {
        $this->setData('is_subscribed', $isSubscribed);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAmazonId()
    {
        return $this->_get('amazon_id');
    }

    /**
     * @param string $amazonId
     * @return $this
     */
    public function setAmazonId($amazonId)
    {
        $this->setData('amazon_id', $amazonId);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getParentId()
    {
        return $this->_get('parent_id');
    }

    /**
     * @param string $parentId
     * @return $this
     */
    public function setParentId($parentId)
    {
        $this->setData('parent_id', $parentId);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubaccounts()
    {
        return $this->_get('subaccounts');
    }

    /**
     * @param string $subaccounts
     * @return $this
     */
    public function setSubaccounts($subaccounts)
    {
        $this->setData('subaccounts', $subaccounts);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getVertexCustomerCode()
    {
        return $this->_get('vertex_customer_code');
    }

    /**
     * @param string $vertexCustomerCode
     * @return $this
     */
    public function setVertexCustomerCode($vertexCustomerCode)
    {
        $this->setData('vertex_customer_code', $vertexCustomerCode);
        return $this;
    }
}
