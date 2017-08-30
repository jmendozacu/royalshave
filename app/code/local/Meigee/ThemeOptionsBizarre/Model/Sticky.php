<?php 
/**
 * Magento
 *
 * @author    Meigeeteam http://www.meaigeeteam.com <nick@meaigeeteam.com>
 * @copyright Copyright (C) 2010 - 2012 Meigeeteam
 *
 */
class Meigee_ThemeOptionsBizarre_Model_Sticky
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'0', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('Hide')),
            array('value'=>'1', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('Display only on desktop version')),
            array('value'=>'2', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('Display on all versions'))
        );
    }

}