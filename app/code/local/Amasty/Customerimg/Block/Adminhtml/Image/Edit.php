<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2010-2011 Amasty (http://www.amasty.com)
* @package Amasty_Customerimg
*/
class Amasty_Customerimg_Block_Adminhtml_Image_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId   = 'entity_id';
        $this->_blockGroup = 'amcustomerimg';
        $this->_controller = 'adminhtml_image';

        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('amcustomerimg')->__('Save Image'));
        $this->_removeButton('delete');
    }
    
    public function getHeaderText()
    {
        return Mage::helper('amcustomerimg')->__("Edit Image");
    }
}