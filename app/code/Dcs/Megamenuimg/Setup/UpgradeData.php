<?php
namespace Dcs\Megamenuimg\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Catalog\Setup\CategorySetupFactory;

class UpgradeData implements UpgradeDataInterface
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
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
		$installer = $setup;
		if ( version_compare( $context->getVersion(), '2.0.3', '<' ) )
		{
			$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

			//$categorySetup = $this->categorySetupFactory->create(['setup' => $setup]);
			$entityTypeId = $eavSetup->getEntityTypeId(\Magento\Catalog\Model\Category::ENTITY);
			$attributeSetId = $eavSetup->getDefaultAttributeSetId($entityTypeId);

			// Menu Thumbnail
			$eavSetup->addAttribute(
				\Magento\Catalog\Model\Category::ENTITY, 'mobile_cat_banner', [
					'type' => 'varchar',
					'label' => 'Category Banner Image (Mobile)',
					'input' => 'image',
					'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
					'required' => false,
					'sort_order' => 5,
					'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
					'note' => 'Category Banner Image (Mobile)',
					'group' => 'General Information',
				]
			);

			// Menu First Image
			$eavSetup->addAttribute(
				\Magento\Catalog\Model\Category::ENTITY, 'tablet_cat_banner', [
					'type' => 'varchar',
					'label' => 'Category Banner Image (Tablet)',
					'input' => 'image',
					'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
					'required' => false,
					'sort_order' => 6,
					'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
					'note' => 'Category Banner Image (Tablet)',
					'group' => 'General Information',
				]
			);

			$idg =  $eavSetup->getAttributeGroupId($entityTypeId, $attributeSetId, 'General Information');

			// Menu Thumbnail
			 $eavSetup->addAttributeToGroup(
				$entityTypeId,
				$attributeSetId,
				$idg,
				'mobile_cat_banner',
				47
			);

			// Menu First Image
			$eavSetup->addAttributeToGroup(
				$entityTypeId,
				$attributeSetId,
				$idg,
				'tablet_cat_banner',
				48
			);
		}

        $installer->endSetup();
    }
}
