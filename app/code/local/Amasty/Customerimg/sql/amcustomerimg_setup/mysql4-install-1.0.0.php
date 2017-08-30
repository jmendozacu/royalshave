<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2010-2011 Amasty (http://www.amasty.com)
* @package Amasty_Customerimg
*/

$installer = $this;
$installer->startSetup();

$installer->run("
CREATE TABLE IF NOT EXISTS `{$this->getTable('amcustomerimg/image')}` (
  `entity_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `store_id` smallint(5) unsigned NOT NULL,
  `file` varchar(128) NOT NULL,
  `file_data_serialized` mediumtext NOT NULL,
  `status` enum('pending','approved','declined') NOT NULL,
  `title` varchar(256) NOT NULL,
  `shown_in_product` tinyint(1) unsigned NOT NULL,
  `shown_in_separate` tinyint(1) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_rewarded` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`entity_id`),
  KEY `customer_id` (`customer_id`),
  KEY `product_id` (`product_id`),
  KEY `customer_id_2` (`customer_id`,`status`,`is_rewarded`),
  KEY `product_id_2` (`product_id`,`status`,`shown_in_separate`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
");

$installer->endSetup(); 