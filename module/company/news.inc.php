<?php 
defined('IN_DESTOON') or exit('Access Denied');
$head_title = $MENU['news'][0];
$menuon = 'news';
require DT_ROOT.'/module/member/news.class.php';
$do = new news();
if($itemid) {
	$do->itemid = $itemid;
	$news = $do->get_one("AND n.username='$username' AND n.status=3");
	$news or message('', $homepage);
	$news['editdate'] = timetodate($news['addtime'], 5);
	$db->query("UPDATE {$DT_PRE}news SET hits=hits+1 WHERE itemid=$itemid ");
} else {
	$pagesize = 10;
	$offset = ($page-1)*$pagesize;
	$newss = $do->get_list("username='$username' AND status=3");
}
include template('news', $template);
if($CFG['cache_page']) cache_page();
?>