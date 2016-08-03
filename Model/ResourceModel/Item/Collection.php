<?php
/**
 * [Namespace] [Module] Extension
 *
 * @category [Namespace]
 * @package [Namespace]_[Module]
 * @copyright [phpdocs_copyright]
 * @author [phpdocs_author]
 */

namespace [Namespace]\[Module]\Model\ResourceModel\Item;

/**
 * Collection
 *
 * @category [Namespace]
 * @package [Namespace]_[Module]
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = '[db_primary_key]';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('[Namespace]\[Module]\Model\Item', '[Namespace]\[Module]\Model\ResourceModel\Item');
    }

}
