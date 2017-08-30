<?php
/**
 * Magento
 *
 * @author    Meigeeteam http://www.meaigeeteam.com <nick@meaigeeteam.com>
 * @copyright Copyright (C) 2010 - 2012 Meigeeteam
 *
 */
class Meigee_ThemeOptionsBizarre_Model_labelsorder
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'sale_new', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('On sale, New')),
            array('value'=>'new_sale', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('New, On sale'))
        );
    }

}