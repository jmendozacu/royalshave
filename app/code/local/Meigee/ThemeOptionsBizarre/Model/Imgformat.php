<?php
/**
 * Magento
 *
 * @author    Meigeeteam http://www.meaigeeteam.com <nick@meaigeeteam.com>
 * @copyright Copyright (C) 2010 - 2012 Meigeeteam
 *
 */
class Meigee_ThemeOptionsBizarre_Model_Imgformat
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'.png', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('.png')),
            array('value'=>'.jpg', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('.jpg')),
            array('value'=>'.gif', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('.gif'))          
        );
    }

}