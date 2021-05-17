<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2018 Amasty (https://www.amasty.com)
 * @package Amasty_Shopby
 */
namespace Digital\Warehouse\Setup;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
class UpgradeSchema implements UpgradeSchemaInterface
{

    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {

        $setup->startSetup();
        
		if (version_compare($context->getVersion(), '2.0.0', '<')) {

			/** Quote Level Attribute Start Here*/

		    $tableName = $setup->getTable('quote');
			if ($setup->getConnection()->isTableExists($tableName) == true) {
				$setup->getConnection()->addColumn($tableName,
													'location',
													['type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
														'length' => 255,
														'comment' => 'location',
													]
												  );
			}
			/** Quote Level Attribute End Here */

			/** Quote Item Level Attribute Start Here*/

			$tableName = $setup->getTable('quote_item');
			if ($setup->getConnection()->isTableExists($tableName) == true) {
				$setup->getConnection()->addColumn(
													$tableName,
													'location',
													[
														'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
														'length' => 255,
														'comment' => 'location',
													]
												  );
			} 

			/** Quote Item Level Attribute End Here */

			/** Sales Order Level Attribute Start Here */

			$tableName = $setup->getTable('sales_order');
			if ($setup->getConnection()->isTableExists($tableName) == true) {
				$setup->getConnection()->addColumn(
													$tableName,
													'location',
													[
														'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
														'length' => 255,
														'comment' => 'location',
													]
												  );
			} 
			/** Sales Order Level Attribute End Here */
			/** Sales Order Item Level Attribute Start Here */
			$tableName = $setup->getTable('sales_order_item');
			if ($setup->getConnection()->isTableExists($tableName) == true) {
				$setup->getConnection()->addColumn(
													$tableName,
													'location',
													[
														'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
														'length' => 255,
														'comment' => 'location',
													]
												  );
			}

			/** Sales Order Item Level Attribute End Here */

			/** Sales Invoice Level Attribute Start Here */

		    $tableName = $setup->getTable('sales_invoice');
			if ($setup->getConnection()->isTableExists($tableName) == true) {
				$setup->getConnection()->addColumn(
													$tableName,
													'location',
													[
														'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
														'length' => 255,
														'comment' => 'location',
													]
												  );
			} 

			/** Sales Invoice Level Attribute End Here */
        }
		
		
		$setup->endSetup();
    }

}

