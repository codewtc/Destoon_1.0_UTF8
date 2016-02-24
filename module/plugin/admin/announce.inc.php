<?php
defined('IN_DESTOON') or exit('Access Denied');
$TYPE = get_type('announce', 1);
$TYPE or msg('请先添加公告分类', '?file=type&item=announce');
require MOD_ROOT.'/announce.class.php';
$do = new announce();
$menus = array (
    array('添加公告', '?moduleid='.$moduleid.'&file='.$file.'&action=add'),
    array('公告列表', '?moduleid='.$moduleid.'&file='.$file),
    array('过期公告', '?moduleid='.$moduleid.'&file='.$file.'&action=expire'),
    array('公告分类', '?file=type&item=announce'),
);
$this_forward = '?moduleid='.$moduleid.'&file='.$file;
switch($action) {
	case 'add':
		if($submit) {
			if($do->pass($post)) {
				$do->add($post);
				dmsg('添加成功', $this_forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			$addtime = timetodate($DT_TIME);
			include tpl('announce_add', $module);
		}
	break;
	case 'edit':
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
			$addtime = timetodate($addtime);
			$fromtime = $fromtime ? timetodate($fromtime, 3) : '';
			$totime = $totime ? timetodate($totime, 3) : '';
			include tpl('announce_edit', $module);
		}
	break;
	case 'order':
		if($do->order($listorder)) dmsg('排序成功', $this_forward);
		msg($do->errmsg);
	break;
	case 'update':
		if($do->update()) dmsg('更新成功', $this_forward);
		msg($do->errmsg);
	break;
	case 'expire':
		$lists = $do->get_list("totime>0 AND totime<$DT_TIME");
		include tpl('announce_expire', $module);
	break;
	case 'delete':
		$itemid or msg('请选择公告');
		$do->delete($itemid);
		dmsg('删除成功', $this_forward);
	break;
	default:	
		$sorder  = array('结果排序方式', '添加时间降序', '添加时间升序', '浏览次数降序', '浏览次数升序', '开始时间降序', '开始时间升序', '到期时间降序', '到期时间升序');
		$dorder  = array('listorder DESC,addtime DESC', 'addtime DESC', 'addtime ASC', 'hits DESC', 'hits ASC', 'fromtime DESC', 'fromtime ASC', 'totime DESC', 'totime ASC');
		isset($order) && isset($dorder[$order]) or $order = 0;
		isset($typeid) or $typeid = 0;
		$type_select = type_select('announce', 1, 'typeid', '请选择分类', $typeid);
		$order_select  = dselect($sorder, 'order', '', $order);
		$condition = '1';
		if($keyword) $condition .= " AND title LIKE '%$keyword%'";
		if($typeid) $condition .= " AND typeid=$typeid";
		$lists = $do->get_list($condition, $dorder[$order]);
		include tpl('announce', $module);
	break;
}
?>