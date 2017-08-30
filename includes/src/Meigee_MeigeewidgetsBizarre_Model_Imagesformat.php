<?php class Meigee_MeigeewidgetsBizarre_Model_Imagesformat
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'.png', 'label'=>Mage::helper('meigeewidgetsbizarre')->__('.png')),
            array('value'=>'.jpg', 'label'=>Mage::helper('meigeewidgetsbizarre')->__('.jpg')),
            array('value'=>'.gif', 'label'=>Mage::helper('meigeewidgetsbizarre')->__('.gif'))
        );
    }

}