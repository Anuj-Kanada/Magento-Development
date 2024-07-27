<?php
namespace Brainvire\Event\Observer;

class ChangeDisplayText implements \Magento\Framework\Event\ObserverInterface
{
	public function execute(\Magento\Framework\Event\Observer $observer)
	{
		$displayText = $observer->getData('bv_text');
		echo $displayText->getText() . " -Braivire Event </br>";
		$displayText->setText('Execute event successfully.');

		return $this;
	}
}