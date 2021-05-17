<?php

namespace Digital\CustomShipping\Model\Carrier;

use Digital\CustomAPI\Helper\CustomLogger;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;

/**
 * Custom shipping model
 */
class Customshipping extends AbstractCarrier implements CarrierInterface
{
    /**
     * @var string
     */
    protected $_code = 'customshipping';

    /**
     * @var bool
     */
    protected $_isFixed = true;

    /**
     * @var \Magento\Shipping\Model\Rate\ResultFactory
     */
    private $rateResultFactory;

    /**
     * @var \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory
     */
    private $rateMethodFactory;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory
     * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
        \Magento\Framework\App\ResourceConnection $_resourceconnection,
        array $data = []
    ) {
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);

        $this->rateResultFactory = $rateResultFactory;
        $this->rateMethodFactory = $rateMethodFactory;
        $this->_resourceconnection = $_resourceconnection;
    }

    public function getZoneFromPostCode($country_name, $postcode)
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

    /**
     * Custom Shipping Rates Collector
     *
     * @param RateRequest $request
     * @return \Magento\Shipping\Model\Rate\Result|bool
     */
    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active'))
        {
            return false;
        }

		$quote = $this->_cart->getQuote();

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

        if (!$this->getConfigFlag('active')) {
            return false;
        }

        /** @var \Magento\Shipping\Model\Rate\Result $result */
        $result = $this->rateResultFactory->create();

        /** @var \Magento\Quote\Model\Quote\Address\RateResult\Method $method */
        $method = $this->rateMethodFactory->create();

        $method->setCarrier($this->_code);
        $method->setCarrierTitle($this->getConfigData('title'));

        $method->setMethod($this->_code);
        $method->setMethodTitle($this->getConfigData('name'));

        $shippingCost = (float)$this->getConfigData('shipping_cost');

        $method->setPrice($shippingCost);
        $method->setCost($shippingCost);

        $result->append($method);

        return $result;
    }

    /**
     * @return array
     */
    public function getAllowedMethods()
    {
        return [$this->_code => $this->getConfigData('name')];
    }
}
