<?php 
defined('IN_DESTOON') or exit('Access Denied');
$head_title = $MENU['contact'][0];
$menuon = 'contact';
include template('contact', $template);
if($CFG['cache_page']) cache_page();
?>