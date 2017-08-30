<?php 
/**
 * Magento
 *
 * @author    Meigeeteam http://www.meaigeeteam.com <nick@meaigeeteam.com>
 * @copyright Copyright (C) 2010 - 2012 Meigeeteam
 *
 */
class Meigee_ThemeOptionsBizarre_Model_Relatedtype
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'0', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('Large product image')),
			array('value'=>'1', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('Small product image '))
        );
    }

}