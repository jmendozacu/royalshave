<?php

$installer = $this;
$tableNews = $installer->getTable('livechats/livechats');

$installer->startSetup();
$installer->getConnection()->dropTable($tableNews);
$table = $installer->getConnection()
    ->newTable($tableNews)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ))
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, '255', array(
        'nullable'  => false,
        ))
    ->addColumn('content', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => false,
        ));
$installer->getConnection()->createTable($table);

$installer->run("
INSERT INTO {$installer->getTable('livechats/livechats')} 
(`id`, `title`, `content`) VALUES
(1, 'Provide Support livechats', '{\"account\":{\"accountName\":\"\",\"accountHash\":\"\"},\"settings\":\"null\",\"code\":\"\",\"hiddencode\":\"\"}');
");


$installer->endSetup();