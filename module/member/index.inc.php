<?php 
defined('IN_DESTOON') or exit('Access Denied');
login();
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require MOD_ROOT.'/member.class.php';
require DT_ROOT.'/include/post.func.php';
$do = new member;
if($submit) {
	$note = htmlspecialchars($note);
	$db->query("UPDATE {$DT_PRE}company_data SET mynote='$note' WHERE userid=$_userid");
	dmsg('更新成功', $MODULE[2]['linkurl']);
} else {
	$head_title = '';
	$do->userid = $_userid;
	extract($do->get_one());
	$logintime = timetodate($logintime, 5);
	$regtime = timetodate($regtime, 5);
	$userurl = userurl($_username);
	$note = $db->get_one("SELECT mynote FROM {$DT_PRE}company_data WHERE userid=$_userid");
	$note = $note['mynote'];
	$trade = $db->get_one("SELECT COUNT(itemid) AS num FROM {$DT_PRE}finance_trade WHERE seller='$_username' AND status=0");
	$trade = $trade['num'];
	include template('index', $module);
}
?>