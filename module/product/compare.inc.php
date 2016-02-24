<?php 
defined('IN_DESTOON') or exit('Access Denied');
login();
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$DT_URL = $DT_REF;
$itemid or message('请选择需要对比的信息');
is_array($itemid) or message();
$itemid = array_unique(array_map('intval', $itemid));
foreach($itemid as $k=>$v) {
	if(!$v) unset($itemid[$k]);
}
$item_nums = count($itemid);
$item_nums < 9 or message('同时最多选择对比8条信息');
$item_nums > 1 or message('同时最少选择对比2条信息');
$itemid = implode(',', $itemid);
$tags = array();
$result = $db->query("SELECT * FROM {$DT_PRE}company c, {$table} s WHERE s.username=c.username AND s.status=3 AND s.itemid IN ($itemid) ORDER BY s.addtime DESC");
while($r = $db->fetch_array($result)) {
	$r['editdate'] = timetodate($r['edittime'], 3);
	$r['adddate'] = timetodate($r['addtime'], 3);
	//$r['todate'] = timetodate($r['totime'], 3);
	$r['stitle'] = dsubstr($r['title'], 30);
	$r['stitle'] = set_style($r['stitle'], $r['style']);
	$r['userurl'] = userurl($r['username']);
	$r['linkurl'] = $MOD['linkurl'].$r['linkurl'];
	$tags[] = $r;
}
$head_title = '信息对比 - '.($MOD['seo_title'] ? $MOD['seo_title'] : $MOD['name']);
include template('compare', $module);
?>