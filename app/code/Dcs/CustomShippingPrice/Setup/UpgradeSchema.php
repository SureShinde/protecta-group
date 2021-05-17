<?php

namespace Dcs\CustomShippingPrice\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;


class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (version_compare($context->getVersion(), '2.0.0', '<')) {

		/**
         * Create table 'advanced_matrixrate'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('digital_zone')
        )->addColumn('id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Id'
        )->addColumn(
            'internal_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'default' => '0'],
            'Internal Id'
        )->addColumn(
            'zone',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'default' => '0'],
            'Zone'
        )->addColumn(
            'nsw',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            5,
            ['nullable' => false, 'default' => ''],
            'NSW'
        )->addColumn(
            'qld',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            5,
            ['nullable' => false, 'default' => ''],
            'QLD'
        )->addColumn(
            'vic',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            5,
            ['nullable' => false, 'default' => ''],
            'VIC'
        )->addColumn(
            'wa',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            5,
            ['nullable' => false, 'default' => ''],
            'WA'
        );
        $installer->getConnection()->createTable($table);

        }
	    $installer->endSetup();
    }
}
