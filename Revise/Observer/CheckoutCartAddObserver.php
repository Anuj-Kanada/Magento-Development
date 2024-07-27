<?php
namespace Brainvire\Revise\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Psr\Log\LoggerInterface;

class CheckoutCartAddObserver implements ObserverInterface
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        // Get product name being added to cart
        $productName = '';

        // You can get the product name or any other details from the request
        $request = $observer->getEvent()->getData('request');
        if ($request) {
            $productName = $request->getParam('product');
        }

        // Log the product name for testing purposes
        $this->logger->info("Adding product to cart: " . $productName);

        // You can modify the message or show a message here
        // For demonstration purposes, we'll log it
        $this->logger->info("You are adding '$productName' to your cart.");

        // You can also use Magento's message manager to display a message
        // Example: $this->messageManager->addSuccessMessage("You are adding '$productName' to your cart.");

        // Add your custom logic here
    }
}
