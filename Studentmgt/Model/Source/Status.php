<?php
namespace Brainvire\Studentmgt\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
        public function toOptionArray()
        {
            return [
                ['value' => '1', 'label' => __('Active')],
                ['value' => '0', 'label' => __('Inactive')],
            
            ];
        }
        public function getOptionText($value)
        {
            foreach ($this->toOptionArray() as $option) {
                if ($option['value'] == $value) {
                    return $option['label'];
                }
            }
            return '';
        }
}