<?php
namespace Rh\Bv\ViewModel;
use Magento\Framework\Registry;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class CatLogic implements ArgumentInterface
{
    private $resource;
    public function __construct(Registry $resource)
    {
        $this->resource = $resource;
    }
    public function getCategoryByName()
    {
        $category = $this->resource->registry('current_category');
         return $category->getData('name');
    }
}