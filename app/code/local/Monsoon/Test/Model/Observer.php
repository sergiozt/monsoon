<?php

/**
 * User: szheleznytskyi
 * Date: 7/8/15
 * Time: 6:23 PM
 */
class Monsoon_Test_Model_Observer extends Mage_Catalog_Model_Observer
{
    /**
     * Recursively adds categories to top menu
     *
     * @param Varien_Data_Tree_Node_Collection|array $categories
     * @param Varien_Data_Tree_Node $parentCategoryNode
     * @param Mage_Page_Block_Html_Topmenu $menuBlock
     * @param bool $addTags
     */
    protected function _addCategoriesToMenu($categories, $parentCategoryNode, $menuBlock, $addTags = false)
    {
        $categoryModel = Mage::getModel('catalog/category');
        foreach ($categories as $category) {
            if (!$category->getIsActive()) {
                continue;
            }

            $nodeId = 'category-node-' . $category->getId();

            $categoryModel->setId($category->getId());
            if ($addTags) {
                $menuBlock->addModelTags($categoryModel);
            }

            $tree = $parentCategoryNode->getTree();
            $categoryData = array(
                'name'      => $category->getName(),
                'id'        => $nodeId,
                'url'       => $this->_categoryUrl($category),
                'is_active' => $this->_isActiveMenuCategory($category),
            );
            $categoryNode = new Varien_Data_Tree_Node($categoryData, 'id', $tree, $parentCategoryNode);
            $parentCategoryNode->addChild($categoryNode);

            $flatHelper = Mage::helper('catalog/category_flat');
            if ($flatHelper->isEnabled() && $flatHelper->isBuilt(true)) {
                $subcategories = (array)$category->getChildrenNodes();
            } else {
                $subcategories = $category->getChildren();
            }

            $this->_addCategoriesToMenu($subcategories, $categoryNode, $menuBlock, $addTags);
        }
    }

    /**
     * Check if click able enabled for category.
     *
     * @param Varien_Data_Tree_Node|Mage_Catalog_Model_Category $category
     * @return bool
     */
    protected function _isCategoryClickAble($category)
    {
        $isCategoryClickAbleStatus = true;
        $isCategoryClickAble = $category->getData(Monsoon_Test_Helper_Data::IS_CLICK_ABLE_LINK_CODE);
        if ($isCategoryClickAble !== null && (bool)$isCategoryClickAble === false) {
            $isCategoryClickAbleStatus = false;
        }

        return $isCategoryClickAbleStatus;
    }

    /**
     * Get category url.
     * Return real url if is enabled as click able.
     *
     * @param Varien_Data_Tree_Node|Mage_Catalog_Model_Category $category
     * @return string
     */
    protected function _categoryUrl($category)
    {
        $url = Monsoon_Test_Helper_Data::DISABLED_HREF_SYMBOL;
        if ($this->_isCategoryClickAble($category)) {
            $url = Mage::helper('catalog/category')->getCategoryUrl($category);
        }

        return $url;
    }

    /**
     * Set click able by default for
     * already existed categories.
     *
     * @param Varien_Event_Observer $observer
     */
    public function addCatalogDefaultAttributeValue(Varien_Event_Observer $observer)
    {
        /** @var Varien_Data_Form $form */
        $form = $observer->getEvent()->getForm();
        if ($element = $form->getElement(Monsoon_Test_Helper_Data::IS_CLICK_ABLE_LINK_CODE)) {
            $isClickAble = $element->getValue();
            if ($isClickAble === null) {
                $element->setValue(Monsoon_Test_Helper_Data::DEFAULT_CLICK_ABLE_CODE);
            }
        }
    }

    /**
     * Add Is clickable attribute when
     * using flat  for category.
     *
     * @param Varien_Event_Observer $observer
     */
    public function catalogCategoryFlatLoadnodesBefore(Varien_Event_Observer $observer)
    {
        /** @var Zend_Db_Select $select */
        $select = $observer->getData('select');
        $select->columns(array(Monsoon_Test_Helper_Data::IS_CLICK_ABLE_LINK_CODE));
    }
}