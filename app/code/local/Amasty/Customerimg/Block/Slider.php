<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2010-2011 Amasty (http://www.amasty.com)
* @package Amasty_Customerimg
*/
class Amasty_Customerimg_Block_Slider extends Mage_Core_Block_Template
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('amasty/amcustomerimg/slider.phtml');
    }
    
    public function showHeader()
    {
        return true;
    }
    
    public function getProductId()
    {
        if ($product = Mage::registry('current_product'))
        {
            return $product->getId();
        }
        return 0;
    }
    
    public function getImages()
    {
        if (!$this->getProductId())
        {
            return null;
        }
        $imageCollection = Mage::getModel('amcustomerimg/image')->getCollection();
        $imageCollection->addFieldToFilter('product_id', $this->getProductId());
        $imageCollection->addFieldToFilter('status', 'approved');
        $imageCollection->addFieldToFilter('shown_in_separate', 1);
        $imageCollection->load();
        return $imageCollection;
    }
}