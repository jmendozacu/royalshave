<?php class Meigee_MeigeewidgetsBizarre_Model_Fbschemes
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'light', 'label'=>Mage::helper('meigeewidgetsbizarre')->__('Light')),
            array('value'=>'dark', 'label'=>Mage::helper('meigeewidgetsbizarre')->__('Dark')),
        );
    }

}