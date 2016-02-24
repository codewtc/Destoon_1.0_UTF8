<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
if($html == 'show') {
	$itemid or exit;
	$r = $db->get_one("SELECT hits,linkurl,username FROM {$table} WHERE itemid=$itemid AND status>2");
	$r or exit;
	echo '$("hits").innerHTML = '.$r['hits'].';';
	$db->query("UPDATE {$table} SET hits=hits+1 WHERE itemid=$itemid");
	if($_userid) {
		$MYGROYP = cache_read('group-'.$_groupid.'.php');
		if(isset($MYGROYP['buyerinfo']) && $MYGROYP['buyerinfo']) {
			$username = $r['username'];
			$member = $db->get_one("SELECT c.company,c.areaid,c.address,c.postcode,c.telephone,c.fax,c.mail,c.linkurl,c.vip,c.fromtime,c.validated,c.validator,m.truename,m.gender,m.career,m.msn,m.qq FROM {$DT_PRE}company c,{$DT_PRE}member m WHERE m.userid=c.userid AND m.username='$username'");
			$member['gender'] = $member['gender'] == 1 ? '先生' : '女士';
			$member['year'] = $member['fromtime'] ? intval(date('Y', $DT_TIME)-date('Y', $member['fromtime']))+1  : 1;
			$user_status = 3;
		} else {
			$user_status = 2;
		}
	} else {
		$user_status = 1;
	}
	$contact = strip_nr(ob_template('contact', $module));
	echo '$("contact").innerHTML = \''.$contact.'\';';
	if($MOD['show_html'] && $DT_TIME - @filemtime(DT_ROOT.'/'.$MOD['moduledir'].'/'.$r['linkurl']) > $task_item) tohtml('show', $module);
} else if($html == 'list') {
	$catid or exit;
	if($DT['list_html'] && $DT_TIME - @filemtime(DT_ROOT.'/'.$MOD['moduledir'].'/'.listurl($moduleid, $catid, $page, $CATEGORY, $MOD)) > $task_list) {
		$fid = $page;
		$num = 3;
		tohtml('list', $module);
	}
} else if($html == 'index') {
	if($MOD['rss_num'] && $DT_TIME - @filemtime(DT_ROOT.'/'.$MOD['moduledir'].'/rss.xml') > $MOD['rss_time']) tohtml('rss', $module);
}
?>