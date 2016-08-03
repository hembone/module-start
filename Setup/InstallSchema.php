<?php
/**
 * [Namespace] [Module] Extension
 *
 * @category [Namespace]
 * @package [Namespace]_[Module]
 * @copyright [phpdocs_copyright]
 * @author [phpdocs_author]
 */

namespace [Namespace]\[Module]\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * InstallSchema
 *
 * @category [Namespace]
 * @package [Namespace]_[Module]
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

        if ($installer->getConnection()->isTableExists('[db_name]')) {
            $installer->getConnection()->dropTable('[db_name]');
        }

        $table = $installer->getConnection()
            ->newTable($installer->getTable('[db_name]'))
            ->addColumn('[db_name]_id', Table::TYPE_SMALLINT, null, ['identity' => true, 'nullable' => false, 'primary' => true], 'ID')
            ->addColumn('url_key', Table::TYPE_TEXT, 100, ['nullable' => true, 'default' => null], 'URL Key')
            ->addColumn('name', Table::TYPE_TEXT, 255, ['nullable' => false], 'Name')
            ->addColumn('is_active', Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => '1'], 'Is Active?')
            ->addColumn('creation_time', Table::TYPE_DATETIME, null, ['nullable' => false], 'Creation Time')
            ->addColumn('update_time', Table::TYPE_DATETIME, null, ['nullable' => false], 'Update Time')
            ->addIndex($installer->getIdxName('[db_name]_idx', ['url_key']), ['url_key'])
            ->setComment('[Namespace] [Module] Table');

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
