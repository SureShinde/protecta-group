<?php
namespace Digital\CustomAPI\Model;

class Shippingzone implements \Digital\CustomAPI\Api\ShippingzoneInterface
{	
	/**
      * setshippingzonedata function
      *
      * @api
      * @param mixed $param
      * @return array
     */
    
    public function setshippingzonedata($param)
    {    
	    try{				
				$result = array();			
				if(count($param)>0)
				{					
					$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
					
					foreach($param as $item)
					{
						if(trim($item['internal_id'])!='')
						{

							$model = $objectManager->create('Dcs\CustomShippingPrice\Model\CustomShippingZone');
							$model->load($item['internal_id'],'internal_id');
							
							if(trim($item['delete'])==false || trim($item['delete'])=='false')
							{
								$model->setInternalId(trim($item['internal_id']));
								$model->setZone(trim($item['zone']));
								$model->setNsw(trim($item['nsw']));
								$model->setQld(trim($item['qld']));
								$model->setVic(trim($item['vic']));
								$model->setWa(trim($item['wa']));

								$model->save();
							}
							else if(trim($item['delete'])==true || trim($item['delete'])=='true')
							{
								$model->delete();	
							}
							else
							{								
							}
						}
						else
						{
							$result['status'] = 'error';
							return $result;
						}


					}

					$result['status'] = 'success';
				}
				else
				{
					$result['status'] = 'error';
				}
			} catch (\Exception $e) {
	             $result['status'] = 'error';   
	        }			
			return $result;		
    }


}