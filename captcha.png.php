<?php
/*
	[Destoon B2B System] Copyright (c) 2009 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
require 'common.inc.php';
error_reporting(0);
if(!check_referer()) exit;
$session = new dsession();
require DT_ROOT.'/include/captcha.class.php';
$do = new captcha;
if($action == crypt_action('question')) {
	$do->question();
} else if($action == crypt_action('image')) {
	$do->image();
}
?>