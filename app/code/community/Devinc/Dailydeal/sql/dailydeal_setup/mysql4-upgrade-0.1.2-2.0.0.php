<?php
$installer = $this;

$installer->startSetup();

$installer->setConfigData('dailydeal/configuration/title_color',              '#F04D3B');
$installer->setConfigData('dailydeal/configuration/qty_color',              '#333333');
$installer->setConfigData('dailydeal/configuration/qty_items_color',	    				'#F04D3B');

$installer->setConfigData('dailydeal/featured_deal/enabled',                  1);
$installer->setConfigData('dailydeal/featured_deal/sidebar_rounded_corners',  0);
$installer->setConfigData('dailydeal/featured_deal/bg_main',          '#FFFFFF');
$installer->setConfigData('dailydeal/featured_deal/title_color',          '#F04D3B');
$installer->setConfigData('dailydeal/featured_deal/product_name_color',          '#333333');
$installer->setConfigData('dailydeal/featured_deal/display_price',          1);
$installer->setConfigData('dailydeal/featured_deal/price_background',          '#FFFFFF');
$installer->setConfigData('dailydeal/featured_deal/old_price_color',          '#A0A0A0');
$installer->setConfigData('dailydeal/featured_deal/special_price_color',          '#32CC5F');
$installer->setConfigData('dailydeal/featured_deal/display_cart_button',          1);
$installer->setConfigData('dailydeal/featured_deal/cart_button_bkg_color',          '#32CC5F');
$installer->setConfigData('dailydeal/featured_deal/cart_button_text_color',          '#FFFFFF');
$installer->setConfigData('dailydeal/featured_deal/display_qty',          1);
$installer->setConfigData('dailydeal/featured_deal/qty_color',          '#333333');
$installer->setConfigData('dailydeal/featured_deal/qty_items_color',          '#F04D3B');
$installer->setConfigData('dailydeal/featured_deal/qty_background_color',          '#FFFFFF');
$installer->setConfigData('dailydeal/featured_deal/qty_border_color',          '#DDDDDD');

$installer->setConfigData('dailydeal/sidebar_configuration/left_sidebar',		1);
$installer->setConfigData('dailydeal/sidebar_configuration/right_sidebar',		1);
$installer->setConfigData('dailydeal/sidebar_configuration/sidedeals_number', 3);
$installer->setConfigData('dailydeal/sidebar_configuration/display_price',		1);
$installer->setConfigData('dailydeal/sidebar_configuration/display_cart_button',    1);
$installer->setConfigData('dailydeal/sidebar_configuration/display_qty',		1);
$installer->setConfigData('dailydeal/sidebar_configuration/qty_color',              '#333333');
$installer->setConfigData('dailydeal/sidebar_configuration/qty_items_color',	    '#F04D3B');

//create daily deal slim static block
$ddBlock = Mage::getModel('cms/block')->getCollection()->addFieldToFilter('identifier', 'daily-deal');
if (count($ddBlock)==0) {
	$staticBlock = array(
	                'title' => 'Daily Deal',
	                'identifier' => 'daily-deal',                    
	                'content' => '{{block type="dailydeal/list_sidedeals" slim="true" name="dailydeal_featured_deal_slim" template="dailydeal/list/featured_deal.phtml" }}',
	                'is_active' => 1,                    
	                'stores' => array(0)
	                );
	Mage::getModel('cms/block')->setData($staticBlock)->save();
}

$installer->endSetup(); 