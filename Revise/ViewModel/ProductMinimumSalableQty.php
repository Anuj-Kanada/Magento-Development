<?php
namespace Brainvire\revise\ViewModel;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\CatalogInventory\Api\StockItemRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class ProductMinimumSalableQty implements ArgumentInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var StockItemRepositoryInterface
     */
    protected $stockItemRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        StockItemRepositoryInterface $stockItemRepository
    ) {
        $this->productRepository = $productRepository;
        $this->stockItemRepository = $stockItemRepository;
    }

    /**
     * Get the minimum salable quantity (MSQ) for the current product.
     *
     * @return float|null
     */
    public function getMinimumSalableQty()
    {
        // Logic to get current product ID (you can get it from the product view context)
        $productId = 1; // Replace with your logic to get current product ID

        try {
            $product = $this->productRepository->getById($productId);
            return $product->getExtensionAttributes()->getStockItem()->getMinSaleQty();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }
}
