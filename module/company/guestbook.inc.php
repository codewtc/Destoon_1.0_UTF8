<?php 
defined('IN_DESTOON') or exit('Access Denied');
$head_title = $MENU['guestbook'][0];
$menuon = 'guestbook';
require DT_ROOT.'/module/member/guestbook.class.php';
$pagesize = 5;
$offset = ($page-1)*$pagesize;
$gb = new guestbook();
$guestbooks = $gb->get_list("username='$username' AND status=3");
include template('guestbook', $template);
if($CFG['cache_page']) cache_page();
?>