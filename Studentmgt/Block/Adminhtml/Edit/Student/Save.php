<?php
namespace Brainvire\Studentmgt\Block\Adminhtml\Edit\Student;

use Magento\Ui\Component\Control\Container;
use Brainvire\Studentmgt\Block\Adminhtml\Edit\Generic;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
/**
 * Save class
 */
class Save extends Generic implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => 'student_form.student_form',
                                'actionName' => 'save',
                                'params' => [false],
                            ],
                        ],
                    ],
                ],
            ],
            'class_name' => Container::DEFAULT_CONTROL
        ];
    }
}