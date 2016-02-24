<?php
/*
	[Destoon B2B System] Copyright (c) 2009 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_DESTOON') or exit('Access Denied');
$AREA = cache_read('area.php');
$table = $DT_PRE.'company';
$userid = isset($userid) ? intval($userid) : 0;
$username = isset($username) ? trim($username) : '';
if($userid || $username) {
	if($_userid) {
		$GROUP = cache_read('group-'.$_groupid.'.php');
		if(!isset($GROUP['vip']) || $GROUP['vip'] < 1) wap_msg('抱歉,仅限'.VIP.'会员浏览');
	} else {
		wap_msg('请先登录');
	}
	$sql = $userid ? "userid=$userid" : "username='$username'";
	$item = $db->get_one("SELECT * FROM {$table} WHERE $sql");
	$item or wap_msg('公司不存在');
	extract($item);
	$content = $db->get_one("SELECT content FROM {$DT_PRE}company_data WHERE userid=$userid");
	$content = $content['content'];
	$content = strip_tags($content);
	$content = preg_replace("/\&([^;]+);/i", '', $content);
	$contentlength = strlen($content);
	if($contentlength > $maxlength) {
		$start = ($page-1)*$maxlength;
		$content = dsubstr($content, $maxlength, '', $start);
		$pages = wap_pages($contentlength, $page, $maxlength);
	}
	$content = nl2br($content);
	if($page == 1) $db->query("UPDATE {$table} SET hits=hits+1 WHERE userid=$userid");
	$head_title = $company.' - '.$MOD['name'].' - '.$head_title;
} else {
	$head_title = $MOD['name'].' - '.$head_title;
	if($kw) $head_title = $kw.' - '.$head_title;
	$keyword = $kw ? str_replace(array(' ', '*'), array('%', '%'), $kw) : '';
	$condition = "groupid>4";
	if($keyword) $condition .= " AND keyword LIKE '%$keyword%'";
	if($areaid) $condition .= ($AREA[$areaid]['child']) ? " AND areaid IN (".$AREA[$areaid]['arrchildid'].")" : " AND areaid=$areaid";
	$r = $db->get_one("SELECT COUNT(userid) AS num FROM {$table} WHERE $condition");
	$pages = wap_pages($r['num'], $page, $pagesize);
	$lists = array();
	$result = $db->query("SELECT userid,catid,company,areaid,vip FROM {$table} WHERE $condition ORDER BY vip DESC,userid DESC LIMIT $offset,$pagesize");
	while($r = $db->fetch_array($result)) {
		//$r['editdate'] = timetodate($r['addtime'], 2);
		$r['area'] = area_pos($r['areaid'], '/', 2);
		//$r['catname'] = $CATEGORY[$r['catid']]['catname'];
		$lists[] = $r;
	}
}
include template('company', 'wap');
?>