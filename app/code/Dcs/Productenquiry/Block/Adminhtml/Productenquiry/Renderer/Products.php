<?php
namespace Dcs\Productenquiry\Block\Adminhtml\Productenquiry\Renderer;

use Magento\Framework\DataObject;

class Products extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
   	public function render(DataObject $row)
    {
        $value = $row->getData($this->getColumn()->getIndex());
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
