<?php
namespace Brainvire\Studentmgt\Model\DataProvider;

use Brainvire\Studentmgt\Model\ResourceModel\Student\CollectionFactory as StudentCollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * StudentDataProvider class
 */
class StudentDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * LoadedData variable
     *
     * @var $loadedData
     */
    protected $loadedData;
    /**
     * Collection variable
     *
     * @var $collection
     */
    protected $collection;

    protected $dataPersistor;

    /**
     * Constructor function
     *
     * @param  $name
     * @param  $primaryFieldName
     * @param  $requestFieldName
     * @param StudentCollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        StudentCollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * GetData function
     *
     * @return object
     */
    public function getData()
    {

        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $this->loadedData[$model->getId()] = $model->getData();
        }
        $data = $this->dataPersistor->get('student_form');

        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('student_form');
        }
        return $this->loadedData;
    }
}