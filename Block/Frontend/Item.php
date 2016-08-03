<?php
/**
 * [Namespace] [Module] Extension
 *
 * @category [Namespace]
 * @package [Namespace]_[Module]
 * @copyright [phpdocs_copyright]
 * @author [phpdocs_author]
 */

namespace [Namespace]\[Module]\Block\Frontend;

use [Namespace]\[Module]\Model\ItemFactory;
use Magento\Framework\View\Element\Template;

/**
 * Item
 *
 * @category [Namespace]
 * @package [Namespace]_[Module]
 */
class Item extends Template
{
    /**
     * @var ItemFactory
     */
    private $itemFactory;

    /**
     * Construct
     * 
     * @param Template\Context $context
     * @param array $data
     * @param ItemFactory $itemFactory
     */
    public function __construct(
        Template\Context $context,
        array $data = [],
        ItemFactory $itemFactory
    ) {
        parent::__construct($context, $data);
        $this->itemFactory = $itemFactory;
    }

    /**
     * Get items
     * 
     * @return array $items
     */
    public function getItems()
    {
        $itemModel = $this->itemFactory->create();
        $itemCollection = $itemModel->getCollection();
        $items = $itemCollection->getData();
        return $items;
    }
}