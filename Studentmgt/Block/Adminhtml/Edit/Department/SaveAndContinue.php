<?php
namespace Brainvire\Studentmgt\Block\Adminhtml\Edit\Department;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Ui\Component\Control\Container;
use Brainvire\Studentmgt\Block\Adminhtml\Edit\Generic;

/**
 * Save And Continue class
 */
class SaveAndContinue extends Generic implements ButtonProviderInterface
{
    /**
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
                                'targetName' => 'department_form.department_form',
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