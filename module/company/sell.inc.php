<?php 
defined('IN_DESTOON') or exit('Access Denied');
$head_title = $MENU['sell'][0];
$module = $menuon = 'sell';
$moduleid = 5;
$MOD = cache_read('module-'.$moduleid.'.php');
$table = $DT_PRE.'sell';
$table_data = $DT_PRE.'sell_data';
require DT_ROOT.'/module/sell/sell.class.php';
$pagesize = 5;
$offset = ($page-1)*$pagesize;
$do = new sell($moduleid);
$sells = $do->get_list("username='$username' AND status=3", $MOD['order']);
include template('sell', $template);
if($CFG['cache_page']) cache_page();
?>