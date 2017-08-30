<?php class Meigee_MeigeewidgetsBizarre_Model_Buttonspos
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'0', 'label'=>Mage::helper('meigeewidgetsbizarre')->__('Top')),
            array('value'=>'1', 'label'=>Mage::helper('meigeewidgetsbizarre')->__('Bottom'))
        );
    }

}