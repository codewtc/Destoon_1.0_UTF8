<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
if($DT['rewrite'] && $_SERVER["REQUEST_URI"] && $_SERVER['QUERY_STRING']) {
	$url = rewrite($_SERVER["REQUEST_URI"]);
	if($url != $_SERVER["REQUEST_URI"]) dheader($url);;
}
require DT_ROOT.'/include/post.func.php';
$process = isset($process) ? intval($process) : 0;
$fromdate = isset($fromdate) && preg_match("/^([0-9]{8})$/", $fromdate) ? $fromdate : '';
$fromtime = $fromdate ? strtotime($fromdate.' 0:0:0') : 0;
$todate = isset($todate) && preg_match("/^([0-9]{8})$/", $todate) ? $todate : '';
$totime = $todate ? strtotime($todate.' 23:59:59') : 0;
$category_select = category_select('catid', '不限栏目', $catid, $moduleid);
$tags = array();
if($DT_QST) {
	if($kw) {
		if(strlen($kw) < $DT['min_kw'] || strlen($kw) > $DT['max_kw']) message('关键词长度应为'.$DT['min_kw'].'-'.$DT['max_kw'].'字符之间', $MOD['linkurl'].'search.php');
		if($DT['search_limit'] && $page == 1) {
			if(($DT_TIME - $DT['search_limit']) < get_cookie('last_search')) message('两次搜索时间间隔应大于'.$DT['search_limit'].'秒', $MOD['linkurl'].'search.php');
			set_cookie('last_search', $DT_TIME);
		}
	}
	$condition = 'status>2';
	if($keyword) $condition .= " AND keyword LIKE '%$keyword%'";
	if($catid) $condition .= ($CATEGORY[$catid]['child']) ? " AND catid IN (".$CATEGORY[$catid]['arrchildid'].")" : " AND catid=$catid";
	if($fromtime) $condition .= " AND fromtime>=$fromtime";
	if($totime) $condition .= " AND fromtime<=$totime";
	if($process == 1) {
		$condition .= " AND fromtime>$DT_TIME";
	} else if($process == 2) {
		$condition .= " AND fromtime<$DT_TIME AND totime>$DT_TIME";
	} else if($process == 3) {
		$condition .= " AND totime<$DT_TIME";
	}
	require MOD_ROOT.'/exhibit.class.php';
	$do = new exhibit($moduleid);
	$tags = $do->get_list($condition, $MOD['order'], 'CACHE');
	if($kw) $head_title = $kw.' - '.$head_title;
	if($keyword && $tags) {
		foreach($tags as $k=>$v) {
			$tags[$k]['title'] = str_replace($kw, '<span class="highlight">'.$kw.'</span>', $v['title']);
		}
	}
}
$path = $MOD['linkurl'];
$maincat = get_maincat(0, $CATEGORY);
$head_title = ($MOD['seo_title'] ? $MOD['seo_title'] : $MOD['name']).'搜索';
if($kw) $head_title = $kw.' - '.$head_title;
$head_keywords = $MOD['seo_keywords'] ? $MOD['seo_keywords'] : $DT['seo_keywords'];
$head_description = $MOD['seo_description'] ? $MOD['seo_description'] : $DT['seo_description'];
include template('search', $module);
?>