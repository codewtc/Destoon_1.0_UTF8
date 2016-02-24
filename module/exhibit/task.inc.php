<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
if($html == 'show') {
	$itemid or exit;
	$r = $db->get_one("SELECT hits,fromtime,totime FROM {$table} WHERE itemid=$itemid AND status=3");
	$r or exit;
	echo '$("hits").innerHTML = '.$r['hits'].';';
	$db->query("UPDATE {$table} SET hits=hits+1 WHERE itemid=$itemid");
	$process_src = SKIN_PATH.'image/exh_p'.get_process($r['fromtime'], $r['totime']).'.gif'; 
	echo '$("process").src = \''.$process_src.'\';';
	if($MOD['show_html'] && $DT_TIME - @filemtime(DT_ROOT.'/'.$MOD['moduledir'].'/'.$r['linkurl']) > $task_item) tohtml('show', $module);
} else if($html == 'list') {
	$catid or exit;
	if($MOD['list_html'] && $DT_TIME - @filemtime(DT_ROOT.'/'.$MOD['moduledir'].'/'.listurl($moduleid, $catid, $page, $CATEGORY, $MOD)) > $task_list) {
		$fid = $page;
		$num = 3;
		tohtml('list', $module);
	}
} else if($html == 'index') {
	if($MOD['rss_num'] && $DT_TIME - @filemtime(DT_ROOT.'/'.$MOD['moduledir'].'/rss.xml') > $MOD['rss_time']) tohtml('rss', $module);
}
?>