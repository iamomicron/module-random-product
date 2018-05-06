<?php
/**
 * Copyright © Rob Aimes - https://aimes.eu
 */

namespace Aimes\RandomProduct\Block;

use Magento\Framework\View\Element\Template;

/**
 * Class RandomProduct
 * @package Aimes\RandomProduct\Block
 */
class Url extends Template
{
    /**
     * Return random product controller path
     *
     * @return string
     */
    public function getControllerPath()
    {
        return $this->getUrl('randomproduct/index/index');
    }
}
