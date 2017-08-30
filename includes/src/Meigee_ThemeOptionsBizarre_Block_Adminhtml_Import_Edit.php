<?php

class Meigee_ThemeOptionsBizarre_Block_Adminhtml_Import_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'themeoptionsbizarre';
        $this->_controller = 'adminhtml_import';
        $this->_removeButton('reset');
        $this->_updateButton('save', 'label', Mage::helper('ThemeOptionsBizarre')->__('Import (You\'ll be log out when import is done!)'));
    }
    public function getHeaderText()
    {
        return Mage::helper('ThemeOptionsBizarre')->__('Import Static Content');
    }
}