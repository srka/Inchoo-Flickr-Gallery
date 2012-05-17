<?php 
$installer = $this;
$installer->startSetup();
$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('flickr')};
CREATE TABLE {$this->getTable('flickr')} (
  `flickr_id` int(11) unsigned NOT NULL auto_increment,
  `response_type` varchar(255) NOT NULL default '',
  `content` text NULL,
  `created_time` datetime NULL,
  PRIMARY KEY (`flickr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
"); 
$installer->endSetup();