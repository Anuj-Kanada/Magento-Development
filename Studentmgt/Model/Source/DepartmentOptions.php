<?php
namespace Brainvire\Studentmgt\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Brainvire\Studentmgt\Model\ResourceModel\Department\CollectionFactory;

/**
 * Department class
 */
class DepartmentOptions implements OptionSourceInterface
{
    protected $student;
    
    protected $departmentCollection;

    public function __construct(CollectionFactory $departmentCollection){
        $this->departmentCollection = $departmentCollection;
    }
    public function toOptionArray()
    {
        $departmentOptions = [];
        $departmentCollection = $this->departmentCollection->create();

        foreach ($departmentCollection as $department) {
            $departmentOptions[] = [
                'value' => $department->getId(),
                'label' => $department->getDepartment(),
            ];
        }
        return $departmentOptions;
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
