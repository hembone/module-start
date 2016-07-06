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

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * InstallSchema
 *
 * @category Alpine
 * @package Alpine_Brand
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if ($installer->getConnection()->isTableExists('brand')) {
            $installer->getConnection()->dropTable('brand');
        }

        $table = $installer->getConnection()
            ->newTable($installer->getTable('brand'))
            ->addColumn('brand_id', Table::TYPE_SMALLINT, null, ['identity' => true, 'nullable' => false, 'primary' => true], 'Brand ID')
            ->addColumn('url_key', Table::TYPE_TEXT, 100, ['nullable' => true, 'default' => null], 'URL Key')
            ->addColumn('name', Table::TYPE_TEXT, 255, ['nullable' => false], 'Brand Name')
            ->addColumn('image', Table::TYPE_TEXT, 255, [], 'Brand Image')
            ->addColumn('is_active', Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => '1'], 'Is Active?')
            ->addColumn('creation_time', Table::TYPE_DATETIME, null, ['nullable' => false], 'Creation Time')
            ->addColumn('update_time', Table::TYPE_DATETIME, null, ['nullable' => false], 'Update Time')
            ->addIndex($installer->getIdxName('brand_idx', ['url_key']), ['url_key'])
            ->setComment('Alpine Brand Table');

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
