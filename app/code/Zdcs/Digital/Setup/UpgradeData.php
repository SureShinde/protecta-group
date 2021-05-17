<?php
namespace Zdcs\Digital\Setup;
use Magento\Directory\Model\Region;
use Magento\Directory\Model\RegionFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;


class UpgradeData implements UpgradeDataInterface
{
    private $_regionFactory;

    public function __construct(RegionFactory $regionFactory)
    {
        $this->_regionFactory = $regionFactory;
    } 

    private function createRegionFactory()
    {
        return $this->_regionFactory->create();
    }


    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup(); 
        if (version_compare($context->getVersion(), '1.0.0', '<')) {
            $new_regions = array(
                'ACT'   =>  "Australian Capital Territory",
                'NSW'   =>  "New South Wales",
                'NT'    =>  "Northern Territory",
                'QLD'   =>  "Queensland",
                'SA'    =>  "South Australia",
                'TAS'   =>  "Tasmania",
                'VIC'   =>  "Victoria",
                'WA'    =>  "Western Australia",
            );
            $country_code = 'AU'; 
            
            $i = 1;
             
            foreach ($new_regions as $region_code => $region_name) { 
                 
                $model = $this->createRegionFactory();
                $model->setCountryId($country_code);
                $model->setCode($region_code);
                $model->setDefaultName($region_name);
                $model->save();
                $i++;
            }
             
        }
        $setup->endSetup();
    }

}