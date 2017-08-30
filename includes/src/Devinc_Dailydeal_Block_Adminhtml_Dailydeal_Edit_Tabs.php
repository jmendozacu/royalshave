<?php

class Devinc_Dailydeal_Block_Adminhtml_Dailydeal_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('dailydeal_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('dailydeal')->__('Deal Information'));
  }
  
  protected function _prepareLayout()
  {	  
      $this->addTab('settings_section', array(
          'label'     => Mage::helper('dailydeal')->__('Deal Settings'),
          'title'     => Mage::helper('dailydeal')->__('Deal Settings'),
          'content'   => Mage::getModel('license/module')->getDealSettingsBlock($this, 'dailydeal'),
      ));
	  
      $this->addTab('products_section', array(
          'label'     => Mage::helper('dailydeal')->__('Select a Product'),
          'title'     => Mage::helper('dailydeal')->__('Select a Product'),
          'content'   => Mage::getModel('license/module')->getProductsBlock($this, 'dailydeal'),
      ));
     
      return parent::_prepareLayout();
  }
}