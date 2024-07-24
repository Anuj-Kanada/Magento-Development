<?php
namespace Brainvire\Studentmgt\Model;

use Magento\Framework\Model\AbstractModel;
use Brainvire\Studentmgt\Model\ResourceModel\Department as DepartmentResourceModel;

/**
 * Department Model class
 */
class Department extends AbstractModel
{
    /**
     * Construtor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(DepartmentResourceModel::class);
    }
}
