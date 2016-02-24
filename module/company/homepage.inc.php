<?php 
defined('IN_DESTOON') or exit('Access Denied');
$menuon = 'index';
$r = $db->get_one("SELECT content FROM {$DT_PRE}company_data WHERE userid=$COM[userid]");
$COM['introduce'] = dsubstr(strip_tags($r['content']), 1000, '...');
$COM['thumb'] = $COM['thumb'] ? $COM['thumb'] : SKIN_PATH.'image/company.jpg';
include template('index', $template);
if($CFG['cache_page']) cache_page();
?>