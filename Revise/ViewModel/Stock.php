<?php
namespace Brainvire\Revise\ViewModel;

use Magento\Catalog\Model\Product;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\InventoryCatalogApi\Api\DefaultStockProviderInterface;

class Stock implements ArgumentInterface
{
    protected $defaultStockProvider;

    public function __construct(DefaultStockProviderInterface $defaultStockProvider)
    {
        $this->defaultStockProvider = $defaultStockProvider;
    }

    public function getStock(?Product $product)
    {
        if (!$product instanceof Product) {
            return __('Product not found');
        }

        $sku = $product->getSku();
        $stockItem = $this->defaultStockProvider->getStockItemBySku($sku);
        return $stockItem->getQty();
    }
}
