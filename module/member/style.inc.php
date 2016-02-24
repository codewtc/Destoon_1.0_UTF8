<?php 
defined('IN_DESTOON') or exit('Access Denied');
login();
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$MYGROUP['homepage'] or message('您所在的会员组没有此权限', $MOD['linkurl']);
require DT_ROOT.'/include/post.func.php';
require MOD_ROOT.'/style.class.php';
$do = new style();
if($itemid) {
	$do->itemid = $itemid;
	$r = $do->get_one();
	$r or message();
	if($r['groupid']) {
		$groupids = explode(',', $r['groupid']);
		if(!in_array($_groupid, $groupids)) message('抱歉！此模板未对您所在的会员组开放');
	}
	$db->query("UPDATE {$DT_PRE}company SET template='$r[template]',skin='$r[skin]' WHERE userid='$_userid'");
	dmsg('模板启用成功', $forward);
} else {
	$c = $db->get_one("SELECT skin,linkurl FROM {$DT_PRE}company WHERE userid='$_userid'");
	$c['skin'] or $c['skin'] = 'homepage';
	$styles = $do->get_list('1', 'listorder DESC,addtime DESC');
}
$head_title = '模板设置';
include template('style', $module);
?>