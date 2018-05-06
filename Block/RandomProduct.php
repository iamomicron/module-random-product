<?php
/**
 * Copyright © Rob Aimes - https://aimes.eu
 */

namespace Aimes\RandomProduct\Block;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Class RandomProduct
 * @package Aimes\RandomProduct\Block
 */
class RandomProduct extends Template
{
    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var FilterGroup
     */
    protected $filterGroup;

    /**
     * @var SortOrder
     */
    protected $sortOrder;

    /**
     * @var SearchCriteriaInterface
     */
    protected $searchCriteria;

    /**
     * RandomProduct constructor.
     * @param Template\Context $context
     * @param ProductFactory $productFactory
     * @param ProductRepositoryInterface $productRepository
     * @param FilterGroup $filterGroup
     * @param SortOrder $sortOrder
     * @param SearchCriteriaInterface $searchCriteria
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ProductFactory $productFactory,
        ProductRepositoryInterface $productRepository,
        FilterGroup $filterGroup,
        SortOrder $sortOrder,
        SearchCriteriaInterface $searchCriteria,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->productFactory = $productFactory;
        $this->productRepository = $productRepository;
        $this->filterGroup = $filterGroup;
        $this->sortOrder = $sortOrder;
        $this->searchCriteria = $searchCriteria;
    }

    /**
     * Get the product with the highest ID
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface|mixed
     */
    private function getLatestProduct()
    {
        $this->sortOrder
            ->setField('entity_id')
            ->setDirection(SortOrder::SORT_DESC);

        $this->searchCriteria
            ->setFilterGroups([$this->filterGroup])
            ->setPageSize(1)
            ->setSortOrders([$this->sortOrder]);

        $product = $this->productRepository
            ->getList($this->searchCriteria)
            ->getItems();

        return reset($product);
    }

    /**
     * Get the id of the product
     *
     * @return int|null
     */
    private function getLatestProductId()
    {
        $product = $this->getLatestProduct();

        return $product->getId();
    }

    /**
     * Generate random ID between 0 and the newest product ID.
     * Load the product model from this ID.
     * If product is not visible gets a new product.
     *
     * @return $this|mixed
     */
    private function getRandomProduct()
    {
        $productId = rand(0, $this->getLatestProductId());
        $product = $this->productFactory->create()->load($productId);

        return $product->isVisibleInSiteVisibility() ? $product : $this->getRandomProduct();
    }

    /**
     * Get the URL of the product
     *
     * @return mixed
     */
    public function getProductUrl()
    {
        $product = $this->getRandomProduct();
        return $product->getProductUrl();
    }
}
