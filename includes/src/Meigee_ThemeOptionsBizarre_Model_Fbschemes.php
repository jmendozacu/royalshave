<?php 
/**
 * Magento
 *
 * @author    Meigeeteam http://www.meigeeteam.com <nick@meigeeteam.com>
 * @copyright Copyright (C) 2010 - 2014 Meigeeteam
 *
 */
class Meigee_ThemeOptionsBizarre_Model_Fbschemes
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'light', 'label'=>Mage::helper('meigeewidgetsbizarre')->__('Light')),
            array('value'=>'dark', 'label'=>Mage::helper('meigeewidgetsbizarre')->__('Dark')),
        );
    }

}