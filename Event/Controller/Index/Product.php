<?php
namespace Brainvire\Event\Controller\Index;

class Product extends \Magento\Framework\App\Action\Action
{
	public function execute()
	{
		$textDisplay = new \Magento\Framework\DataObject(array('text' => 'Braivire'));
		$this->_eventManager->dispatch('Braivire_event_display_text', ['bv_text' => $textDisplay]);
		echo $textDisplay->getText();
		exit;
	}
}
