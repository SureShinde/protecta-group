<?php

namespace Digital\CustomAPI\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Sales\Setup\SalesSetupFactory;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * Sales setup factory
     *
     * @var SalesSetupFactory
     */
    private $salesSetupFactory;

    /**
     * @param SalesSetupFactory $salesSetupFactory
     */
    public function __construct(
        SalesSetupFactory $salesSetupFactory
    ) {
        $this->salesSetupFactory = $salesSetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var \Magento\Sales\Setup\SalesSetup $salesSetup */
        $salesSetup = $this->salesSetupFactory->create(['setup' => $setup]);

        if ($context->getVersion()&& version_compare($context->getVersion(), '1.0.0') < 0){
            $attributes = [
				'ns_order_id' => [
					'type'         => 'varchar',
					'label'        => 'NetSuite Order InternalID',
					'input'        => 'text',
					'class' 	   => '',
					'required'     => false,
					'visible'      => true,
					'user_defined' => true,
					'filterable'   => false,
					'comparable'   => false,
					'unique' 	   => false,
					'system'       => 0,
				]
			];

            foreach ($attributes as $attributeCode => $attributeParams) {
                $salesSetup->addAttribute('order', $attributeCode, $attributeParams);
            }
        }

        if ($context->getVersion()&& version_compare($context->getVersion(), '1.0.1') < 0){
            $attributes = [
				'ns_order_id' => [
					'type'         => 'varchar',
					'label'        => 'NetSuite Order InternalID',
					'input'        => 'text',
					'class' 	   => '',
					'required'     => false,
					'visible'      => true,
					'user_defined' => true,
					'filterable'   => false,
					'comparable'   => false,
					'unique' 	   => false,
					'system'       => 0,
				]
			];

            foreach ($attributes as $attributeCode => $attributeParams) {
                $salesSetup->addAttribute('order', $attributeCode, $attributeParams);
            }
        }

        if ($context->getVersion()&& version_compare($context->getVersion(), '1.0.2') < 0){
            $attributes = [
				'ns_order_id' => [
					'type'         => 'varchar',
					'label'        => 'NetSuite Order InternalID',
					'input'        => 'text',
					'class' 	   => '',
					'required'     => false,
					'visible'      => true,
					'user_defined' => true,
					'filterable'   => false,
					'comparable'   => false,
					'unique' 	   => false,
					'system'       => 0,
				]
			];

            foreach ($attributes as $attributeCode => $attributeParams) {
                $salesSetup->addAttribute('order', $attributeCode, $attributeParams);
            }
        }

		if ($context->getVersion()&& version_compare($context->getVersion(), '1.0.3') < 0){
            $attributes = [
				'ns_order_id' => [
					'type'         => 'varchar',
					'label'        => 'NetSuite Order InternalID',
					'input'        => 'text',
					'class' 	   => '',
					'required'     => false,
					'visible'      => true,
					'user_defined' => true,
					'filterable'   => false,
					'comparable'   => false,
					'unique' 	   => false,
					'system'       => 0,
				]
			];

            foreach ($attributes as $attributeCode => $attributeParams) {
                $salesSetup->addAttribute('order', $attributeCode, $attributeParams);
            }
        }

		if ($context->getVersion()&& version_compare($context->getVersion(), '1.0.4') < 0){
            $attributes = [
				'ns_order_id' => [
					'type'         => 'varchar',
					'label'        => 'NetSuite Order InternalID',
					'input'        => 'text',
					'class' 	   => '',
					'required'     => false,
					'visible'      => true,
					'user_defined' => true,
					'filterable'   => false,
					'comparable'   => false,
					'unique' 	   => false,
					'system'       => 0,
				]
			];

            foreach ($attributes as $attributeCode => $attributeParams) {
                $salesSetup->addAttribute('order', $attributeCode, $attributeParams);
            }
        }
    }
}
