<?php
namespace Brainvire\Studentmgt\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Department ResouceModel class
 */
class Department extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('department', 'department_id');
    }
}