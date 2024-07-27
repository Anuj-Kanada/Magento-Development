<?php
namespace Brainvire\Plugins\Plugin;

class ProductPlugin
{
    public function afterGetName(\Magento\Catalog\Model\Product $subject, $result)
    {
        // Add 'Ak ' prefix to product name
        return 'Ak ' . $result;
    }
}
