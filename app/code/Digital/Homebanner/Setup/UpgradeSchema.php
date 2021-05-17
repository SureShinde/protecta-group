<?php 



namespace Digital\Homebanner\Setup;

use Magento\Framework\Setup\ModuleContextInterface;

use Magento\Framework\Setup\SchemaSetupInterface;

use Magento\Framework\Setup\UpgradeSchemaInterface;

use Digital\Homebanner\Setup\InstallSchema as StorelocatorShema;

 

class UpgradeSchema implements UpgradeSchemaInterface

{     

    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)

    {

       $installer = $setup;

        $installer->startSetup();



        if (version_compare($context->getVersion(), '1.0.1', '<')) {

            $this->addColumnForCustomerGroup($setup);

        }



        $installer->endSetup();

    }

    public function addColumnForCustomerGroup(SchemaSetupInterface $setup)

    { 

        $setup->getConnection()->addColumn(

            $setup->getTable('digital_homebanner'),

            'banner_url',

            [

                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,

                'nullable' => false,

                'comment' => 'Banner Url',

                'default' => ''                

            ]

        ); 



        $setup->getConnection()->addColumn(

            $setup->getTable('digital_homebanner'),

            'banner_slogan',

            [

                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,

                'nullable' => false,

                'comment' => 'Banner Slogan',

                'default' => ''                

            ]

        ); 

    }

}