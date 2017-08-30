<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2010-2011 Amasty (http://www.amasty.com)
* @package Amasty_Customerimg
*/
class Amasty_Customerimg_Block_Adminhtml_Image_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('amcustomerimg_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('amcustomerimg')->__('Customer Product Image'));
    }
    
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('amcustomerimg')->__('General Information'),
            'title'     => Mage::helper('amcustomerimg')->__('General Information'),
            'content'   => $this->getLayout()->createBlock('amcustomerimg/adminhtml_image_edit_tab_main')->toHtml(),
        ));
        return parent::_beforeToHtml();
    }
}