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
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\View\Element\Template;

/**
 * Detail
 *
 * @category Alpine
 * @package Alpine_Brand
 */
class Detail extends Template
{
    /**
     * @var BrandFactory
     */
    private $brandFactory;
    /**
     * @var ProductFactory
     */
    private $productFactory;
    /**
     * @var CategoryFactory
     */
    private $categoryFactory;

    /**
     * Construct
     *
     * @param Template\Context $context
     * @param array $data
     * @param BrandFactory $brandFactory
     * @param ProductFactory $productFactory
     * @param CategoryFactory $categoryFactory
     */
    public function __construct(
        Template\Context $context,
        array $data = [],
        BrandFactory $brandFactory,
        ProductFactory $productFactory,
        CategoryFactory $categoryFactory
    ) {
        parent::__construct($context, $data);
        $this->request = $context->getRequest();
        $this->brandFactory = $brandFactory;
        $this->productFactory = $productFactory;
        $this->categoryFactory = $categoryFactory;
    }

    /**
     * Get brand details
     * 
     * @return mixed
     */
    public function getBrandDetails()
    {
        $urlKey = $this->parseUrlKey();
        $brandFactory = $this->brandFactory->create();
        $brand = $brandFactory->getBrandByUrlKey($urlKey);
        $products = $brandFactory->getProductsByBrandId($brand['brand_id']);
        $categories = $this->getCategories($products);
        return array('brand'=>$brand, 'categories'=>$categories);
    }

    /**
     * Parse url key
     * 
     * @return mixed $urlKey
     */
    public function parseUrlKey()
    {
        $pathInfo = $this->request->getPathInfo();
        preg_match("%/brand/(.*?).html$%", $pathInfo, $m);
        $urlKey = $m[1];
        return $urlKey;
    }

    /**
     * Get product categories
     * 
     * @param $products
     * @return array $productCategories
     */
    public function getCategories($products)
    {
        $productFactory = $this->productFactory->create();
        $categoryFactory = $this->categoryFactory->create();
        $productCategories = [];
        foreach ($products as $product) {
            $productObj = $productFactory->load($productFactory->getIdBySku($product['sku']));
            $categoryIds = $productObj->getCategoryIds();
            foreach ($categoryIds as $id) {
                $categoryObj = $categoryFactory->load($id);
                $cat = $categoryObj->getData();
                if (isset($cat['is_anchor']) && $cat['is_anchor']) {
                    $productCategories[$cat['entity_id']] = $cat;
                }
            }
        }
        return $productCategories;
    }
}