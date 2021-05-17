<?php
namespace Dcs\Megamenuimg\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Setup\CategorySetupFactory;

class InstallData implements InstallDataInterface
{
    /**
     * Category setup factory
     *
     * @var CategorySetupFactory
     */
    private $categorySetupFactory;

    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        //$categorySetup = $this->categorySetupFactory->create(['setup' => $setup]);
        $entityTypeId = $eavSetup->getEntityTypeId(\Magento\Catalog\Model\Category::ENTITY);
        $attributeSetId = $eavSetup->getDefaultAttributeSetId($entityTypeId);

		// Menu Thumbnail
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY, 'menu_thumbnail', [
                'type' => 'varchar',
                'label' => 'Menu Thumbnail',
                'input' => 'image',
                'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
                'required' => false,
                'sort_order' => 5,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
				'note' => 'Menu Thumbnail',
                'group' => 'General Information',
            ]
        );

		// Menu First Image
		$eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY, 'menu_first_img', [
                'type' => 'varchar',
                'label' => 'Menu First Image',
                'input' => 'image',
                'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
                'required' => false,
                'sort_order' => 6,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
				'note' => 'Menu First Image',
                'group' => 'General Information',
            ]
        );

		// Show on Home Page
		$eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY, 'show_on_homepage', [
                'type' => 'int',
                'label' => 'Show on Home Page',
                'input' => 'boolean',
                'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                'required' => false,
                'sort_order' => 10,
                'global' => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_STORE,
				'note' => 'Show on Home Page',
                'group' => 'General Information',
            ]
        );

        $idg =  $eavSetup->getAttributeGroupId($entityTypeId, $attributeSetId, 'General Information');

		// Menu Thumbnail
		 $eavSetup->addAttributeToGroup(
            $entityTypeId,
            $attributeSetId,
            $idg,
            'menu_thumbnail',
            47
        );

		// Menu First Image
		$eavSetup->addAttributeToGroup(
            $entityTypeId,
            $attributeSetId,
            $idg,
            'menu_first_img',
            48
        );

		$eavSetup->addAttributeToGroup(
            $entityTypeId,
            $attributeSetId,
            $idg,
            'show_on_homepage',
            49
        );

        //$installer->endSetup();
    }
}
