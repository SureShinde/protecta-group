<?php
/**
 * Copyright © 2016 Dcs. All rights reserved.
 * See MS-LICENSE.txt for license details.
 */
namespace Dcs\CustomShippingPrice\Model\Carrier;

use Digital\CustomAPI\Helper\CustomLogger;
use Magento\Shipping\Model\Carrier\AbstractCarrier ;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Psr\Log\LoggerInterface;
use Magento\Shipping\Model\Rate\ResultFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Backend\Model\Auth\Session;

class CustomShipping extends AbstractCarrier implements CarrierInterface
{
    /**
     * @var string
     */
    protected $_code = 'dcsshipping';

    /**
     * @var bool
     */
    protected $_isFixed = true;

    /**
     * @var \Magento\Shipping\Model\Rate\ResultFactory
     */
    protected $_rateResultFactory;

    /**
     * @var \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory
     */
    protected $_rateMethodFactory;

    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $_session;
	private $productFactory;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param ErrorFactory $rateErrorFactory
     * @param LoggerInterface $logger
     * @param ResultFactory $rateResultFactory
     * @param MethodFactory $rateMethodFactory
     * @param Session $authSession
     * @param array $data
     */
    public function __construct(
		\Magento\Catalog\Model\ProductFactory $productFactory,
		\Magento\Checkout\Model\Cart $_cart,
		\Magento\Framework\App\ResourceConnection $_resourceconnection,
        ScopeConfigInterface $scopeConfig,
        ErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        ResultFactory $rateResultFactory,
        MethodFactory $rateMethodFactory,
        Session $authSession,
        array $data = []
    ) {
		$this->productFactory = $productFactory;
		$this->_cart = $_cart;
		$this->_resourceconnection = $_resourceconnection;
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        $this->_session = $authSession;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
	}

    /**
     * FreeShipping Rates Collector
     *
     * @param RateRequest $request
     * @return \Magento\Shipping\Model\Rate\Result|bool
     */

	public function getTotalVolume($request)
	{
		$volume_total = 0;
		$items = $request->getAllItems();
		foreach($items as $item)
		{
			$product = $this->productFactory->create();
     		$product->load($item->getProductId());
			$product_volume = '';
			if($product->getPgVolume()>0 && $product->getPgVolume()!='')
			{
				$product_volume = $product->getPgVolume() * $item->getQty();
				$volume_total = $volume_total + $product_volume;
			}
			$product = '';
		}
		return $volume_total;
	}

	public function getZoneFromPostCode($country_name,$postcode)
	{
		$resource = $this->_resourceconnection;
		$readConnection = $resource->getConnection('core_read');
		$country_name = "Australia";
		$query_get_zone = "SELECT * FROM `digital_matrixrate` WHERE `country_name`='".$country_name."' AND `zip_from` <= '".$postcode."' AND `zip_to` >= '".$postcode."' LIMIT 1";
		$results_get_zone = $readConnection->fetchAll($query_get_zone);
		if(count($results_get_zone)>0)
		{
			return $results_get_zone[0]['zone'];
		}
	}

	public function getCheckProductAvailableInStore($region_name,$request)
	{
		$status_array = array();
		$items = $request->getAllItems();
		foreach($items as $item)
		{
			$cart_qty = $item->getQty();

			$simple_product = $this->productFactory->create();
     		$simple_product->load($item->getProductId());
			if($region_name=='NSW')
			{
				if($cart_qty <= $simple_product->getPgSydneyQty())
				{
					$status_array[] = 1;
				}
				else
				{
					$status_array[] = 0;
				}
			}
			else if($region_name=='QLD')
			{
				if($cart_qty <= $simple_product->getPgBrisbaneQty())
				{
					$status_array[] = 1;
				}
				else
				{
					$status_array[] = 0;
				}
			}
			else if($region_name=='VIC')
			{
				if($cart_qty <= $simple_product->getPgMelbourneQty())
				{
					$status_array[] = 1;
				}
				else
				{
					$status_array[] = 0;
				}
			}
			else if($region_name=='WA')
			{
				if($cart_qty <= $simple_product->getPgPerthQty())
				{
					$status_array[] = 1;
				}
				else
				{
					$status_array[] = 0;
				}
			}


			$simple_product = '';
		}
		return $status_array;

	}

    public function showPoaMethods()
	{
		$result = $this->_rateResultFactory->create();
		$foundRates = false;

		$method1 = $this->_rateMethodFactory->create();
		$method1->setCarrier('dcsshipping');
		$method1->setCarrierTitle($this->getConfigData('title'));
		$method1->setMethod('dcsshipping_standard');
		//$method1->setMethodTitle('POA - Standard National Road Freight (near)');
		$method1->setMethodTitle('Special Timed / Regional / Oversized Deliveries');
		$amount1 = 0.00;
		$method1->setPrice($amount1);
		$method1->setCost($amount1);
		$result->append($method1);


		/*$method2 = $this->_rateMethodFactory->create();
		$method2->setCarrier('dcsshipping');
		$method2->setCarrierTitle($this->getConfigData('title'));
		$method2->setMethod('dcsshipping_express');
		//$method2->setMethodTitle('POA - Express National Road Freight (regional)');
		$method2->setMethodTitle('Special Timed / Regional / Oversized Deliveries');
		$amount2 = 0.00;
		$method2->setPrice($amount2);
		$method2->setCost($amount2);
		$result->append($method2);*/


		$foundRates = true;
		return $result;
	}

	public function getAllProductProfile($request)
	{
		$profile_array = array();
		$items = $request->getAllItems();
		foreach($items as $item)
		{
			$product = $this->productFactory->create();
     		$product->load($item->getProductId());
			if($product->getPgProductProfile())
			{
				$profile_array[] = $product->getAttributeText('pg_product_profile');
			}
			else
			{
				return 0;
			}
			$product = '';
		}

		return $profile_array;
	}

	public function showDeliveryOptions($results_final)
	{
		$result = $this->_rateResultFactory->create();
		$foundRates = false;
		foreach($results_final as $result_item)
		{
			if (!empty($result_item) && $result_item['price'] >= 0)
			{
				$method = $this->_rateMethodFactory->create();
				$method->setCarrier('dcsshipping');
				$method->setCarrierTitle($this->getConfigData('title'));
				$method->setMethod('dcsshipping_delivery_' . $result_item['internal_id']);
                $method->setMethodTitle(__($result_item['delivery_type']));
				$method->setPrice($result_item['price']);
                $method->setCost($result_item['price']);
                $result->append($method);
                $foundRates = true;
			}
		}

		return $result;
	}

	public function getFinalQueryData($country_name,$region_name,$zone_number,$postcode,$weight_total,$volume_total,$profile_name)
	{
		$country_name = "Australia";
		$resource = $this->_resourceconnection;
		$readConnection = $resource->getConnection('core_read');

		$query_final = "SELECT id,internal_id,price,delivery_type FROM `digital_matrixrate`
		WHERE `country_name`='".$country_name."'
		AND `region_name`='".$region_name."'
		AND `zone`='".$zone_number."'
		AND `zip_from` <= '".$postcode."' AND `zip_to` >= '".$postcode."'
		AND `weight_from` <= ".$weight_total." AND `weight_to` >= ".$weight_total."
		AND `volume_from` <= ".$volume_total." AND `volume_to` >= ".$volume_total."
		AND `profile_name`='".$profile_name."'
		";
		//echo $query_final; exit();
		$results_final = $readConnection->fetchAll($query_final);
		if(count($results_final)>0)
		{
			return $this->showDeliveryOptions($results_final);
		}
		else
		{
			return $this->showPoaMethods();
		}
	}

	public function getCheckFirstPriority($zone_number)
	{
		$first_array = array();
		$resource = $this->_resourceconnection;
		$readConnection = $resource->getConnection('core_read');
		$query_get_first_region = "SELECT * FROM `digital_zone` WHERE `zone` = '".$zone_number."' LIMIT 1";
		$results_get_first_region = $readConnection->fetchAll($query_get_first_region);
		if(count($results_get_first_region)>0)
		{
			if($results_get_first_region[0]['nsw']!='')
			{
				$first_array['NSW'] = $results_get_first_region[0]['nsw'];
			}
			if($results_get_first_region[0]['qld']!='')
			{
				$first_array['QLD'] = $results_get_first_region[0]['qld'];
			}
			if($results_get_first_region[0]['vic']!='')
			{
				$first_array['VIC'] = $results_get_first_region[0]['vic'];
			}
			if($results_get_first_region[0]['wa']!='')
			{
				$first_array['WA'] = $results_get_first_region[0]['wa'];
			}
			asort($first_array);
			$regions_priority_array = array();
			foreach($first_array as $key => $value)
			{
    			$regions_priority_array[] = $key;

			}

			return $regions_priority_array;
		}
	}

    public function collectRates(RateRequest $request)
    {
		if (!$this->getConfigFlag('active'))
		{
			return false;
		}

		//$quote = $this->_cart->getQuote();

		$country_name = $request->getDestCountryId(); //$quote->getShippingAddress()->getCountryId();

		$postcode = $request->getDestPostcode(); //$quote->getShippingAddress()->getPostcode();

		if($country_name=='' || $postcode=='')
		{
			return false;
		}

		$zone_number = $this->getZoneFromPostCode($country_name,$postcode);

		if($zone_number)
		{
			$zone_row_array = $this->getCheckFirstPriority($zone_number);
			$priority = 1;
			foreach($zone_row_array as $zone_item)
			{
				$region_name = $zone_item;  ///Perth	= WA, Brisbane = QLD, Melbourne	= VIC, Sydney = NSW

				if($region_name)
				{
					$all_prod_status = array();
					$all_prod_status = $this->getCheckProductAvailableInStore($region_name,$request);

					if(in_array("0", $all_prod_status))
					{
						if(count(array_unique($all_prod_status)) === 1) /// All Cart QTY Not Match with Region Store...go previous and check next priority on zone table....
						{
							continue;
						}
						/*else  //// If all products not match with Store Qty then show POA methods...
						{
							return $this->showPoaMethods();
						}*/
					}
					else if(in_array("1", $all_prod_status))
					{
						if(count(array_unique($all_prod_status)) === 1)  /// All Cart QTY Match with Region Store...go ahead for check weight,volume, profile etc....
						{
							$weight_total = $request->getPackageWeight();
							$volume_total = $this->getTotalVolume($request);
							$all_profile_array = $this->getAllProductProfile($request);
							if(is_array($all_profile_array)) /// If all products has profile then....
							{
								$profile_name = '';
								if(in_array("Hoarding", $all_profile_array))
								{
									$profile_name = 'Hoarding';
								}
								else if(in_array("Bulky", $all_profile_array))
								{
									$profile_name = 'Bulky';
								}
								else if(in_array("Standard", $all_profile_array))
								{
									$profile_name = 'Standard';
								}

								return $this->getFinalQueryData($country_name,$region_name,$zone_number,$postcode,$weight_total,$volume_total,$profile_name);

							}
							else /// If any products has not selected profile then show POA
							{
								return $this->showPoaMethods();
							}

						}
						else  //// If all products not match with Store Qty then show POA methods...
						{
							return $this->showPoaMethods();
						}
					}
				}
				$priority++;
			}
		}

		return $this->showPoaMethods();
    }

    /**
     * get allowed methods
     * @return array
     */
    public function getAllowedMethods()
    {
        return ['dcsshipping' => $this->getConfigData('name')];
    }
}
