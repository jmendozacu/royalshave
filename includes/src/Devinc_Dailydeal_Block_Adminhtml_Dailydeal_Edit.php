<?php

class Devinc_Dailydeal_Block_Adminhtml_Dailydeal_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'dailydeal';
        $this->_controller = 'adminhtml_dailydeal';
        
    	//deal buttons
        $this->_updateButton('save', 'label', Mage::helper('dailydeal')->__('Save Deal'));
        $this->_updateButton('delete', 'label', Mage::helper('dailydeal')->__('Delete Deal'));
		$this->_removeButton('reset');		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit(\''.$this->_getSaveAndContinueUrl().'\')',
            'class'     => 'save',
        ), -100);	
        
        $this->_formScripts[] = "
            function saveAndContinueEdit(urlTemplate) {
                var tabsIdValue = dailydeal_tabsJsTabs.activeTab.id;
                var tabsBlockPrefix = 'dailydeal_tabs_';
                if (tabsIdValue.startsWith(tabsBlockPrefix)) {
                    tabsIdValue = tabsIdValue.substr(tabsBlockPrefix.length);
                }
                var template = new Template(urlTemplate, /(^|.|\\r|\\n)({{(\w+)}})/);
                var url = template.evaluate({tab_id:tabsIdValue});
                editForm.submit(url);
            }
        ";
    }
    
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('*/*/save', array(
            '_current'   => true,
            'back'       => 'edit',
            'active_tab' => '{{tab_id}}'
        ));
    }

    public function getHeaderText()
    {
        if ($this->getDeal() && $this->getDeal()->getId()) {
            return Mage::helper('dailydeal')->__("Edit Deal");
        } else {
            return Mage::helper('dailydeal')->__('Add Deal');
        }
    }
    
	public function getDeal()
    {
        return Mage::registry('dailydeal_data');
    }
}