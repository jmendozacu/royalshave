<?php

class Meigee_ThemeOptionsBizarre_Block_Adminhtml_Activation_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'themeoptionsbizarre';
        $this->_controller = 'adminhtml_activation';
         
		$this->_removeButton('reset');
        $this->_updateButton('save', 'label', Mage::helper('ThemeOptionsBizarre')->__('Activate (You\'ll be log out when activate is done!)'));
    }
 
    public function getHeaderText()
    {
        return Mage::helper('ThemeOptionsBizarre')->__('Theme Activation');
    }


    


}