<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$wap_url = $DT['wap_domain'] ? $DT['wap_domain'] : DT_PATH.'wap/';
$wap_url = str_replace(array('http://', 'https://'), array('', ''), $wap_url);
if(substr($wap_url, -1, 1) == '/') $wap_url = substr($wap_url, 0, -1);
$head_title = $head_keywords = $head_description = 'WAP浏览';
include template('wap', $module);
if($CFG['cache_page']) cache_page();
?>