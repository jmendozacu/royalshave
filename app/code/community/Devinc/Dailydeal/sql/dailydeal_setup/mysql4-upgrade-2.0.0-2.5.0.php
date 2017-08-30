<?php
$installer = $this;

$installer->startSetup();

$installer->setConfigData('dailydeal/configuration/countdown_type',	    		0);

$installer->setConfigData('dailydeal/featured_deal/bg_main',              	  '#FAFAFA');
$installer->setConfigData('dailydeal/featured_deal/price_background',         '#FAFAFA');

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

$installer->endSetup(); 