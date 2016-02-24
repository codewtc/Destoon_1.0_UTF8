<?php
defined('IN_DESTOON') or exit('Access Denied');
if($submit) {
	cache_write('pay.php', $pay);
	foreach($pay as $k=>$v) {
		update_setting('pay-'.$k, $v);
	}
	update_setting($moduleid, $setting);
	cache_module($moduleid);
	dmsg('更新成功', '?moduleid='.$moduleid.'&file='.$file);
} else {
	cache_pay();
	extract(dhtmlspecialchars($MOD));
	extract(cache_read('pay.php'));
	include tpl('setting', $module);
}
?>