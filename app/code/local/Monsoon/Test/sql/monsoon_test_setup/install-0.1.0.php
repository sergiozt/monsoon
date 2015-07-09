<?php
/**
 * User: szheleznytskyi
 * Date: 7/8/15
 * Time: 4:52 PM
 */
/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();
/**
 * Add attribute to category into General information tab.
 * Set yes|no from admin category page to make clickable|unclickable
 * in frontend menu.
 */
$installer->addAttribute(Mage_Catalog_Model_Category::ENTITY, Monsoon_Test_Helper_Data::IS_CLICK_ABLE_LINK_CODE, array(
    'group'        => 'General Information',
    'type'         => 'int',
    'label'        => 'Clickable on navigation',
    'input'        => 'select',
    'source'       => 'eav/entity_attribute_source_boolean',
    'global'       => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible'      => true,
    'required'     => false,
    'user_defined' => false,
    'default'      => Monsoon_Test_Helper_Data::DEFAULT_CLICK_ABLE_CODE,
    'position'     => 100
));

$installer->endSetup();