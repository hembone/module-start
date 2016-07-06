<?php
/**
 * Alpine Brand Extension
 *
 * @category Alpine
 * @package Alpine_Brand
 * @copyright Copyright (c) 2016 Alpine Consulting, Inc (www.alpineinc.com)
 * @author Alpine Consulting (magento@alpineinc.com)
 */

namespace Alpine\Brand\Model\Brand\Source;

/**
 * IsActive
 *
 * @category Alpine
 * @package Alpine_Brand
 */
class IsActive implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var \Alpine\Brand\Model\Brand
     */
    protected $brand;

    /**
     * Construct
     *
     * @param \Alpine\Brand\Model\Brand $brand
     */
    public function __construct(\Alpine\Brand\Model\Brand $brand)
    {
        $this->brand = $brand;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->brand->getAvailableStatuses();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
