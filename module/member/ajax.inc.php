<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require DT_ROOT.'/include/post.func.php';
(isset($value) && $value) or exit;
if(strtolower($CFG['charset']) != 'utf-8') $value = convert($value);
require MOD_ROOT.'/member.class.php';
$do = new member;
if(isset($userid) && $userid) $do->userid = $userid;
$error_img = '<img src="'.SKIN_PATH.'image/check_error.gif" align="absmiddle"/> ';
switch($action) {
	case 'username':
		if(!$do->is_username($value)) echo $error_img.$do->errmsg;
	break;
	case 'password':
		if(!$do->is_password($value, $value)) echo $error_img.$do->errmsg;
	break;
	case 'email':
		if(!is_email($value)) exit($error_img.'邮件格式不正确');
		if($do->email_exists($value)) echo $error_img.'邮件地址已经存在';
	break;
	case 'company':
		if($do->company_exists($value)) echo $error_img.'公司名称已经存在';
	break;
	case 'get_company':
		$user = $do->get_one($value);
		if($user) {
			echo '<a href="'.$user['linkurl'].'" target="_blank" class="t">'.$user['company'].'</a>'.( $user['vip'] ? ' <img src="'.SKIN_PATH.'image/vip.gif" align="absmiddle"/> <img src="'.SKIN_PATH.'image/vip_'.$user['vip'].'.gif" align="absmiddle"/>' : '');
		} else {
			echo '1';
		}
	break;
}
?>