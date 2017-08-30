<?php 
/**
 * Magento
 *
 * @author    Meigeeteam http://www.meigeeteam.com <nick@meigeeteam.com>
 * @copyright Copyright (C) 2010 - 2014 Meigeeteam
 *
 */
class Meigee_ThemeOptionsBizarre_Model_Newsletterbg
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'0', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('Left')),
            array('value'=>'1', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('Right')),
			array('value'=>'2', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('Center')),
			array('value'=>'3', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('Fill with stretching'))
        );
    }

}