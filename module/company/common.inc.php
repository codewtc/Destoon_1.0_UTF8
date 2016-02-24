<?php 
defined('IN_DESTOON') or exit('Access Denied');
define('MOD_ROOT', DT_ROOT.'/module/'.$module);
require MOD_ROOT.'/global.func.php';
$CATEGORY = cache_read('category-1.php');
$ITEMS = cache_read('items-'.$moduleid.'.php');
foreach($CATEGORY as $c) {
	isset($ITEMS[$c['catid']]) or $ITEMS[$c['catid']] = 0;
}
$AREA = cache_read('area.php');
$table = $DT_PRE.'company';
$table_member = $DT_PRE.'member';
?>