<?php
namespace Brainvire\Preference\Model\Rewrite;

class Product extends \Magento\Catalog\Model\Product
{   
    public function getFinalPrice($qty = null)
    {
        $finalPrice = parent::getFinalPrice($qty);  // Ensure to pass $qty to parent method
        $discount = $finalPrice * 0.10;             // 10% discount
        $finalPrice -= $discount;
        return $finalPrice;
    }
}
