<?php
namespace Brainvire\Studentmgt\Model\ResourceModel\Student;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Brainvire\Studentmgt\Model\Student as StudentModel;
use Brainvire\Studentmgt\Model\ResourceModel\Student as StudentResourceModel;

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
        $this->_init(StudentModel::class, StudentResourceModel::class);
    }
}