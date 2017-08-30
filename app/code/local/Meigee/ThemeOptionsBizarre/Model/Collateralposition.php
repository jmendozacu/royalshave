<?php 
/**
 * Magento
 *
 * @author    Meigeeteam http://www.meaigeeteam.com <nick@meaigeeteam.com>
 * @copyright Copyright (C) 2010 - 2012 Meigeeteam
 *
 */
class Meigee_ThemeOptionsBizarre_Model_Collateralposition
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'details', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('Product Details Col')),
            array('value'=>'underdetails', 'label'=>Mage::helper('ThemeOptionsBizarre')->__('Under Product Details Col'))          
        );
    }

}