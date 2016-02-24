<?php 
defined('IN_DESTOON') or exit('Access Denied');
if($_userid) message('', DT_PATH);
require DT_ROOT.'/module/'.$module.'/common.inc.php';
if(!$MOD['enable_register']) message('管理员关闭了用户注册', DT_PATH);
if($MOD['iptimeout']) {
	$timeout = $DT_TIME - $MOD['iptimeout']*3600;
	$r = $db->get_one("SELECT userid FROM {$DT_PRE}member WHERE regip='$DT_IP' AND regtime>'$timeout' ");
	if($r) message('同一IP'.$MOD['iptimeout'].'小时内只能注册一次', DT_PATH);
}
require DT_ROOT.'/include/post.func.php';
require MOD_ROOT.'/member.class.php';
$do = new member;
if($submit) {
	captcha($captcha, $MOD['captcha_register']);
	$member['groupid'] = $MOD['checkuser'] ? 4 : 5;
	$member['introduce'] = $member['thumb'] = $member['banner'] = '';
	if($do->add($member)) {
		$username = $member['username'];
		if($MOD['checkuser'] == 2) {
			$auth = $do->mk_auth($username);
			$authurl = linkurl($MOD['linkurl'], 1).'send.php?action=check&auth='.$auth;
			$title = $DT['sitename'].'用户注册激活信';
			$content = ob_template('mail_check', $module);
			send_mail($member['email'], $title, $content);
		}
		if($MOD['checkuser'] == 0) {
			if($MOD['welcome'] > 0) {
				$title = '欢迎加入'.$DT['sitename'];
				$content = ob_template('mail_welcome', $module);
				if($MOD['welcome'] == 1 || $MOD['welcome'] == 3) send_message($username, $title, $content);
				if($MOD['welcome'] == 2 || $MOD['welcome'] == 3) send_mail($member['email'], $title, $content);
			}
		}
		$msgcode = 'R'.$MOD['checkuser'];
		include template('msg', $module);
	} else {
		message($do->errmsg);
	}
} else {
	$COM_TYPE = explode('|', $MOD['com_type']);
	$COM_SIZE = explode('|', $MOD['com_size']);
	$COM_MODE = explode('|', $MOD['com_mode']);
	$MONEY_UNIT = explode('|', $MOD['money_unit']);
	$biz_select = category_select('', '选择行业', '', '1', 'onchange="stoinp(this.options[this.selectedIndex].innerHTML, \'business\', \'|\', 1);"');
	$mode_check = dcheckbox($COM_MODE, 'member[mode][]', '', 'onclick="check_mode(this);"', 0);
	isset($auth) or $auth = '';
	$username = $password = $email = '';
	if($auth) {
		$auth = dcrypt($auth, 1);
		$auth = explode('|', $auth);
		$username = $auth[0];
		$password = $auth[1];
		$email = $auth[2];
	}
	$head_title = '会员注册';
	include template('register', $module);
}
?>