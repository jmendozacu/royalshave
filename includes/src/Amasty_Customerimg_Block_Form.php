<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2010-2011 Amasty (http://www.amasty.com)
* @package Amasty_Customerimg
*/
class Amasty_Customerimg_Block_Form extends Mage_Core_Block_Template
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('amasty/amcustomerimg/form.phtml');
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
    
    public function getPostUrl()
    {
        return $this->getUrl('amcustomerimg/image/upload');
    }
}