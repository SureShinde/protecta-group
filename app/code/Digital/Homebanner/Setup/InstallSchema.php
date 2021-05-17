<?php 
namespace Digital\Homebanner\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();
        $table  = $installer->getConnection()
            ->newTable($installer->getTable('digital_homebanner'))
            ->addColumn(
                'banner_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Banner Id'
            )
            ->addColumn(
                'name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['default' => null],
                'Banner Name'
            )->addColumn(
                'banner_use',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                20,
                ['default' => null],
                'Banner Use'
            )->addColumn(
                'image',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['default' => null],
                'Banner Image'
            )->addColumn(
				'sort_order',
				\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
				10,
				['default' => null],
				'Sort Order'
			)->addColumn(
				'status',
				\Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
				10,
				['nullable' => false, 'default' => '1'],
				'Status'
			);
        $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }
}
