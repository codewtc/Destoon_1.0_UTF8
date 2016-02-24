<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
if($DT['rewrite'] && $_SERVER["REQUEST_URI"] && $_SERVER['QUERY_STRING']) {
	$url = rewrite($_SERVER["REQUEST_URI"]);
	if($url != $_SERVER["REQUEST_URI"]) dheader($url);;
}
require DT_ROOT.'/include/post.func.php';
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
	$condition = 'status=3';
	if($keyword) $condition .= " AND keyword LIKE '%$keyword%'";
	if($catid) $condition .= ($CATEGORY[$catid]['child']) ? " AND catid IN (".$CATEGORY[$catid]['arrchildid'].")" : " AND catid=$catid";
	require MOD_ROOT.'/article.class.php';
	$do = new article($moduleid);
	$tags = $do->get_list($condition, $MOD['order'], 'CACHE');
	if($kw && $tags) {
		foreach($tags as $k=>$v) {
			$tags[$k]['title'] = str_replace($kw, '<span class="highlight">'.$kw.'</span>', $v['title']);
			if($v['introduce']) $tags[$k]['introduce'] = str_replace($kw, '<span class="highlight">'.$kw.'</span>', $v['introduce']);
		}
	}
}
$head_title = ($MOD['seo_title'] ? $MOD['seo_title'] : $MOD['name']).'搜索';
if($kw) $head_title = $kw.' - '.$head_title;
$head_keywords = $MOD['seo_keywords'] ? $MOD['seo_keywords'] : $DT['seo_keywords'];
$head_description = $MOD['seo_description'] ? $MOD['seo_description'] : $DT['seo_description'];
include template('search', $module);
?>