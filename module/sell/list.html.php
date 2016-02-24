<?php
defined('IN_DESTOON') or exit('Access Denied');
if(!$DT['list_html'] || !$catid || !isset($CATEGORY[$catid])) return false;
$CAT = cache_read('category_'.$catid.'.php');
unset($CAT['moduleid']);
extract($CAT);
$condition = $child ? "catid IN (".$arrchildid.")" : "catid=$catid";
$r = $db->get_one("SELECT COUNT(*) AS total FROM {$table} WHERE $condition AND status=3");
$total = $r['total'];
cache_item($moduleid, $catid, $total);
$maincat = get_maincat($child ? $catid : $parentid, $CATEGORY);
$head_title = $seo_title ? $seo_title : $catname.' - '.($MOD['seo_title'] ? $MOD['seo_title'] : $MOD['name']);
$head_keywords = $seo_keywords ? $seo_keywords : $MOD['seo_keywords'];
$head_description = $seo_description ? $seo_description : $MOD['seo_description'];
$template or $template = 'list';
$total = ceil($total/$MOD['pagesize']);
$total = $total ? $total : 1;
if(isset($fid) && isset($num)) {
	$page = $fid;
	$topage = $fid + $num;
	$total = $topage < $total ? $topage : $total;
}
for(; $page <= $total; $page++) {
	$destoon_task = "moduleid=$moduleid&html=list&catid=$catid&page=$page";
	$filename = DT_ROOT.'/'.$MOD['moduledir'].'/'.listurl($moduleid, $catid, $page, $CATEGORY, $MOD);
	ob_start();
	include template($template, $module);
	$data = ob_get_contents();
	ob_clean();
	file_put($filename, $data);
	if($page == 1) file_copy($filename, DT_ROOT.'/'.$MOD['moduledir'].'/'.listurl($moduleid, $catid, 0, $CATEGORY, $MOD));
}
return true;
?>