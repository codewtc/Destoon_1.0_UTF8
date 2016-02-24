<?php
defined('IN_DESTOON') or exit('Access Denied');
$menu = array(
	array("广告管理", "?moduleid=$moduleid&file=ad"),
	array("公告管理", "?moduleid=$moduleid&file=announce"),
	array("单页管理", "?moduleid=$moduleid&file=webpage"),
	array("友情链接", "?moduleid=$moduleid&file=link"),
	array("模块设置", "?moduleid=$moduleid&file=setting"),
);
?>