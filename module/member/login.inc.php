<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require MOD_ROOT.'/member.class.php';
require DT_ROOT.'/include/post.func.php';
$do = new member;
$forward = $forward ? linkurl($forward, 1) : $CFG['url'];
$action = 'login';
if($submit) {
	captcha($captcha, $MOD['captcha_login']);
	if(!$username) message('请输入用户名');
	if(!$password) message('请输入密码');
	if(is_email($username)) {
		$r = $db->get_one("SELECT username FROM {$DT_PRE}member WHERE email='$username' limit 0,1");
		$r or message('邮件地址不存在');
		$username = $r['username'];
	}
	$cookietime = isset($cookietime) ? $cookietime : 0;
	$msg_code = '';
	if($MOD['passport'] == 'uc') require DT_ROOT.'/api/'.$MOD['passport'].'.inc.php';
	$user = $do->login($username, $password, $cookietime);
	if($user) {
		if($MOD['passport'] && $MOD['passport'] != 'uc') {
			$URI = '';
			$user['password'] = is_md5($password) ? $password : md5($password);//Once MD5
			if($MOD['passport_charset'] != $CFG['charset']) $user = convert($user, $CFG['charset'], $MOD['passport_charset']);
			extract($user);
			require DT_ROOT.'/api/'.$MOD['passport'].'.inc.php';
			if($URI) dheader($URI);
		}
		if($msg_code) $msg_code = '登录成功'.$msg_code;
		message($msg_code, $forward);
	} else {
		message($do->errmsg);
	}
} else {
	$head_title = '会员登录';
	isset($username) or $username = $_username;
	include template('login', $module);
}
?>