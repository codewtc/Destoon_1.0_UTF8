<?php
/*
	[Destoon B2B System] Copyright (c) 2009 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
if($_SERVER['QUERY_STRING'] && strpos($_SERVER['QUERY_STRING'], '$') === false) {
	$exprise = $_GET['tag_expires'] ? $_GET['tag_expires'] : 0;
	foreach($_GET as $k=>$v) { unset($$k); }
	$_GET = array();
	require './common.inc.php';
	$DT_REF or exit('document.write("'.errmsg.'");');
	if($DT['js_domain']) {
		$tmp = parse_url($DT_REF);
		$host = $tmp['host'];
		$tmp = explode('|', $DT['js_domain']);
		foreach($tmp as $v) {
			if(strpos($v, $host) === false) exit('document.write("'.errmsg.'");');
		}		
	} else {
		if(strpos($DT_REF, $CFG['url']) === false) exit('document.write("'.errmsg.'");');
	}
	ob_start();
	tag($_SERVER['QUERY_STRING'], $exprise);
	$data = ob_get_contents();
	ob_clean();
	echo 'document.write(\''.dtrim($data).'\');';
}
?>