<?php 
defined('IN_DESTOON') or exit('Access Denied');
if(!$itemid) return false;
$_item = $db->get_one("SELECT * FROM {$DT_PRE}webpage WHERE itemid=$itemid AND islink=0");
if(!$_item) return false;
extract($_item);
$head_title = $seo_title ? $seo_title : $title;
$head_keywords = $seo_keywords;
$head_description = $seo_description;
$template or $template = 'webpage';
$destoon_task = '';
ob_start();
include template($template, $module);
$data = ob_get_contents();
ob_clean();
file_put(DT_ROOT.'/'.$linkurl, $data);
return true;
?>