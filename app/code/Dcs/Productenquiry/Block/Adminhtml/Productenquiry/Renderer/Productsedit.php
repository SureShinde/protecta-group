<?php
namespace Dcs\Productenquiry\Block\Adminhtml\Productenquiry\Renderer;

use Magento\Framework\DataObject;

class Productsedit extends \Magento\Framework\Data\Form\Element\AbstractElement
{
   	public function getElementHtml()
    {
        $value = $this->getValue();
		$individualHtml = "";
		if($value!='')
		{
			$productsData = @unserialize($value);

			if($productsData !== false || $value === 'b:0;')
			{
				foreach($productsData as $productdata)
				{
					if(isset($productdata['sku']))
					{
						$individualHtml .= "<p>".$productdata['name']." [".$productdata['sku']."] "." (".$productdata['qty'].") </p>";
					}
					else
					{
						$individualHtml .= "<p>".$productdata['name']." (".$productdata['qty'].") </p>";
					}
				}
			}	
		}
		
		
        return $individualHtml;
    }
}
