<?php
/**
 * Alpine Brand Extension
 *
 * @category Alpine
 * @package Alpine_Brand
 * @copyright Copyright (c) 2016 Alpine Consulting, Inc (www.alpineinc.com)
 * @author Alpine Consulting (magento@alpineinc.com)
 */

namespace Alpine\Brand\Model\Config\Source;

use Alpine\Brand\Model\BrandFactory;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

/**
 * Options
 *
 * @category Alpine
 * @package Alpine_Brand
 */
class Options extends AbstractSource
{
    /**
     * @var BrandFactory
     */
    private $brandFactory;

    /**
     * Construct
     * 
     * @param BrandFactory $brandFactory
     */
    public function __construct(
        BrandFactory $brandFactory
    ) {
        $this->brandFactory = $brandFactory;
    }

    /**
     * Get options
     * 
     * @return array
     */
    public function getAllOptions()
    {
        $brandModel = $this->brandFactory->create();
        $brandCollection = $brandModel->getCollection();
        $brands = $brandCollection->getData();

        $options = [['label' => 'Select Brand', 'value' => '']];

        foreach ($brands as $brand) {
            $options[] = ['label' => $brand['name'], 'value' => $brand['brand_id']];
        }
        return $options;
    }
}