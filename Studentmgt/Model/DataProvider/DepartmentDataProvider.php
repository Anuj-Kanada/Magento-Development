<?php
namespace Brainvire\Studentmgt\Model\DataProvider;

use Brainvire\Studentmgt\Model\ResourceModel\Department\CollectionFactory as DepartmentCollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
/**
 * DepartmentDataProvider class
 */
class DepartmentDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
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
     * @param DepartmentCollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        DepartmentCollectionFactory $collectionFactory,
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
            echo "ak";
            exit;
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $this->loadedData[$model->getId()] = $model->getData();
        }
        $data = $this->dataPersistor->get('department_form');
        
        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('department_form');
        }
        
        return $this->loadedData;
    }
}