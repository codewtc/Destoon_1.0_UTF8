<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$TYPE = get_type('announce', 1);
require MOD_ROOT.'/announce.class.php';
$do = new announce();
$typeid = isset($typeid) ? intval($typeid) : 0;
if($itemid) {
	$do->itemid = $itemid;
	$r = $do->get_one();
	$r or message('', DT_PATH);
	extract($r);
	$editdate = timetodate($addtime, 5);
	$fromdate = $fromtime ? timetodate($fromtime, 3) : '不限';
	$todate = $totime ? timetodate($totime, 3) : '不限';
	$head_title = $head_keywords = $head_description = $title.' - 公告中心';
	$template or $template = 'announce';
	include template($template, $module);
	$db->query("UPDATE {$DT_PRE}announce SET hits=hits+1 WHERE itemid=$itemid");
} else {
	$head_title = $head_keywords = $head_description = '公告中心';
	$condition = '1';
	if($typeid) $condition .= " AND typeid=$typeid";
	$announces = $do->get_list($condition, 'listorder DESC,itemid DESC');
	include template('announce', $module);
}
if($CFG['cache_page']) cache_page();
?>