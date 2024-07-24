<?php
namespace Brainvire\Studentmgt\Model;

use Magento\Framework\Model\AbstractModel;
use Brainvire\Studentmgt\Model\ResourceModel\Student as StudentResourceModel;

/**
 * Student Model class
 */
class Student extends AbstractModel
{
    /**
     * Construtor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(StudentResourceModel::class);
    }
}
