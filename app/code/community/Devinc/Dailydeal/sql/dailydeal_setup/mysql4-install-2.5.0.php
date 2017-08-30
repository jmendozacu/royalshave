<?php

$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('dailydeal')};
CREATE TABLE {$this->getTable('dailydeal')} (
  `dailydeal_id` int(11) unsigned NOT NULL auto_increment,
  `product_id` int(11) NOT NULL,
  `deal_price` decimal(12,2) NOT NULL,
  `deal_qty` int(11) NOT NULL,
  `datetime_from` datetime NULL,
  `datetime_to` datetime NULL,
  `stores` varchar(255) NOT NULL default '',
  `qty_sold` int(11) NOT NULL,
  `nr_views` int(11) NOT NULL,
  `disable` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`dailydeal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
	
$installer->setConfigData('dailydeal/configuration/enabled',					0);
$installer->setConfigData('dailydeal/configuration/header_links',				0);
$installer->setConfigData('dailydeal/configuration/redirect',					0);
$installer->setConfigData('dailydeal/configuration/title_color',              '#F04D3B');
$installer->setConfigData('dailydeal/configuration/qty',              1);
$installer->setConfigData('dailydeal/configuration/qty_color',              '#333333');
$installer->setConfigData('dailydeal/configuration/qty_items_color',	    				'#F04D3B');
$installer->setConfigData('dailydeal/configuration/past_deals',	    			1);
$installer->setConfigData('dailydeal/configuration/no_deal_message',	    	'There are no deals currently setup. Please try again later.');
$installer->setConfigData('dailydeal/configuration/notify',	    				0);
$installer->setConfigData('dailydeal/configuration/admin_email',	    		'');
$installer->setConfigData('dailydeal/configuration/countdown_type',	    		0);
$installer->setConfigData('dailydeal/configuration/refresh_rate',   			30);

$installer->setConfigData('dailydeal/featured_deal/enabled',                  1);
$installer->setConfigData('dailydeal/featured_deal/sidebar_rounded_corners',  0);
$installer->setConfigData('dailydeal/featured_deal/bg_main',          '#FAFAFA');
$installer->setConfigData('dailydeal/featured_deal/title_color',          '#F04D3B');
$installer->setConfigData('dailydeal/featured_deal/product_name_color',          '#333333');
$installer->setConfigData('dailydeal/featured_deal/display_price',          1);
$installer->setConfigData('dailydeal/featured_deal/price_background',          '#FAFAFA');
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
$installer->setConfigData('dailydeal/sidebar_configuration/qty_items_color',      '#F04D3B');

$installer->setConfigData('dailydeal/circle_countdown/bg_color',              '#C0CACA');
$installer->setConfigData('dailydeal/circle_countdown/loading_color',         '#E5E9E9');
$installer->setConfigData('dailydeal/circle_countdown/text_color',            '#333333');
$installer->setConfigData('dailydeal/circle_countdown/days_text',             'DAYS');
$installer->setConfigData('dailydeal/circle_countdown/hour_text',             'HOURS');
$installer->setConfigData('dailydeal/circle_countdown/min_text',              'MINUTES');
$installer->setConfigData('dailydeal/circle_countdown/sec_text',              'SECONDS');

$installer->setConfigData('dailydeal/flip_countdown/bg_color',                '#333333');
$installer->setConfigData('dailydeal/flip_countdown/digit_color',             '#FFFFFF');
$installer->setConfigData('dailydeal/flip_countdown/text_color',              '#333333');
$installer->setConfigData('dailydeal/flip_countdown/days_text',               'DAYS');
$installer->setConfigData('dailydeal/flip_countdown/hour_text',               'HOURS');
$installer->setConfigData('dailydeal/flip_countdown/min_text',                'MINUTES');
$installer->setConfigData('dailydeal/flip_countdown/sec_text',                'SECONDS');

$installer->setConfigData('dailydeal/simple_countdown/digit_color',                '#333333');
$installer->setConfigData('dailydeal/simple_countdown/bullet_color',             '#AEAEAE');
$installer->setConfigData('dailydeal/simple_countdown/text_color',              '#777777');
$installer->setConfigData('dailydeal/simple_countdown/days_text',               'days');
$installer->setConfigData('dailydeal/simple_countdown/hour_text',               'hours');
$installer->setConfigData('dailydeal/simple_countdown/min_text',                'mins');
$installer->setConfigData('dailydeal/simple_countdown/sec_text',                'secs');

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