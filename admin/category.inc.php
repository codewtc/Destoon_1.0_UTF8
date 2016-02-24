<?php
/*
	[Destoon B2B System] Copyright (c) 2009 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_DESTOON') or exit('Access Denied');
$mid = isset($mid) ? intval($mid) : 1;
require DT_ROOT.'/admin/category.class.php';
$CATEGORY = cache_read('category-'.$mid.'.php');
$catid = isset($catid) ? intval($catid) : 0;
$do = new category($mid, $catid);
$parentid = isset($parentid) ? intval($parentid) : 0;
$menus = array (
    array('添加栏目', '?file='.$file.'&action=add&mid='.$mid.'&parentid='.$parentid),
    array('管理栏目', '?file='.$file.'&mid='.$mid),
    array('更新缓存', '?file='.$file.'&action=cache&mid='.$mid),
);
switch($action) {
	case 'add':
		if($submit) {
			if($do->add($category)) dmsg('添加成功', '?file='.$file.'&action='.$action.'&mid='.$mid.'&parentid='.$category['parentid']);
			msg($do->errmsg);
		} else {
			include tpl('category_add');
		}
	break;
	case 'edit':
		$catid or msg();
		if($submit) {
			if($do->edit($category)) dmsg('修改成功', '?file='.$file.'&mid='.$mid.'&parentid='.$category['parentid']);
			msg($do->errmsg);
		} else {
			extract(cache_read('category_'.$catid.'.php'));
			include tpl('category_edit');
		}
	break;
	case 'ckdir':
		if(!preg_match("/^[0-9a-z_-]+$/i", $catdir)) dialog('不是一个合法的目录名,请更换一个再试');
		$r = $db->get_one("select catid from {$DT_PRE}category where catdir='$catdir' and moduleid='$moduleid' ");
		if($r) dialog('该目录名已经被使用,请更换一个再试');
		dialog('目录名可以使用');
	break;
	case 'cache':
		$do->repair();
		dmsg('更新成功', $forward);
	break;
	case 'delete':
		if(!$catid) msg();
		$do->delete($catid);
		dmsg('删除成功', $forward);
	break;
	case 'update':
		if(!$category || !is_array($category)) msg();
		$do->update($category);
		dmsg('更新成功', $forward);
	break;
	case 'letter':
		isset($catname) or $catname = '';
		if(!$catname) exit('');
		if(strtolower($CFG['charset']) != 'utf-8') $catname = convert($catname, 'utf-8', $CFG['charset']);
		exit($do->get_letter($catname));
	break;
	default:
		$CATEGORY or msg('暂无栏目,请先添加',  '?file='.$file.'&mid='.$mid.'&action=add&parentid='.$parentid);
		$DCAT = array();
		foreach($CATEGORY as $k=>$v) {
			if($v['parentid'] != $parentid) continue;
			$v['childs'] = substr_count($v['arrchildid'], ',');
			$DCAT[$k] = $v;
		}
		include tpl('category');
	break;
}
?>