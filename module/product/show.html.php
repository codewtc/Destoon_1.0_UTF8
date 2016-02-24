<?php 
defined('IN_DESTOON') or exit('Access Denied');
if(!$MOD['show_html'] || !$itemid) return false;
$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid AND status>2");
if(!$item) return false;
if($MOD['text_data']) {
	$content = text_read($itemid, $moduleid);
} else {
	$content = $db->get_one("SELECT content FROM {$table_data} WHERE itemid=$itemid");
	$content = $content['content'];
}
extract($item);
$member = $db->get_one("SELECT c.company,c.areaid,c.address,c.postcode,c.telephone,c.fax,c.mail,c.linkurl,c.vip,c.fromtime,c.validated,c.validator,m.truename,m.gender,m.career,m.msn,m.qq FROM {$DT_PRE}company c,{$DT_PRE}member m WHERE m.userid=c.userid AND m.username='$username'");
$member['gender'] = $member['gender'] == 1 ? '先生' : '女士';
$member['year'] = $member['fromtime'] ? intval(date('Y', $DT_TIME)-date('Y', $member['fromtime']))+1 : 1;
$adddate = timetodate($addtime, 3);
$editdate = timetodate($edittime, 3);
$fileurl = $linkurl;
$linkurl = linkurl($MOD['linkurl'].$linkurl, 1);
$thumbs = $albums = array();
$thumbs[] = $thumb ? $thumb : SKIN_PATH.'image/nopic50.gif';
$thumbs[] = $thumb1 ? $thumb1 : SKIN_PATH.'image/nopic50.gif';
$thumbs[] = $thumb2 ? $thumb2 : SKIN_PATH.'image/nopic50.gif';
$albums[] = $thumb ? str_replace('.thumb.'.file_ext($thumb), '', $thumb) : SKIN_PATH.'image/nopic200.gif';
$albums[] = $thumb1 ? str_replace('.thumb.'.file_ext($thumb1), '', $thumb1) : SKIN_PATH.'image/nopic200.gif';
$albums[] = $thumb2 ? str_replace('.thumb.'.file_ext($thumb2), '', $thumb2) : SKIN_PATH.'image/nopic200.gif';
$head_title = $title.' - '.($MOD['seo_title'] ? $MOD['seo_title'] : $MOD['name']);
$head_keywords = $keyword;
$head_description = $introduce ? $introduce : $title;
$template or $template = 'show';
$destoon_task = "moduleid=$moduleid&html=show&itemid=$itemid";

ob_start();
include template($template, $module);
$data = ob_get_contents();
ob_clean();
file_put(DT_ROOT.'/'.$MOD['moduledir'].'/'.$fileurl, $data);
return true;
?>