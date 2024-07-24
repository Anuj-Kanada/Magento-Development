<?php
namespace Brainvire\Studentmgt\Block\Adminhtml\Edit\Student;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Brainvire\Studentmgt\Block\Adminhtml\Edit\Generic;
use Magento\Ui\Component\Control\Container;
/**
 * Save and Continue class
 */
class SaveAndContinue extends Generic implements ButtonProviderInterface
{
    /**
     * Get button data
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save and Continue'),
            'class' => 'save',
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