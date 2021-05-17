<?php
namespace Digital\CustomAPI\Model;

class Shippingwarehouse implements \Digital\CustomAPI\Api\ShippingwarehouseInterface
{	
	/**
      * setshippingwarehousedata function
      *
      * @api
      * @param mixed $param
      * @return array
     */
    
    public function setshippingwarehousedata($param)
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
								$model = $objectManager->create('Dcs\CustomShippingPrice\Model\CustomShippingPrice');
								$model->load($item['internal_id'],'internal_id');

								if(trim($item['delete'])==false || trim($item['delete'])=='false')
								{	

										$model->setCountryName(trim($item['countryName']));
										$model->setRegionName(trim($item['regionName']));

										if(trim($item['regionName'])=='ACT') { $model->setRegionId('569');}
												else if(trim($item['regionName'])=='NSW') { $model->setRegionId('570');}
												else if(trim($item['regionName'])=='NT') { $model->setRegionId('571');}
												else if(trim($item['regionName'])=='QLD') { $model->setRegionId('572');}
												else if(trim($item['regionName'])=='SA') { $model->setRegionId('573');}
												else if(trim($item['regionName'])=='TAS') { $model->setRegionId('574');}
												else if(trim($item['regionName'])=='VIC') { $model->setRegionId('575');}
												else if(trim($item['regionName'])=='WA') { $model->setRegionId('576');}
												else{$model->setRegionId('');}

										$model->setInternalId(trim($item['internal_id']));
										$model->setZone(trim($item['zone']));
										$model->setZipFrom(trim($item['zipFrom']));
										$model->setZipTo(trim($item['zipTo']));
										$model->setWeightFrom(trim($item['weightFrom']));
										$model->setWeightTo(trim($item['weightTo']));
										$model->setVolumeFrom(trim($item['volumeFrom']));
										$model->setVolumeTo(trim($item['volumeTo']));
										$model->setProfileName(trim($item['profileName']));
										$model->setPrice(trim($item['shippingPrice']));
										$model->setDeliveryType(trim($item['shippingName']));
										if(isset($item['shippingDescription']))
										{
											$model->setShippingDescription(trim($item['shippingDescription']));
										}
										
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