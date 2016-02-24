<?php 
defined('IN_DESTOON') or exit('Access Denied');
if(!$MOD['show_html'] || !$itemid) return false;
$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid AND status>2");
if(!$item) return false;
if($MOD['text_data']) {
	$content = text_read($itemid, $moduleid);
} else {
	$content = $db->get_one("SELECT content FROM {$table_data} WHERE itemid=$itemid");
	$content = $content['content'];
}
extract($item);
$member = array();
$user_status = 0;
$adddate = timetodate($addtime, 3);
$editdate = timetodate($edittime, 3);
$todate = timetodate($totime, 3);
$fileurl = $linkurl;
$linkurl = linkurl($MOD['linkurl'].$linkurl, 1);
$thumbs = $albums = array();
$thumbs[] = $thumb ? $thumb : SKIN_PATH.'image/nopic50.gif';
$thumbs[] = $thumb1 ? $thumb1 : SKIN_PATH.'image/nopic50.gif';
$thumbs[] = $thumb2 ? $thumb2 : SKIN_PATH.'image/nopic50.gif';
$albums[] = $thumb ? str_replace('.thumb.'.file_ext($thumb), '', $thumb) : SKIN_PATH.'image/nopic200.gif';
$albums[] = $thumb1 ? str_replace('.thumb.'.file_ext($thumb1), '', $thumb1) : SKIN_PATH.'image/nopic200.gif';
$albums[] = $thumb2 ? str_replace('.thumb.'.file_ext($thumb2), '', $thumb2) : SKIN_PATH.'image/nopic200.gif';
$head_title = $title.' - '.($MOD['seo_title'] ? $MOD['seo_title'] : $MOD['name']);
$head_keywords = $keyword;
$head_description = $introduce ? $introduce : $title;
$template or $template = 'show';
$destoon_task = "moduleid=$moduleid&html=show&itemid=$itemid";
ob_start();
include template($template, $module);
$data = ob_get_contents();
ob_clean();
file_put(DT_ROOT.'/'.$MOD['moduledir'].'/'.$fileurl, $data);
return true;
?>