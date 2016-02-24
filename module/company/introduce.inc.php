<?php 
defined('IN_DESTOON') or exit('Access Denied');
$head_title = $MENU['introduce'][0];
$menuon = 'introduce';
$r = $db->get_one("SELECT content FROM {$DT_PRE}company_data WHERE userid=$COM[userid]");
$content = $r['content'];
$COM['thumb'] = $COM['thumb'] ? $COM['thumb'] : SKIN_PATH.'image/company.jpg';
include template('introduce', $template);
if($CFG['cache_page']) cache_page();
?>