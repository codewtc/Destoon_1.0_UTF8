<?php
defined('IN_DESTOON') or exit('Access Denied');
if($submit) {
	update_setting($moduleid, $setting);
	cache_module($moduleid);
	cache_category($moduleid);
	dmsg('更新成功', '?moduleid='.$moduleid.'&file='.$file);
} else {
	extract(dhtmlspecialchars($MOD));
	include tpl('setting', $module);
}
?>