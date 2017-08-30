<?php 
/**
 * Magento
 *
 * @author    Meigeeteam http://www.meaigeeteam.com <nick@meaigeeteam.com>
 * @copyright Copyright (C) 2010 - 2012 Meigeeteam
 *
 */
class Meigee_ThemeOptionsBizarre_Model_Headerbg
{
    public function toOptionArray()
    {
        return array(
            array('value'=>0, 'label'=>Mage::helper('ThemeOptionsBizarre')->__('Skin color')),
            array('value'=>1, 'label'=>Mage::helper('ThemeOptionsBizarre')->__('Part of 1st banner'))
        );
    }

}