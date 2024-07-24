<?php
namespace Brainvire\Studentmgt\Model\ResourceModel\Department;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Brainvire\Studentmgt\Model\Department as DepartmentModel;
use Brainvire\Studentmgt\Model\ResourceModel\Department as DepartmentResourceModel;

/**
 * Collection class
 */
class Collection extends AbstractCollection
{
    /**
     * Constructor function
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(DepartmentModel::class, DepartmentResourceModel::class);
    }
}