<?php
/*
	[Destoon B2B System] Copyright (c) 2009 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
require './common.inc.php';
if($DT['index_html']) {	
	$html_file = DT_ROOT.'/'.$DT['index'].'.'.$DT['file_ext'];
	if(!is_file($html_file)) tohtml('index');
	include($html_file);
	exit;
}
$destoon_task = '';
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
include template('index');
?>