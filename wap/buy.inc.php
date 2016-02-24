<?php
/*
	[Destoon B2B System] Copyright (c) 2009 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_DESTOON') or exit('Access Denied');
$CATEGORY = cache_read('category-1.php');
$AREA = cache_read('area.php');
$table = $DT_PRE.'buy';
$table_data = $DT_PRE.'buy_data';
if($itemid) {
	$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid AND status=3");
	$item or wap_msg('信息不存在');
	extract($item);
	if($MOD['text_data']) {
		$content = text_read($itemid, $moduleid);
	} else {
		$content = $db->get_one("SELECT content FROM {$table_data} WHERE itemid=$itemid");
		$content = $content['content'];
	}
	$content = strip_tags($content);
	$content = preg_replace("/\&([^;]+);/i", '', $content);
	$contentlength = strlen($content);
	if($contentlength > $maxlength) {
		$start = ($page-1)*$maxlength;
		$content = dsubstr($content, $maxlength, '', $start);
		$pages = wap_pages($contentlength, $page, $maxlength);
	}
	$content = nl2br($content);
	$editdate = timetodate($addtime, 5);
	if($page == 1) $db->query("UPDATE {$table} SET hits=hits+1 WHERE itemid=$itemid");
	$head_title = $title.' - '.$MOD['name'].' - '.$head_title;
} else {
	$head_title = $MOD['name'].' - '.$head_title;
	if($kw) $head_title = $kw.' - '.$head_title;
	$keyword = $kw ? str_replace(array(' ', '*'), array('%', '%'), $kw) : '';
	$condition = "status=3 AND totime>$DT_TIME";
	if($keyword) $condition .= " AND keyword LIKE '%$keyword%'";
	if($catid) $condition .= ($CATEGORY[$catid]['child']) ? " AND catid IN (".$CATEGORY[$catid]['arrchildid'].")" : " AND catid=$catid";
	if($areaid) $condition .= ($AREA[$areaid]['child']) ? " AND areaid IN (".$AREA[$areaid]['arrchildid'].")" : " AND areaid=$areaid";
	$r = $db->get_one("SELECT COUNT(itemid) AS num FROM {$table} WHERE $condition");
	$pages = wap_pages($r['num'], $page, $pagesize);
	$lists = array();
	$result = $db->query("SELECT itemid,catid,title,addtime,areaid,vip FROM {$table} WHERE $condition ORDER BY editdate DESC,vip DESC,addtime DESC LIMIT $offset,$pagesize");
	while($r = $db->fetch_array($result)) {
		$r['editdate'] = timetodate($r['addtime'], 2);
		$r['area'] = area_pos($r['areaid'], '/', 2);
		$r['catname'] = $CATEGORY[$r['catid']]['catname'];
		$lists[] = $r;
	}
}
include template('buy', 'wap');
?>