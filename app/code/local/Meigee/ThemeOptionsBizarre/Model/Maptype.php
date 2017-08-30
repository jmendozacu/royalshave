<?php 
/**
 * Magento
 *
 * @author    Meigeeteam http://www.meaigeeteam.com <nick@meaigeeteam.com>
 * @copyright Copyright (C) 2010 - 2012 Meigeeteam
 *
 */
class Meigee_ThemeOptionsBizarre_Model_Maptype
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'ROADMAP', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('Normal street map')),
            array('value'=>'SATELLITE', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('Satellite images')),
			array('value'=>'TERRAIN', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('Map with physical features'))
        );
    }

}