<?php


namespace Dcs\Downloadcatalogue\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
		$installer = $setup;
		$installer->startSetup();

		/**
		 * Creating table dcs_downloadcatalogue
		 */
		$table = $installer->getConnection()->newTable(
			$installer->getTable('dcs_downloadcatalogue')
		)->addColumn(
			'downloadcatalogue_id',
			\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
			null,
			['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
			'Entity Id'
		)->addColumn(
			'name',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true],
			'Name'
		)->addColumn(
			'image',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			null,
			['nullable' => true,'default' => null],
			'Downloadcatalogue image media path'
		)->addColumn(
			'catalogue_file',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			null,
			['nullable' => true,'default' => null],
			'Catalogue File'
		)->addColumn(
			'rank',
			\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
			255,
			['nullable' => true],
			'Rank'
		)->addColumn(
			'status',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true,'default' => null],
			'Status'
		)->addColumn(
			'created_time', 
			\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, 
			null, 
			['nullable' => false, 
			 'default'=> \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT], 
			'Catalogue Creation Time'
		)->addColumn(
			'updated_time', 
			\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
			null, 
			['nullable' => false, 
			 'default'   => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE], 
			'Catalogue Update Time'
		)->addIndex(
			$installer->getIdxName(
				'dcs_downloadcatalogue',
				['downloadcatalogue_id'],
				\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX
			),
			['downloadcatalogue_id'],
			['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX]
		)->setComment(
			'Downloadcatalogue item'
		);
		$installer->getConnection()->createTable($table);
		$installer->endSetup();
	}
}