<?php
namespace Brainvire\CustomerMgt\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;
use Psr\Log\LoggerInterface;

class CustomerAttribute implements DataPatchInterface, UninstallInterface
{
    private $attributeName = 'mobile_number';
    private $moduleDataSetup;
    private $eavSetupFactory;
    private $logger;
    private $eavConfig;
    private $attributeResource;

    public function __construct(
        EavSetupFactory $eavSetupFactory,
        Config $eavConfig,
        LoggerInterface $logger,
        \Magento\Customer\Model\ResourceModel\Attribute $attributeResource,
        \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
    )
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
        $this->logger = $logger;
        $this->attributeResource = $attributeResource;
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $this->addMobilePhoneAttribute();
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function addMobilePhoneAttribute()
    {
        $eavSetup = $this->eavSetupFactory->create([ 'setup' => $this->moduleDataSetup ]);
        $eavSetup->addAttribute(
                \Magento\Customer\Model\Customer::ENTITY,
                $this->attributeName,
                [
                    'type'          => 'varchar',
                    'label'         => 'Mobile Number',
                    'input'         => 'text',
                    'required'      => 1,
                    'visible'       => 1,
                    'user_defined'  => 1,
                    'sort_order'    => 999,
                    'position'      => 999,
                    'system'        => 0
                ]
        );
        
        $attributeSetId = $eavSetup->getDefaultAttributeSetId(Customer::ENTITY);
        $attributeGroupId = $eavSetup->getDefaultAttributeGroupId(Customer::ENTITY);
        $attribute = $this->eavConfig->getAttribute(
                Customer::ENTITY,
                $this->attributeName
        );

        $attribute->setData('attribute_set_id', $attributeSetId);
        $attribute->setData('attribute_group_id', $attributeGroupId);
        $attribute->setData('used_in_forms', [ 'adminhtml_customer', 'customer_account_create', 'customer_account_edit' ]);

        $this->attributeResource->save($attribute);
    }
    
    public static function getDependencies()
    {
        return [];
    }

    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $eavSetup = $this->eavSetupFactory->create([ 'setup' => $this->moduleDataSetup ]);
        $eavSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, $this->attributeName);
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function getAliases()
    {
        return [];
    }
}