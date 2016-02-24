<?php 
defined('IN_DESTOON') or exit('Access Denied');
$head_title = $MENU['credit'][0];
$menuon = 'credit';
require DT_ROOT.'/module/member/credit.class.php';
$dcredit = new credit();
$credits = $dcredit->get_list("username='$username' AND status=3");
include template('credit', $template);
if($CFG['cache_page']) cache_page();
?>