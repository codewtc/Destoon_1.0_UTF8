<?php
/*
	[Destoon B2B System] Copyright (c) 2009 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/admin/area.class.php';
$menus = array (
    array('地区添加', '?file='.$file.'&action=add'),
    array('地区管理', '?file='.$file),
    array('更新缓存', '?file='.$file.'&action=cache'),
);
$areaid = isset($areaid) ? intval($areaid) : 0;
$do = new area($areaid);
$AREA = cache_read('area.php');
$parentid = isset($parentid) ? intval($parentid) : 0;
$this_forward = '?file='.$file.'&parentid='.$parentid;

switch($action) {
	case 'add':
		if($submit) {
			if(!$area['areaname']) msg('地区名不能为空');
			$areaname = explode("\n", trim($area['areaname']));
			foreach($areaname as $areaname) {
				$areaname = trim($areaname);
				if(!$areaname) continue;
				$area['areaname'] = $areaname;
				$do->add($area);
			}
			dmsg('添加成功', $this_forward);
		} else {
			include tpl('area_add');
		}
	break;
	case 'cache':
		$do->repair();
		dmsg('更新成功', $this_forward);
	break;
	case 'delete':
		if(!$areaid) msg('Invalid Request');
		$do->delete($areaid);
		dmsg('删除成功', $this_forward);
	break;
	case 'update':
		if(!$area || !is_array($area)) msg('Invalid Request');
		$do->update($area);
		dmsg('更新成功', $this_forward);
	break;
	default:
		$DAREA = array();
		foreach($AREA as $k=>$v) {
			if($v['parentid'] != $parentid) continue;
			$v['childs'] = substr_count($v['arrchildid'], ',');
			$DAREA[$k] = $v;
		}
		include tpl('area');
	break;
}
?>