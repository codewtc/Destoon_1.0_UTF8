<?php 
defined('IN_DESTOON') or exit('Access Denied');
if(!$MOD['show_html'] || !$itemid) return false;
$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid AND status>2 AND islink=0");
if(!$item) return false;
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
$fileurl = $linkurl;
$linkurl = linkurl($MOD['linkurl'].$linkurl, 1);
$maincat = get_maincat(0, $CATEGORY);
$status = '';
$head_title = $title.' - '.($MOD['seo_title'] ? $MOD['seo_title'] : $MOD['name']);
$head_keywords = $keyword;
$head_description = $introduce;
$template or $template = 'show';
$destoon_task = "moduleid=$moduleid&html=show&itemid=$itemid";
ob_start();
include template($template, $module);
$data = ob_get_contents();
ob_clean();
file_put(DT_ROOT.'/'.$MOD['moduledir'].'/'.$fileurl, $data);
return true;
?>