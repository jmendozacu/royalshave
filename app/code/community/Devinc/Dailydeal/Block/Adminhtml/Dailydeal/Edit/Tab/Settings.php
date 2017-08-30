<?php

class Devinc_Dailydeal_Block_Adminhtml_Dailydeal_Edit_Tab_Settings extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('dailydeal_settings', array('legend'=>Mage::helper('dailydeal')->__('Deal Information')));     
    	 
    	//add fields
    	$field = $fieldset->addField('product_id', 'text', array(
            'label'     => Mage::helper('dailydeal')->__('Product Details'),
            'name'      => 'product_id',
            'class'     => 'required-entry',
            'required'  => true,
        ));	    	
    	$field->setRenderer($this->getLayout()->createBlock('dailydeal/adminhtml_dailydeal_edit_renderer_productinfo'));
    	
    	$field = $fieldset->addField('deal_price', 'text', array(
            'label'     => Mage::helper('dailydeal')->__('Deal Price'),
            'name'      => 'deal_price',
            'class'     => 'required-entry',
            'required'  => true,
        ));	
    	 
    	$field = $fieldset->addField('deal_qty', 'text', array(
            'label'     => Mage::helper('dailydeal')->__('Deal Qty'),
            'name'      => 'deal_qty',
            'class'     => 'required-entry',
            'required'  => true,
        ));	
    		
    	$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);  	    
  	    $field = $fieldset->addField('datetime_from', 'date', array(
            'name'      => 'datetime_from',
            'time'      => true,
            'label'     => Mage::helper('dailydeal')->__('Date/Time From'),
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'class'     => 'required-entry',
            'required'  => true,
            'format'    => $dateFormatIso,	
            'style'	    => 'width:162px !important',
        ));
        
  	    $field = $fieldset->addField('datetime_to', 'date', array(
            'name'      => 'datetime_to',
            'time'      => true,
            'label'     => Mage::helper('dailydeal')->__('Date/Time To'),
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'class'     => 'required-entry',
            'required'  => true,
            'format'    => $dateFormatIso,	
            'style'	    => 'width:162px !important',
        )); 	   
		
		$stores = Mage::getModel('dailydeal/dailydeal')->getStoreViews();
	    $fieldset->addField('stores', 'multiselect', array(
            'label'     => Mage::helper('dailydeal')->__('Run on Store'),
            'name'      => 'stores',
            'style'     => 'height:100px',
            'values'    => $stores,
            'class'     => 'required-entry',
            'required'  => true,
    		'note'		=> Mage::helper('dailydeal')->__('Select the stores in which you want the deal to run.')
        ));  
    		    		
    	$fieldset->addField('disable', 'select', array(
        	'label'     => Mage::helper('dailydeal')->__('Disable product after deal ends'),
            'name'      => 'disable',
            'values'    => array(
            	array(
                	'value'     => 1,
                    'label'     => Mage::helper('dailydeal')->__('No'),
                ),    
                array(
                    'value'     => 2,
                    'label'     => Mage::helper('dailydeal')->__('Yes'),
                ),
            ),
    		'note'		=> Mage::helper('dailydeal')->__('If Yes - the product will be disabled from the catalog &amp; search after the deal ends to prevent it from appearing on search engines.')
        ));	     
    		
        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('dailydeal')->__('Deal status'),
            'name'      => 'status',
            'class'     => 'required-entry validate-select',
            'required'  => true,
            'values'    => array(
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('dailydeal')->__('Enabled'),
                ),
    
                array(
                    'value'     => 2,
                    'label'     => Mage::helper('dailydeal')->__('Disabled'),
                ),
            ),
        ));     
        
  	    $field = $fieldset->addField('position', 'text', array(
              'label'     => Mage::helper('dailydeal')->__('Position'),
              'name'      => 'position',
              'required'  => false,
        ));	  	  
       
        //set default/session values
        if ($data = Mage::registry('dailydeal_data')) {	
            $form->setValues($data);
        }
        
        return parent::_prepareForm();
    }
}