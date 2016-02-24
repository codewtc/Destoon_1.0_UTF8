<?php 
defined('IN_DESTOON') or exit('Access Denied');
$head_title = $MENU['product'][0];
$module = $menuon = 'product';
$moduleid = 7;
$MOD = cache_read('module-'.$moduleid.'.php');
$table = $DT_PRE.'product';
$table_data = $DT_PRE.'product_data';
$TYPE = get_type('product-'.$COM['userid']);
$typeid = isset($typeid) ? intval($typeid) : 0;
$condition = "username='$username' AND status=3";
if($typeid) {
	$condition .= " AND typeid='$typeid'";
}
require DT_ROOT.'/module/product/product.class.php';
$pagesize = 15;
$offset = ($page-1)*$pagesize;
$do = new product($moduleid);
$products = $do->get_list($condition, $MOD['order']);
include template('product', $template);
if($CFG['cache_page']) cache_page();
?>