<?php
/*
	[Destoon B2B System] Copyright (c) 2009 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_DESTOON') or exit('Access Denied');
$filename = DT_ROOT.'/'.$DT['index'].'.'.$DT['file_ext'];
if(!$DT['index_html']) {
	if(is_file($filename)) unlink($filename);
	return false;
}
$destoon_task = "moduleid=1&html=index";
$CATEGORY = cache_read('category-1.php');
$AREA = cache_read('area.php');
$LETTER = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
$CATALOG = $TMP = array();
foreach($CATEGORY as $k=>$v) {
	if($v['letter']) {
		$TMP[$v['letter']][] = $v;
	}
}
foreach($LETTER as $v) {
	$CATALOG[$v] = isset($TMP[$v]) ? $TMP[$v] : array();
}
unset($TMP);
ob_start();
include template('index');
$data = ob_get_contents();
ob_clean();
file_put($filename, $data);
return true;
?>