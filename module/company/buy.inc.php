<?php 
defined('IN_DESTOON') or exit('Access Denied');
$have_right = false;
if($_userid) {
	$MYGROUP = cache_read('group-'.$_groupid.'.php');
	if(isset($MYGROUP['buyerinfo']) && $MYGROUP['buyerinfo']) $have_right = true;
}
$have_right or message('您没有权限查看求购信息，请升级为'.VIP, $MODULE[2]['linkurl'].'vip.php');
$head_title = $MENU['buy'][0];
$module = $menuon = 'buy';
$moduleid = 6;
$MOD = cache_read('module-'.$moduleid.'.php');
$table = $DT_PRE.'buy';
$table_data = $DT_PRE.'buy_data';
require DT_ROOT.'/module/buy/buy.class.php';
$pagesize = 10;
$offset = ($page-1)*$pagesize;
$do = new buy($moduleid);
$buys = $do->get_list("username='$username' AND status=3", $MOD['order']);
include template('buy', $template);
?>