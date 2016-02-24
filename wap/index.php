<?php
/*
	[Destoon B2B System] Copyright (c) 2009 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
define('DT_MEMBER', true);
define('DT_WAP', true);
require '../common.inc.php';
if(preg_match('/(mozilla|m3gate|winwap|openwave)/i', $_SERVER['HTTP_USER_AGENT'])) dheader($MODULE[3]['linkurl'].'wap.php');
header("Content-type:text/vnd.wap.wml; charset=utf-8");
if(!$DT['wap']) wap_msg('系统未开启WAP浏览');
$wap_modules = array('member', 'sell', 'buy', 'product', 'company', 'exhibit', 'article', 'info');
$pagesize = $DT['wap_pagesize'] ? $DT['wap_pagesize'] : 10;
$offset = ($page-1)*$pagesize;
$maxlength = $DT['wap_maxlength'] ? $DT['wap_maxlength'] : 200;
$kw = $kw ? trim($kw) : '';
$pages = '';
$now = timetodate($DT_TIME, 'm/d H:i');
$areaid = isset($areaid) ? intval($areaid) : 0;
$head_title = $DT['sitename'];
if(strtolower($CFG['charset'] != 'utf-8') && $kw) {
	$kw = convert($kw, 'utf-8', $CFG['charset']);
	$DT_URL = convert(urldecode($DT_URL), 'utf-8', $CFG['charset']);
}
require './global.func.php';
if(in_array($module, $wap_modules)) {
	include './'.$module.'.inc.php';
} else {
	$WAP_MODULE = array();
	foreach($MODULE as $v) {
		if(in_array($v['module'], $wap_modules) && $v['module'] != 'member') $WAP_MODULE[] = $v;
	}
	include template('index', 'wap');
}
wap_output();
?>