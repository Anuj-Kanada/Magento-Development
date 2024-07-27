<?php
namespace Rh\Bv\ViewModel;
use Magento\Framework\Registry;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class ProductViewModel implements ArgumentInterface
{
    private $resource;
    public function __construct(Registry $resource)
    {
        $this->resource = $resource;
    }
    public function getProductBySku()
    {
        $product = $this->resource->registry('current_product');
         return $product->getData('sku');
    }
}