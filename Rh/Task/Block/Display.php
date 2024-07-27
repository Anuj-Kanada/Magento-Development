<?php
namespace Rh\Task\Block;

class Display extends \Magento\Framework\View\Element\Template
     {
    //     public function __construct(\Magento\Framework\View\Element\Template\Context $context)
    //     {
    //         parent::__construct($context);
    //     }

        public function displayData()

        {

            $tableData = [
                'Product Name' => 'Product SKU',
                'Joust Bag' => '24-MB01',
                'Push IT Bag' => '24-MB04',
                'voyage Bag' => '24-MB02'

            ];

            return $tableData;

        }

        public function getDisplayData(){
            $tableData2 = [

                'Product SKU' => 'Product Image',
                '24-MB01' => 'bag.jpeg',
                '24-MB04' => 'tshirt.jpeg',
                '24-MB02'  => 'shoes.jpeg'
            ];

            return $tableData2;
        }

    }