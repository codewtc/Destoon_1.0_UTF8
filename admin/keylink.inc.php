<?php
/*
	[Destoon B2B System] Copyright (c) 2009 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_DESTOON') or exit('Access Denied');
isset($item) or msg();
require DT_ROOT.'/admin/keylink.class.php';
$menus = array();
$do = new keylink;
$do->item = $item;
if($submit) {
	if($do->update($post)) {
		dmsg('更新成功', '?file='.$file.'&item='.$item);
	} else {
		msg($do->errmsg);
	}
} else {
	$lists = $do->get_list();
	include tpl('keylink');
}
?>