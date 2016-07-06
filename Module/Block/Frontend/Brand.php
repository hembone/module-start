<?php
/**
 * Alpine Brand Extension
 *
 * @category Alpine
 * @package Alpine_Brand
 * @copyright Copyright (c) 2016 Alpine Consulting, Inc (www.alpineinc.com)
 * @author Alpine Consulting (magento@alpineinc.com)
 */

namespace Alpine\Brand\Block\Frontend;

use Alpine\Brand\Model\BrandFactory;
use Magento\Framework\View\Element\Template;

/**
 * Brand
 *
 * @category Alpine
 * @package Alpine_Brand
 */
class Brand extends Template
{
    /**
     * @var BrandFactory
     */
    private $brandFactory;

    /**
     * Construct
     * 
     * @param Template\Context $context
     * @param array $data
     * @param BrandFactory $brandFactory
     */
    public function __construct(
        Template\Context $context,
        array $data = [],
        BrandFactory $brandFactory
    ) {
        parent::__construct($context, $data);
        $this->brandFactory = $brandFactory;
    }

    /**
     * Get brands
     * 
     * @return array $brands
     */
    public function getBrands()
    {
        $brandModel = $this->brandFactory->create();
        $brandCollection = $brandModel->getCollection();
        $brands = $brandCollection->getData();
        return $brands;
    }
}