<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require MOD_ROOT.'/member.class.php';
$do = new member;
$do->logout();
$forward = $forward ? linkurl($forward, 1) : $CFG['url'];
$msg_code = $URI = '';
if($MOD['passport']) {
	$action = 'logout';
	require DT_ROOT.'/api/'.$MOD['passport'].'.inc.php';
	if($URI) dheader($URI);
}
if($msg_code) $msg_code = '退出成功'.$msg_code;
message($msg_code, $forward);
?>