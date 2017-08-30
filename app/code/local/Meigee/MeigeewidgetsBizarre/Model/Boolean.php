<?php class Meigee_MeigeewidgetsBizarre_Model_Boolean
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'1', 'label'=>Mage::helper('meigeewidgetsbizarre')->__('True')),
            array('value'=>'0', 'label'=>Mage::helper('meigeewidgetsbizarre')->__('False'))
        );
    }

}