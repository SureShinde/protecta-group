<?php
 
namespace Digital\Homebanner\Setup;
 
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Eav\Model\Config as EavConfig;
use Magento\Framework\Indexer\IndexerRegistry;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

 
class UpgradeData implements UpgradeDataInterface {
	
	
	//const DISABLE_ACCOUNT_PAYMENT = 'disable_accountpayment';

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;


    /**
     * @var CustomerSetupFactory
     */
    protected $customerSetupFactory;
	
	/**
     * @var EavConfig
     */
    private $eavConfig;
	
	/**
     * @var IndexerRegistry
     */
    private $indexerRegistry;

    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    /**
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory,
		EavConfig $eavConfig,
		IndexerRegistry $indexerRegistry
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
		$this->eavConfig = $eavConfig;
		$this->indexerRegistry = $indexerRegistry;
    }
	
    public function upgrade( ModuleDataSetupInterface $setup, ModuleContextInterface $context ) {
        $installer = $setup;
 
        if ( version_compare( $context->getVersion(), '1.0.2', '<' ) ) {
		
			$customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
			$customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
			$attributeSetId = $customerEntity->getDefaultAttributeSetId();
			$attributeSet = $this->attributeSetFactory->create();
			$attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
			
			$attributesInfo = [			
				'ns_terms' => [
					'type'         => 'varchar',
					'label'        => 'NS Terms',
					'input'        => 'text',
					'class' 	   => '',
					'required'     => false,
					'visible'      => true,
					'user_defined' => true,					
					'filterable'   => false,
					'comparable'   => false,
					'unique' 	   => false,
					'system'       => 0,
					'position'     => 200,                
				],
				
				'ns_sales_rep_name' => [
					'type'         => 'varchar',
					'label'        => 'Sales Rep Name',
					'input'        => 'text',
					'class' 	   => '',
					'required'     => false,
					'visible'      => true,
					'user_defined' => true,					
					'filterable'   => false,
					'comparable'   => false,
					'unique' 	   => false,
					'system'       => 0,
					'position'     => 210,                
				],
				
				'ns_type' => [			
					'group' 		=> 'Type',
					'type' 			=> 'varchar',
					'backend' 		=> '',
					'frontend' 		=> '',
					'label' 		=> 'Customer Type',
					'input' 		=> 'select',
					'note' 			=> '',
					'class' 		=> '',
					'source' 		=> 'Digital\Homebanner\Model\Config\Source\TypeOptions',						
					'visible' 		=> true,
					'required' 		=> false,
					'user_defined' 	=> true,
					'default' 		=> '0',
					'searchable' 	=> false,
					'filterable' 	=> false,
					'comparable' 	=> false,
					'visible_on_front' => true,
					'used_in_product_listing' => false,
					'unique' 		=> false,
					'position'		=> 220,
					'system'    	=> 0,
					'option' 		=> [
						'values' => [],
					]
				],
				
				'ns_magento_id' => [					
					'type'         => 'varchar',
					'label'        => 'Magento ID',
					'input'        => 'text',
					'class' 	   => '',
					'required'     => false,
					'visible'      => true,
					'user_defined' => true,					
					'filterable'   => false,
					'comparable'   => false,
					'unique' 	   => false,
					'system'       => 0,
					'position'     => 230,
				],
				
				'ns_company_name' => [
					'type'         => 'varchar',
					'label'        => 'Company Name',
					'input'        => 'text',
					'class' 	   => '',
					'required'     => false,
					'visible'      => true,
					'user_defined' => true,					
					'filterable'   => false,
					'comparable'   => false,
					'unique' 	   => false,
					'system'       => 0,
					'position'     => 240,
				],
					
				'ns_customer_rating' => [				
					'type'         => 'varchar',
					'label'        => 'NS Customer Rating',
					'input'        => 'text',
					'class' 	   => '',
					'required'     => false,
					'visible'      => true,
					'user_defined' => true,					
					'filterable'   => false,
					'comparable'   => false,
					'unique' 	   => false,
					'system'       => 0,
					'position'     => 250,
				],
				
				'ns_territory' => [					
					'type'         => 'varchar',
					'label'        => 'NS Territory',
					'input'        => 'text',
					'class' 	   => '',
					'required'     => false,
					'visible'      => true,
					'user_defined' => true,					
					'filterable'   => false,
					'comparable'   => false,
					'unique' 	   => false,
					'system'       => 0,
					'position'     => 260,
				],
				
				'ns_sales_zone' => [
					'type'         => 'varchar',
					'label'        => 'NS Sales Zone',
					'input'        => 'text',
					'class' 	   => '',
					'required'     => false,
					'visible'      => true,
					'user_defined' => true,					
					'filterable'   => false,
					'comparable'   => false,
					'unique' 	   => false,
					'system'       => 0,
					'position'     => 270,
				],
							
				'ns_hold' => [		
					'group' 		=> 'Hold',
					'type' 			=> 'varchar',
					'backend' 		=> '',
					'frontend' 		=> '',
					'label' 		=> 'Hold',
					'input' 		=> 'select',
					'note' 			=> '',
					'class' 		=> '',
					'source' 		=> 'Digital\Homebanner\Model\Config\Source\HoldOptions',
					'global' 		=> \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
					'visible' 		=> true,
					'required' 		=> false,
					'user_defined'  => true,
					'default' 		=> '0',
					'searchable' 	=> false,
					'filterable' 	=> false,
					'comparable' 	=> false,
					'visible_on_front' => true,
					'used_in_product_listing' => false,
					'unique' 		=> false,
					'position'		=> 350,
					'system'    	=> 0,
					'option' 		=> [
										'values' => [],
									]
				],
					
				'ns_sms' => [					
					'type' 		=> 'int',
					'label' 	=> __('Stop Sending SMS'),
					'input' 	=> 'select',
					'source' 	=> 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
					'required' 	=> false,
					'default' 	=> 0,
					'visible' 	=> true,
					'admin_only' => true,
					'position'	=> 360,
					'system'    => 0,
				],			
				
				'ns_sub_job_title' => [					
					'type'         => 'varchar',
					'label'        => 'Sub Job Title',
					'input'        => 'text',
					'class' 	   => '',
					'required'     => false,
					'visible'      => true,
					'user_defined' => true,					
					'filterable'   => false,
					'comparable'   => false,
					'unique' 	   => false,
					'system'       => 0,
					'position'     => 390,
				],
				
				'ns_credit_limit' => [				
					'type'         => 'varchar',
					'label'        => 'Credit Limit',
					'input'        => 'text',
					'class' 	   => '',
					'required'     => false,
					'visible'      => true,
					'user_defined' => true,					
					'filterable'   => false,
					'comparable'   => false,
					'unique' 	   => false,
					'system'       => 0,
					'position'     => 410,
				],
				
				'ns_subsidiary' => [
					'type'         => 'varchar',
					'label'        => 'Subsidiary',
					'input'        => 'text',
					'class' 	   => '',
					'required'     => false,
					'visible'      => true,
					'user_defined' => true,					
					'filterable'   => false,
					'comparable'   => false,
					'unique' 	   => false,
					'system'       => 0,
					'position'     => 460,                
				],			
				'ns_account_no' => [
					'type'         => 'varchar',
					'label'        => 'NS Account No',
					'input'        => 'text',
					'class' 	   => '',
					'required'     => false,
					'visible'      => true,
					'user_defined' => true,					
					'filterable'   => false,
					'comparable'   => false,
					'unique' 	   => false,
					'system'       => 0,
					'position'     => 460,                
				],
				
				'ns_customer_id' => [
					'type'         => 'varchar',
					'label'        => 'NS Customer ID',
					'input'        => 'text',
					'class' 	   => '',
					'required'     => false,
					'visible'      => true,
					'user_defined' => true,					
					'filterable'   => false,
					'comparable'   => false,
					'unique' 	   => false,
					'system'       => 0,
					'position'     => 470,                
				],				
				'ns_price_level' => [
					'type'         => 'varchar',
					'label'        => 'NS Price Level',
					'input'        => 'text',
					'class' 	   => '',
					'required'     => false,
					'visible'      => true,
					'user_defined' => true,					
					'filterable'   => false,
					'comparable'   => false,
					'unique' 	   => false,
					'system'       => 0,
					'position'     => 470,                
				],
				'ns_status' => [
					'type'         => 'varchar',
					'label'        => 'NS Status',
					'input'        => 'text',
					'class' 	   => '',
					'required'     => false,
					'visible'      => true,
					'user_defined' => true,					
					'filterable'   => false,
					'comparable'   => false,
					'unique' 	   => false,
					'system'       => 0,
					'position'     => 470,                
				],
				'ns_cust_industry_category' => [
					'type'         => 'varchar',
					'label'        => 'NS Cust Industry Category',
					'input'        => 'text',
					'class' 	   => '',
					'required'     => false,
					'visible'      => true,
					'user_defined' => true,					
					'filterable'   => false,
					'comparable'   => false,
					'unique' 	   => false,
					'system'       => 0,
					'position'     => 470,                
				],
				'ns_cust_industry_sub_category' => [
					'type'         => 'varchar',
					'label'        => 'NS Cust Industry Sub-category',
					'input'        => 'text',
					'class' 	   => '',
					'required'     => false,
					'visible'      => true,
					'user_defined' => true,					
					'filterable'   => false,
					'comparable'   => false,
					'unique' 	   => false,
					'system'       => 0,
					'position'     => 470,                
				],
				'ns_territory_rep' => [
					'type'         => 'varchar',
					'label'        => 'NS Territory Rep',
					'input'        => 'text',
					'class' 	   => '',
					'required'     => false,
					'visible'      => true,
					'user_defined' => true,					
					'filterable'   => false,
					'comparable'   => false,
					'unique' 	   => false,
					'system'       => 0,
					'position'     => 470,                
				],
				'ns_account_email' => [
					'type'         => 'varchar',
					'label'        => 'NS Account Email',
					'input'        => 'text',
					'class' 	   => '',
					'required'     => false,
					'visible'      => true,
					'user_defined' => true,					
					'filterable'   => false,
					'comparable'   => false,
					'unique' 	   => false,
					'system'       => 0,
					'position'     => 470,                
				],
			];			
			// Sub Account Field
			
			foreach ($attributesInfo as $attributeCode => $attributeParams) {
				$customerSetup->addAttribute(Customer::ENTITY, $attributeCode, $attributeParams);
				$attribute = $customerSetup->getEavConfig()
					->getAttribute(Customer::ENTITY, $attributeCode)
					->addData(
						[
							'attribute_set_id' => $attributeSetId,
							'attribute_group_id' => $attributeGroupId,
							'used_in_forms'=> ['adminhtml_customer','customer_account_create','customer_account_edit']
						]
					);
				$attribute->save();
			}
			
			$indexer = $this->indexerRegistry->get(Customer::CUSTOMER_GRID_INDEXER_ID);
			$indexer->reindexAll();
			$this->eavConfig->clear();
		}


		if ( version_compare( $context->getVersion(), '1.0.3', '<' ) ) {
		
			$customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
			$customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
			$attributeSetId = $customerEntity->getDefaultAttributeSetId();
			$attributeSet = $this->attributeSetFactory->create();
			$attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
			
			$attributesInfo = [			
				'pg_phonenumber' => [
					'type'         => 'varchar',
					'label'        => 'Accounts Phone',
					'input'        => 'text',
					'class' 	   => '',
					'required'     => false,
					'visible'      => true,
					'user_defined' => true,					
					'filterable'   => false,
					'comparable'   => false,
					'unique' 	   => false,
					'system'       => 0,
					'position'     => 200,                
				]				
			];			
			
			
			foreach ($attributesInfo as $attributeCode => $attributeParams) {
				$customerSetup->addAttribute(Customer::ENTITY, $attributeCode, $attributeParams);
				$attribute = $customerSetup->getEavConfig()
					->getAttribute(Customer::ENTITY, $attributeCode)
					->addData(
						[
							'attribute_set_id' => $attributeSetId,
							'attribute_group_id' => $attributeGroupId,
							'used_in_forms'=> ['adminhtml_customer','customer_account_create','customer_account_edit']
						]
					);
				$attribute->save();
			}
			
			$indexer = $this->indexerRegistry->get(Customer::CUSTOMER_GRID_INDEXER_ID);
			$indexer->reindexAll();
			$this->eavConfig->clear();
		}	
		
		$setup->endSetup();
    }
}