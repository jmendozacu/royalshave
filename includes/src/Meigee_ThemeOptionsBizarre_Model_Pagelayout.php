<?php 
/**
 * Magento
 *
 * @author    Meigeeteam http://www.meaigeeteam.com <nick@meaigeeteam.com>
 * @copyright Copyright (C) 2010 - 2012 Meigeeteam
 *
 */
class Meigee_ThemeOptionsBizarre_Model_Pagelayout
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'left', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('Left')),
            array('value'=>'right', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('Right')),
            array('value'=>'none', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('No Sidebar'))          
        );
    }

}