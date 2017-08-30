<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2010-2011 Amasty (http://www.amasty.com)
* @package Amasty_Customerimg
*/
class Amasty_Customerimg_Block_Adminhtml_Image_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected function _prepareForm()
    {
        $model = Mage::registry('amcustomerimg_image');

        return parent::_prepareForm();
    }
    
    public function getTabLabel()
    {
        return Mage::helper('amcustomerimg')->__('Image Information');
    }
    
    public function getTabTitle()
    {
        return Mage::helper('amcustomerimg')->__('Image Information');
    }
    
    public function canShowTab()
    {
        return true;
    }
    
    public function isHidden()
    {
        return false;
    }
}