<?php
namespace Aimes\RandomProduct\Controller\Index;

use Aimes\RandomProduct\Block\RandomProduct;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Index extends Action
{
    /**
     * @var RandomProduct
     */
    protected $randomProduct;

    /**
     * Index constructor.
     * @param Context $context
     * @param RandomProduct $randomProduct
     */
    public function __construct(
        Context $context,
        RandomProduct $randomProduct
    ) {
        $this->randomProduct = $randomProduct;
        return parent::__construct($context);
    }

    /**
     * Redirect to randomly selected product url
     *
     * @return string
     */
    public function execute()
    {
        return $this->resultRedirectFactory->create()->setUrl($this->randomProduct->getProductUrl());
    }
}