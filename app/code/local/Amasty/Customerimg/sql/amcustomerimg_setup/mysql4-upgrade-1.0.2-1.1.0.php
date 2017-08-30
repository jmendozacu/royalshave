<?php
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();
$installer->run("ALTER TABLE `{$this->getTable('amcustomerimg/image')}` ADD `guest_email` VARCHAR( 45 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER  `store_id`");
$installer->endSetup();