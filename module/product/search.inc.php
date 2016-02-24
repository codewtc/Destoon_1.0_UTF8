<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
if($DT['rewrite'] && $_SERVER["REQUEST_URI"] && $_SERVER['QUERY_STRING']) {
	$url = rewrite($_SERVER["REQUEST_URI"]);
	if($url != $_SERVER["REQUEST_URI"]) dheader($url);;
}
require DT_ROOT.'/include/post.func.php';
//$ddays = array(0, 1, 3, 7, 15, 30);
$thumb = isset($thumb) ? intval($thumb) : 0;
$vip = isset($vip) ? intval($vip) : 0;
$minprice = isset($minprice) ? dround($minprice) : '';
$minprice or $minprice = '';
$maxprice = isset($maxprice) ? dround($maxprice) : '';
$maxprice or $maxprice = '';
$areaid = isset($areaid) ? intval($areaid) : 0;
$fromdate = isset($fromdate) && preg_match("/^([0-9]{8})$/", $fromdate) ? $fromdate : '';
$fromtime = $fromdate ? strtotime($fromdate.' 0:0:0') : 0;
$todate = isset($todate) && preg_match("/^([0-9]{8})$/", $todate) ? $todate : '';
$totime = $todate ? strtotime($todate.' 23:59:59') : 0;
$area_select = ajax_area_select('areaid', '不限地区', $areaid);
$category_select = ajax_category_select('catid', '不限行业', $catid);
$tags = array();
if($DT_QST) {
	if($kw) {
		if(strlen($kw) < $DT['min_kw'] || strlen($kw) > $DT['max_kw']) message('关键词长度应为'.$DT['min_kw'].'-'.$DT['max_kw'].'字符之间', $MOD['linkurl'].'search.php');
		if($DT['search_limit'] && $page == 1) {
			if(($DT_TIME - $DT['search_limit']) < get_cookie('last_search')) message('两次搜索时间间隔应大于'.$DT['search_limit'].'秒', $MOD['linkurl'].'search.php');
			set_cookie('last_search', $DT_TIME);
		}
	}
	$condition = 'status=3';
	if($keyword) $condition .= " AND keyword LIKE '%$keyword%'";
	if($catid) $condition .= ($CATEGORY[$catid]['child']) ? " AND catid IN (".$CATEGORY[$catid]['arrchildid'].")" : " AND catid=$catid";
	if($areaid) $condition .= ($AREA[$areaid]['child']) ? " AND areaid IN (".$AREA[$areaid]['arrchildid'].")" : " AND areaid=$areaid";
	if($thumb) $condition .= " AND thumb!=''";
	if($vip) $condition .= " AND vip>0";
	if($minprice)  $condition .= " AND price>$minprice";
	if($maxprice)  $condition .= " AND price<$maxprice";
	if($fromtime) $condition .= " AND edittime>=$fromtime";
	if($totime) $condition .= " AND edittime<=$totime";
	require MOD_ROOT.'/product.class.php';
	$do = new product($moduleid);
	$tags = $do->get_list($condition, $MOD['order'], 'CACHE');
	if($tags && $keyword) {
		foreach($tags as $k=>$v) {
			$tags[$k]['title'] = str_replace($keyword, '<span class="highlight">'.$keyword.'</span>', $v['title']);
			if($v['introduce']) $tags[$k]['introduce'] = str_replace($keyword, '<span class="highlight">'.$keyword.'</span>', $v['introduce']);
		}
	}
}
$path = $MOD['linkurl'];
$maincat = get_maincat(0, $CATEGORY);
$head_title = ($MOD['seo_title'] ? $MOD['seo_title'] : $MOD['name']).'搜索';
if($kw) $head_title = $kw.' - '.$head_title;
if($areaid) $head_title = area_pos($areaid, ' - ').' - '.$head_title;
$head_keywords = $MOD['seo_keywords'] ? $MOD['seo_keywords'] : $DT['seo_keywords'];
$head_description = $MOD['seo_description'] ? $MOD['seo_description'] : $DT['seo_description'];
include template('search', $module);
?>