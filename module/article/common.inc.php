<?php 
defined('IN_DESTOON') or exit('Access Denied');
define('MOD_ROOT', DT_ROOT.'/module/'.$module);
require MOD_ROOT.'/global.func.php';
$CATEGORY = cache_read('category-'.$moduleid.'.php');
$ITEMS = cache_read('items-'.$moduleid.'.php');
foreach($CATEGORY as $c) {
	isset($ITEMS[$c['catid']]) or $ITEMS[$c['catid']] = 0;
}
$table = $DT_PRE.'article_'.$moduleid;
$table_data = $DT_PRE.'article_data_'.$moduleid;
?>