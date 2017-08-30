<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2010-2011 Amasty (http://www.amasty.com)
* @package Amasty_Customerimg
*/
class Amasty_Customerimg_Model_Mysql4_Image_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('amcustomerimg/image');
    }
    
    protected function _getMainAlias()
    {
        if (false !== strpos($this->getSelect()->__toString(), 'main_table'))
        {
            $mainAlias = 'main_table';
        } else 
        {
            $mainAlias = 'e';
        }
        return $mainAlias;
    }
    
    public function addCustomerEmail()
    {
        $this->getSelect()->joinLeft(
            array('customer' => Mage::getModel('customer/customer')->getResource()->getEntityTable()),
            'customer.entity_id = ' . $this->_getMainAlias() . '.customer_id',
            array('customer_email' => 'email')
        );
    }
    
    public function addProductName()
    {
        $productCollection = Mage::getModel('catalog/product')->getCollection();
        $attrInstance = Mage::getSingleton('eav/config')
                    ->getCollectionAttribute($productCollection->getEntity()->getType(), 'name');
        $table = $productCollection->getResource()->getEntityTable() . '_' . $attrInstance->getBackendType();
        
        $this->getSelect()->joinLeft(
            array('productname' => $table),
            'productname.entity_id = ' . $this->_getMainAlias() . '.product_id AND productname.attribute_id = "' . $attrInstance->getAttributeId() . '" AND productname.store_id = "' .  Mage::app()->getStore()->getId() . '"',
            array('value')
        );
    }
    
    public function addProductSku()
    {
        $productCollection = Mage::getModel('catalog/product')->getCollection();
        $table = $productCollection->getResource()->getEntityTable();
        
        $this->getSelect()->joinLeft(
            array('product' => $table),
            'product.entity_id = ' . $this->_getMainAlias() . '.product_id',
            array('sku')
        );
    }
}