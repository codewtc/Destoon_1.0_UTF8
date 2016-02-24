<?php 
defined('IN_DESTOON') or exit('Access Denied');
if(!$MOD['show_html'] || !$itemid) return false;
$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid AND status=3 AND islink=0");
if(!$item) return false;
if($MOD['text_data']) {
	$content = text_read($itemid, $moduleid);
} else {
	$content = $db->get_one("SELECT content FROM {$table_data} WHERE itemid=$itemid");
	$content = $content['content'];
}
extract($item);
$adddate = timetodate($addtime, 3);
$editdate = timetodate($edittime, 3);
$fileurl = $linkurl;
$linkurl = linkurl($MOD['linkurl'].$linkurl, 1);
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
$destoon_task = "moduleid=$moduleid&html=show&itemid=$itemid";
$pages = '';
$total = 1;
if(strpos($content, '[pagebreak]') !== false) {
	$contents = explode('[pagebreak]', $content);
	$total = count($contents);	
}
for(; $page <= $total; $page++) {
	$filename = $total == 1 ? DT_ROOT.'/'.$MOD['moduledir'].'/'.$fileurl : DT_ROOT.'/'.$MOD['moduledir'].'/'.itemurl($itemid, $catid, $addtime, $page);
	if($total > 1) {
		$pages = itempages($itemid, $catid, $addtime, $total, $page);
		$content = $contents[$page-1];
	}
	if($MOD['keylink']) $content = keylink($content, $moduleid);
	ob_start();
	include template($template, $module);
	$data = ob_get_contents();
	ob_clean();
	file_put($filename, $data);
	if($page == 1 && $total > 1) file_copy($filename, DT_ROOT.'/'.$MOD['moduledir'].'/'.itemurl($itemid, $catid, $addtime, 0));
}
return true;
?>