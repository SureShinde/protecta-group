<?php
/**
 * *
 *  Copyright © 2016 WEBO. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */
namespace WEBO\NetSuite\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

/**
 * @codeCoverageIgnore
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        if (version_compare($context->getVersion(), '1.0.0') < 0) {

			// SALES ORDER TABLE
            $tableName = $setup->getTable('sales_order');
            if ($setup->getConnection()->isTableExists($tableName) == true) {
                $setup->getConnection()->addColumn(
                    $tableName,
                    'ship_po_number',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Ship PO Number',
                        '255',
                    ]
                );

				$setup->getConnection()->addColumn(
					$tableName,
					'ship_due_date',
					[
						'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
						'nullable' => true,
						'comment' => 'Ship Due Date',
						'255',
					]
				);

				$setup->getConnection()->addColumn(
                    $tableName,
                    'pg_delivery_phone',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Delivery Phone',
                        '255',
                    ]
                );

				$setup->getConnection()->addColumn(
                    $tableName,
                    'pg_delivery_contact',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Delivery Contact',
                        '255',
                    ]
                );

				$setup->getConnection()->addColumn(
                    $tableName,
                    'pg_delivery_zone',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Delivery Zone',
                        '50',
                    ]
                );

				$setup->getConnection()->addColumn(
					$tableName,
					'pg_delivery_location',
					[
						'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
						'nullable' => true,
						'comment' => 'Delivery Location',
						'100',
					]
				);
            }

			// QUOTE TABLE
            $tableName = $setup->getTable('quote');
            if ($setup->getConnection()->isTableExists($tableName) == true) {
                $setup->getConnection()->addColumn(
                    $tableName,
                    'ship_po_number',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Ship PO Number',
                        '255',
                    ]
                );

                $setup->getConnection()->addColumn(
                    $tableName,
                    'ship_due_date',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Ship Due Date',
                        '255',
                    ]
                );

				$setup->getConnection()->addColumn(
                    $tableName,
                    'pg_delivery_phone',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Delivery Phone',
                        '255',
                    ]
                );

				$setup->getConnection()->addColumn(
                    $tableName,
                    'pg_delivery_contact',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Delivery Contact',
                        '255',
                    ]
                );

				$setup->getConnection()->addColumn(
                    $tableName,
                    'pg_delivery_location',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Delivery Location',
                        '100',
                    ]
                );

				$setup->getConnection()->addColumn(
                    $tableName,
                    'pg_delivery_zone',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Delivery Zone',
                        '50',
                    ]
                );
            }

			// SALES ORDER ITEM TABLE
			$tableName = $setup->getTable('sales_order_item');
            if ($setup->getConnection()->isTableExists($tableName) == true) {
                $setup->getConnection()->addColumn(
                    $tableName,
                    'item_delivery_location',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Item Delivery Location',
                        '255',
                    ]
                );

				$setup->getConnection()->addColumn(
                    $tableName,
                    'pg_delivery_zone',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Delivery Zone',
                        '50',
                    ]
                );

                $setup->getConnection()->addColumn(
                    $tableName,
                    'pg_delivery_location',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Delivery Location',
                        '100',
                    ]
                );
            }

			// QUOTE ITEM TABLE
            $tableName = $setup->getTable('quote_item');
            if ($setup->getConnection()->isTableExists($tableName) == true) {
                $setup->getConnection()->addColumn(
                    $tableName,
                    'item_delivery_location',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Item Delivery Location',
                        '255',
                    ]
                );

				$setup->getConnection()->addColumn(
                    $tableName,
                    'pg_delivery_zone',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Delivery Zone',
                        '50',
                    ]
                );
                $setup->getConnection()->addColumn(
                    $tableName,
                    'pg_delivery_location',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Delivery Location',
                        '100',
                    ]
                );
            }
        }

        $setup->endSetup();
        $installer->endSetup();
    }
}
