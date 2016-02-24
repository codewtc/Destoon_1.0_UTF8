<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$itemid or message('', $MOD['linkurl']);
$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid AND status=3");
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
if($page == 1) $db->query("UPDATE {$table} SET hits=hits+1 WHERE itemid=$itemid");
$adddate = timetodate($addtime, 3);
$editdate = timetodate($edittime, 3);
$pages = '';
if(strpos($content, '[pagebreak]') !== false) {
	$content = explode('[pagebreak]', $content);
	$total = count($content);
	$pages = itempages($itemid, $catid, $addtime, $total, $page);
	$content = $content[$page-1];
}
if($MOD['keylink']) $content = keylink($content, $moduleid);
$head_title = $title.' - '.($MOD['seo_title'] ? $MOD['seo_title'] : $MOD['name']);
$head_keywords = $keyword;
$head_description = $introduce ? $introduce : $title;
if($tag) {
	$tag = explode(' ', $tag);
	$keyword = (isset($tag[0]) && strlen($tag[0]) < 20) ? $tag[0] : $CATEGORY[$catid]['catname'];
} else {
	$keyword = $CATEGORY[$catid]['catname'];
}
$template or $template = 'show';
include template($template, $module);
if($CFG['cache_page']) cache_page();
?>