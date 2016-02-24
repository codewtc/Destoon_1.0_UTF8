<?php
defined('IN_DESTOON') or exit('Access Denied');
require MOD_ROOT.'/webpage.class.php';
isset($item) or $item = 1;
$do = new webpage();
$do->item = $item;
$menus = array (
    array('添加单页', '?moduleid='.$moduleid.'&file='.$file.'&item='.$item.'&action=add'),
    array('单页列表', '?moduleid='.$moduleid.'&file='.$file.'&item='.$item),
);
$this_forward = '?moduleid='.$moduleid.'&file='.$file.'&item='.$item;
if($action == 'add') {
	if($submit) {
		if($do->pass($post)) {
			$do->add($post);
			dmsg('添加成功', $this_forward);
		} else {
			msg($do->errmsg);
		}
	} else {
		include tpl('webpage_add', $module);
	}
} else if($action == 'edit') {
	$itemid or msg();
	$do->itemid = $itemid;
	if($submit) {
		if($do->pass($post)) {
			$do->edit($post);
			dmsg('修改成功', $this_forward);
		} else {
			msg($do->errmsg);
		}
	} else {
		extract($do->get_one());
		if($islink) {
			$filepath = $filename = '';
		} else {
			$filestr = str_replace($CFG['url'], '', $linkurl);
			$filepath = strpos($filestr, '/') !== false ? dirname($filestr).'/' : '';
			$filename = basename($filestr);
		}
		include tpl('webpage_edit', $module);
	}
} else if($action == 'order') {
	if($do->order($listorder)) dmsg('排序成功', $this_forward);
	msg($do->errmsg);
} else if($action == 'tohtml') {
	if($itemid) {
		foreach($itemid as $itemid) {
			tohtml('webpage', $module);
		}
	} else {
		$result = $db->query("SELECT itemid FROM {$DT_PRE}webpage WHERE islink=0");
		while($r = $db->fetch_array($result)) {
			$itemid = $r['itemid'];
			tohtml('webpage', $module);
		}
	}
	dmsg('生成成功', $this_forward);
} else if($action == 'delete') {
	$itemid or msg('请选择单页');
	$do->delete($itemid);
	dmsg('删除成功', $this_forward);
} else {
	$lists = $do->get_list("item='$item'", 'listorder DESC,itemid DESC');
	include tpl('webpage', $module);
}
?>