<?php
/**
 * [Namespace] [Module] Extension
 *
 * @category [Namespace]
 * @package [Namespace]_[Module]
 * @copyright [phpdocs_copyright]
 * @author [phpdocs_author]
 */

namespace [Namespace]\[Module]\Model\Item\Source;

use [Namespace]\[Module]\Model\Item

/**
 * IsActive
 *
 * @category [Namespace]
 * @package [Namespace]_[Module]
 */
class IsActive implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var \Namespace]\[Module]\Model\Item
     */
    protected $item;

    /**
     * Construct
     *
     * @param \[Namespace]\[Module]\Model\Item $item
     */
    public function __construct(
        Item $item
    ) {
        $this->item = $item;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->item->getAvailableStatuses();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
