<?php
namespace Brainvire\Studentmgt\Block\Adminhtml\Edit;

use Brainvire\Studentmgt\Block\Adminhtml\Edit\Generic;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
/**
 * Back class
 */
class Back extends Generic implements ButtonProviderInterface
{
    /**
     * Get button data
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10,
        ];
    }
    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*/');
    }
}