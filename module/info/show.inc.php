<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$itemid or message('', $MOD['linkurl']);
$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid AND status>2");
$item or message('', $MOD['linkurl']);
if($item['islink']) message('', $item['linkurl']);
if($MOD['show_html'] && is_file(DT_ROOT.'/'.$MOD['moduledir'].'/'.$item['linkurl'])) message('', $MOD['linkurl'].$item['linkurl']);
if($MOD['text_data']) {
	$content = text_read($itemid, $moduleid);
} else {
	$content = $db->get_one("SELECT content FROM {$table_data} WHERE itemid=$itemid");
	$content = $content['content'];
}
extract($item);
$totime = timetodate($totime, 3);
$adddate = timetodate($addtime, 3);
$editdate = timetodate($edittime, 3);
$maincat = get_maincat(0, $CATEGORY);
$head_title = $title.' - '.($MOD['seo_title'] ? $MOD['seo_title'] : $MOD['name']);
$head_keywords = $keyword;
$head_description = $introduce;
$template or $template = 'show';
include template($template, $module);
$db->query("UPDATE {$table} SET hits=hits+1 WHERE itemid=$itemid");
if($CFG['cache_page']) cache_page();
?>