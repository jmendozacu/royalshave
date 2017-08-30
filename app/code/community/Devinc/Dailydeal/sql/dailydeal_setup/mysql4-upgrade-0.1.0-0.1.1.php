<?php
$installer = $this;

$installer->startSetup();

//add new datetime columns
$installer->getConnection()->addColumn($installer->getTable('dailydeal'), 'datetime_from', 'datetime after `deal_qty`');
$installer->getConnection()->addColumn($installer->getTable('dailydeal'), 'datetime_to', 'datetime after `datetime_from`');

//migrate date from/to and time from/to values to datetime from/to column
$dealCollection = Mage::getModel('dailydeal/dailydeal')->getCollection();

foreach ($dealCollection as $deal) {	
	$value['datetime_from'] = $deal->getDateFrom().' '.str_replace(',',':',$deal->getTimeFrom());
	$value['datetime_to'] = $deal->getDateTo().' '.str_replace(',',':',$deal->getTimeTo());
	
	$deal->setDatetimeFrom($value['datetime_from']);
	$deal->setDatetimeTo($value['datetime_to']);
	$deal->save();
}

//drop previous columns
$installer->getConnection()->dropColumn($installer->getTable('dailydeal'), 'date_from');
$installer->getConnection()->dropColumn($installer->getTable('dailydeal'), 'date_to');
$installer->getConnection()->dropColumn($installer->getTable('dailydeal'), 'time_from');
$installer->getConnection()->dropColumn($installer->getTable('dailydeal'), 'time_to');

//add new columns
$installer->getConnection()->addColumn($installer->getTable('dailydeal'), 'position', 'int(11)');
$installer->getConnection()->addColumn($installer->getTable('dailydeal'), 'stores', 'varchar(255) after `datetime_to`');

//drop type column as it's no longer needed
$installer->getConnection()->dropColumn($installer->getTable('dailydeal'), 'type');

//set new config data
$installer->setConfigData('dailydeal/configuration/redirect',		0);

$installer->endSetup(); 