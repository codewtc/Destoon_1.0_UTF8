<?php 
defined('IN_DESTOON') or exit('Access Denied');
define('MOD_ROOT', DT_ROOT.'/module/'.$module);
if(!defined('DT_ADMIN') && $submit) {
	check_post() or message(); //safe
}
require MOD_ROOT.'/global.func.php';
$GROUP = cache_read('group.php');
$AREA = cache_read('area.php');
$CATEGORY = cache_read('category-1.php');
$table = $DT_PRE.'member';
$table_company = $DT_PRE.'company';
$MYGROUP = cache_read('group-'.$_groupid.'.php');
isset($MYGROUP['homepage']) or $MYGROUP['homepage'] = 0;
$MYMODS = array();
if(isset($MYGROUP['moduleids']) && $MYGROUP['moduleids']) {
	$MYMODS = explode(',', $MYGROUP['moduleids']);
}
?>