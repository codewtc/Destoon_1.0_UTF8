<?php
defined('IN_DESTOON') or exit('Access Denied');
defined('DT_ADMIN') or exit('Access Denied');
$_groupid == 1 or exit('Access Denied');
$setting = array('htm_list_prefix' => '','list_html' => '0','index_html' => '0','seo_description' => '','seo_keywords' => '','seo_title' => '','rss_time' => '3600','rss_num' => '50','rss_length' => '300','rss_mode' => '1','captcha_add' => '1','member_check' => '1','member_add' => '1','max_days' => '90','over_days' => '30','text_data' => '1','clear_link' => '1','introduce_length' => '120','save_remotepic' => '1','order' => 'edittime desc','pagesize' => '30','max_width' => '550','thumb_height' => '90','thumb_width' => '120','template' => '','htm_list_urlid' => '0','php_list_urlid' => '0','show_html' => '0','htm_item_prefix' => '','htm_item_urlid' => '0','php_item_urlid' => '0');
update_setting($moduleid, $setting);
$db->query("UPDATE {$DT_PRE}module SET listorder=$moduleid WHERE moduleid=$moduleid");
install_file('index', $dir, 1);
install_file('list', $dir, 1);
install_file('show', $dir, 1);
install_file('search', $dir, 1);
if($db->version() > '4.1' && $CFG['db_charset']) {
	$this_sql = " ENGINE=MyISAM DEFAULT CHARSET=".$CFG['db_charset'];
} else {
	$this_sql = " TYPE=MyISAM";
}
$db->query("DROP TABLE IF EXISTS `".$DT_PRE."info_".$moduleid."`");
$db->query("CREATE TABLE `".$DT_PRE."info_".$moduleid."` ( `itemid` bigint(20) unsigned NOT NULL auto_increment,  `catid` smallint(6) unsigned NOT NULL default '0',  `level` tinyint(1) unsigned NOT NULL default '0',  `title` varchar(100) NOT NULL default '',  `style` varchar(50) NOT NULL default '',  `keyword` varchar(255) NOT NULL default '',  `hits` int(10) unsigned NOT NULL default '0',  `thumb` varchar(255) NOT NULL default '',  `username` varchar(20) NOT NULL default '',  `addtime` int(10) unsigned NOT NULL default '0',  `totime` int(10) unsigned NOT NULL default '0',  `areaid` smallint(6) unsigned NOT NULL default '0',  `address` varchar(255) NOT NULL default '',  `name` varchar(30) NOT NULL default '',  `telephone` varchar(20) NOT NULL default '',  `mobile` varchar(20) NOT NULL default '',  `fax` varchar(20) NOT NULL default '',  `email` varchar(50) NOT NULL default '',  `qq` varchar(20) NOT NULL default '',  `msn` varchar(50) NOT NULL default '',  `introduce` varchar(255) NOT NULL default '',  `editor` varchar(25) NOT NULL default '',  `edittime` int(10) unsigned NOT NULL default '0',  `template` varchar(30) NOT NULL default '0',  `status` tinyint(1) NOT NULL default '0',  `listorder` smallint(4) unsigned NOT NULL default '0',  `islink` tinyint(1) unsigned NOT NULL default '0',  `linkurl` varchar(255) NOT NULL default '',  `note` varchar(100) NOT NULL default '',  PRIMARY KEY  (`itemid`),  KEY `keyword` (`keyword`),  KEY `username` (`username`),  KEY `edittime` (`edittime`))".$this_sql." COMMENT='".$modulename."'");

$db->query("DROP TABLE IF EXISTS `".$DT_PRE."info_data_".$moduleid."`");
$db->query("CREATE TABLE `".$DT_PRE."info_data_".$moduleid."` (`itemid` int(10) unsigned NOT NULL default '0',`content` mediumtext NOT NULL,UNIQUE KEY `itemid` (`itemid`))".$this_sql." COMMENT='".$modulename."内容'");
?>