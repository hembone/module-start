<?php
/**
 * Alpine Brand Extension
 *
 * @category Alpine
 * @package Alpine_Brand
 * @copyright Copyright (c) 2016 Alpine Consulting, Inc (www.alpineinc.com)
 * @author Alpine Consulting (magento@alpineinc.com)
 */

namespace Alpine\Brand\Setup;

use Alpine\Brand\Model\BrandFactory;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * InstallData
 *
 * @category Alpine
 * @package Alpine_Brand
 */
class InstallData implements InstallDataInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;
    /**
     * @var BrandFactory
     */
    private $brandFactory;

    /**
     * Construct
     *
     * @param EavSetupFactory $eavSetupFactory
     * @param BrandFactory $brandFactory
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        BrandFactory $brandFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->brandFactory = $brandFactory;
    }

    /**
     * Installs data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY,'brand');

        $eavSetup->addAttribute(\Magento\Catalog\Model\Product::ENTITY, 'brand',
            [
                'group' => 'Product Details',
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'label' => 'Brand',
                'input' => 'select',
                'class' => '',
                'source' => 'Alpine\Brand\Model\Config\Source\Options',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => '',
                'searchable' => false,
                'filterable' => true,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => true,
                'unique' => false
            ]
        );
    }
}