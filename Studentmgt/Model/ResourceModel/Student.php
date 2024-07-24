<?php
namespace Brainvire\Studentmgt\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Student ResouceModel class
 */
class Student extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('student', 'student_id');
    }
}