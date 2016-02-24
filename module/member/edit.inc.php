<?php 
defined('IN_DESTOON') or exit('Access Denied');
login();
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require MOD_ROOT.'/member.class.php';
require DT_ROOT.'/include/post.func.php';
$do = new member;
$do->userid = $_userid;
$user = $do->get_one();
if($submit) {
	if($member['password'] && $user['password'] != md5(md5($member['oldpassword']))) message('现有密码错误');
	$member['groupid'] = $user['groupid'];
	$member['email'] = $user['email'];
	$member['company'] = $user['company'];
	$member['domain'] = $user['domain'];
	if($do->edit($member)) {
		message('资料修改成功', $forward);//Not dmsg() For Change PW To LogOut
	} else {
		message($do->errmsg);
	}
} else {
	$COM_TYPE = explode('|', $MOD['com_type']);
	$COM_SIZE = explode('|', $MOD['com_size']);
	$COM_MODE = explode('|', $MOD['com_mode']);
	$MONEY_UNIT = explode('|', $MOD['money_unit']);
	$head_title = '修改资料';
	extract($user);
	$biz_select = category_select('', '选择行业', '', '1', 'onchange="stoinp(this.options[this.selectedIndex].innerHTML, \'business\', \'|\', 1);"');
	$mode_check = dcheckbox($COM_MODE, 'member[mode][]', $mode, 'onclick="check_mode(this);"', 0);
	$d = $db->get_one("SELECT content FROM {$DT_PRE}company_data WHERE userid=$userid");
	$introduce = $d['content'];
	$tab = isset($tab) ? intval($tab) : -1;
	include template('edit', $module);
}
?>