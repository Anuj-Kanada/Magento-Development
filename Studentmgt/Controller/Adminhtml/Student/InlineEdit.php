<?php
namespace Brainvire\Studentmgt\Controller\Adminhtml\Action;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Brainvire\Studentmgt\Model\ResourceModel\Student\Collection;

/**
 * InlineEdit Action class
 */
class InlineEdit extends Action
{
    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * @var Collection
     */
    protected $studentCollection;

    /**
     * @param Context     $context
     * @param Collection  $studentCollection
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        Collection $studentCollection,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->studentCollection = $studentCollection;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /**
         * @var \Magento\Framework\Controller\Result\Json $resultJson
         */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];
        $postData = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postData))) {
            return $resultJson->setData(
                [
                    'messages' => [__('Please correct the your inputs.')],
                    'error' => true,
                ]
            );
        }
        try {
            $this->studentCollection
                ->setStoreId($this->getRequest()->getParam('store', 0))
                ->addFieldToFilter('entity_id', ['in' => array_keys($postData)])
                ->walk('saveCollection', [$postData]);
        } catch (\Exception $e) {
            $messages[] = __('There was an error saving the data: ') . $e->getMessage();
            $error = true;
        }
        return $resultJson->setData(
            [
                'messages' => $messages,
                'error' => $error,
            ]
        );
    }
}
