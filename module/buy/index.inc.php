<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$typeid = isset($typeid) ? ($typeid === '' ? -1 : intval($typeid)) : -1;
($typeid >=0 && isset($TYPE[$typeid])) or $typeid = -1;
($catid && isset($CATEGORY[$catid])) or $catid = 0;
$dtype = $typeid >= 0 ? " and typeid=$typeid" : '';
$maincat = get_maincat(0, $CATEGORY);
$head_title = $MOD['seo_title'] ? $MOD['seo_title'] : $MOD['name'];
if($catid) $head_title = $CATEGORY[$catid]['catname'].' - '.$head_title;
if($typeid > 0) $head_title = $TYPE[$typeid].' - '.$head_title;
$head_keywords = $MOD['seo_keywords'] ? $MOD['seo_keywords'] : $DT['seo_keywords'];
$head_description = $MOD['seo_description'] ? $MOD['seo_description'] : $DT['seo_description'];
$template = $MOD['template'] ? $MOD['template'] : 'index';
include template($template, $module);
if($MOD['rss_num'] && $DT_TIME - @filemtime(DT_ROOT.'/'.$MOD['moduledir'].'/rss.xml') > $MOD['rss_time']) tohtml('rss', $module);
if($CFG['cache_page']) cache_page();
?>