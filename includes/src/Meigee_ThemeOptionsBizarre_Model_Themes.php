<?php 
/**
 * Magento
 *
 * @author    Meigeeteam http://www.meaigeeteam.com <nick@meaigeeteam.com>
 * @copyright Copyright (C) 2010 - 2012 Meigeeteam
 *
 */
class Meigee_ThemeOptionsBizarre_Model_Themes
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('Theme Design - default')),
			array('value'=>'_skin1', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('Theme Design - skin1')),
			array('value'=>'_skin2', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('Theme Design - skin2')),
			array('value'=>'_skin3', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('Theme Design - skin3')),
			array('value'=>'_skin4', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('Theme Design - skin4')),
			array('value'=>'_skin5', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('Theme Design - skin5')),
			array('value'=>'_skin6', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('Theme Design - skin6'))
        );
    }

}