<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$catid or message();
isset($CATEGORY[$catid]) or message();
if($DT['list_html']) {
	$html_file = listurl($moduleid, $catid, $page, $CATEGORY, $MOD);
	if(is_file(DT_ROOT.'/'.$MOD['moduledir'].'/'.$html_file)) dheader($MOD['linkurl'].$html_file);
}
$CAT = cache_read('category_'.$catid.'.php');
unset($CAT['moduleid']);
extract($CAT);
$maincat = get_maincat($child ? $catid : $parentid, $CATEGORY);
$head_title = $seo_title ? $seo_title : $catname.' - '.($MOD['seo_title'] ? $MOD['seo_title'] : $MOD['name']);
$head_keywords = $seo_keywords ? $seo_keywords : $MOD['seo_keywords'];
$head_description = $seo_description ? $seo_description : $MOD['seo_description'];
$template or $template = 'list';
include template($template, $module);
if($CFG['cache_page']) cache_page();
?>