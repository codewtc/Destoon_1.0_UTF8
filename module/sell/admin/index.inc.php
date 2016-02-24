<?php
defined('IN_DESTOON') or exit('Access Denied');
require MOD_ROOT.'/sell.class.php';
$do = new sell($moduleid);
$menus = array (
    array('添加'.$MOD['name'], '?moduleid='.$moduleid.'&action=add'),
    array($MOD['name'].'列表', '?moduleid='.$moduleid),
    array('审核'.$MOD['name'], '?moduleid='.$moduleid.'&action=check'),
    array('过期'.$MOD['name'], '?moduleid='.$moduleid.'&action=expire'),
    array('未通过'.$MOD['name'], '?moduleid='.$moduleid.'&action=reject'),
    array('回收站', '?moduleid='.$moduleid.'&action=recycle'),
    array('移动'.$MOD['name'], '?moduleid='.$moduleid.'&action=move'),
);
if(in_array($action, array('', 'check', 'expire', 'reject', 'recycle'))) {
	$sfields = array('模糊', '标题', '简介', '会员名', '关键词');
	$dfields = array('keyword', 'title', 'introduce', 'username', 'tag');
	$sorder  = array('结果排序方式', '更新时间降序', '更新时间升序', '添加时间降序', '添加时间升序', '浏览次数降序', '浏览次数升序', '信息ID降序', '信息ID升序');
	$dorder  = array($MOD['order'], 'edittime DESC', 'edittime ASC', 'addtime DESC', 'addtime ASC', 'hits DESC', 'hits ASC', 'itemid DESC', 'itemid ASC');

	$level = isset($level) ? intval($level) : 0;
	$typeid = isset($typeid) ? ($typeid === '' ? -1 : intval($typeid)) : -1;
	isset($fields) && isset($dfields[$fields]) or $fields = 0;
	isset($order) && isset($dorder[$order]) or $order = 0;

	$fields_select = dselect($sfields, 'fields', '', $fields);
	$type_select = dselect($TYPE, 'typeid', $MOD['name'].'类型', $typeid);
	$level_select = level_select('level', '级别', $level);
	$order_select  = dselect($sorder, 'order', '', $order);

	$condition = '';
	if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
	if($catid) $condition .= ($CATEGORY[$catid]['child']) ? " AND catid IN (".$CATEGORY[$catid]['arrchildid'].")" : " AND catid=$catid";
	if($typeid >=0) $condition .= " AND typeid=$typeid";
	if($level) $condition .= " AND level=$level";

	$timetype = strpos($dorder[$order], 'add') !== false ? 'add' : '';
}
switch($action) {
	case 'add':
		if($submit) {
			if($do->pass($post)) {
				$do->add($post);
				dmsg('添加成功', '?moduleid='.$moduleid.'&action='.$action);
			} else {
				msg($do->errmsg);
			}
		} else {
			$addtime = timetodate($DT_TIME);
			$totime = timetodate($DT_TIME+$MOD['over_days']*24*3600, 3);
			include tpl($action, $module);
		}
	break;
	case 'edit':
		$itemid or msg();
		$do->itemid = $itemid;
		if($submit) {
			if($do->pass($post)) {
				$do->edit($post);
				dmsg('修改成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			extract($do->get_one());
			$addtime = timetodate($addtime);
			$totime = timetodate($totime, 3);
			$menuon = array('5', '4', '2', '1', '3');
			include tpl($action, $module);
		}
	break;
	case 'move':
		if($submit) {
			$tocatid or msg('请选择目标栏目');
			if($fromtype == 'itemid') {
				$itemids or msg('请指定ID');
				$do->move($itemids, $tocatid, 1);
			} else {
				$fromcatid = is_array($fromcatid) ? implode(',', $fromcatid) : $fromcatid;
				$fromcatid or msg('请选择源栏目');
				$do->move($fromcatid, $tocatid);
			}
			dmsg('移动成功', $forward);
		} else {
			$itemid = $itemid ? implode(',', $itemid) : '';
			include tpl($action, $module);
		}
	break;
	case 'update':
		is_array($itemid) or msg('请选择'.$MOD['name']);
		foreach($itemid as $v) {
			$do->update($v);
		}
		dmsg('更新成功', $forward);
	break;
	case 'tohtml':
		is_array($itemid) or msg('请选择'.$MOD['name']);
		foreach($itemid as $itemid) {
			tohtml('show', $module);
		}
		dmsg('更新成功', $forward);
	break;
	case 'recycle':
		$lists = $do->get_list('status=0'.$condition, $dorder[$order]);
		include tpl($action, $module);
	break;
	case 'reject':
		if($itemid) {
			$do->reject($itemid);
			dmsg('拒绝成功', $forward);
		} else {
			$lists = $do->get_list('status=1'.$condition, $dorder[$order]);
			include tpl($action, $module);
		}
	break;
	case 'expire':
		if(isset($refresh)) {
			if(isset($delete)) {
				$days = isset($days) ? intval($days) : 0;
				$days or msg('请填写天数');
				$do->clear("status=4 AND totime<$DT_TIME-$days*24*3600");
				dmsg('删除成功', $forward);
			} else {
				$do->expire();
				dmsg('刷新成功', $forward);
			}
		} else {
			$lists = $do->get_list('status=4'.$condition, $dorder[$order]);
			include tpl($action, $module);
		}
	break;
	case 'check':
		if($itemid) {
			$do->check($itemid);
			dmsg('审核成功', $forward);
		} else {
			$lists = $do->get_list('status=2'.$condition, $dorder[$order]);
			include tpl($action, $module);
		}
	break;
	case 'delete':
		$itemid or msg('请选择'.$MOD['name']);
		isset($recycle) ? $do->recycle($itemid) : $do->delete($itemid);
		dmsg('删除成功', $forward);
	break;
	case 'clear':
		$do->clear($v);
		dmsg('清空成功', $forward);
	break;
	case 'level':
		$itemid or msg('请选择'.$MOD['name']);
		$level = intval($level);
		$do->level($itemid, $level);
		dmsg('级别设置成功', $forward);
	break;
	default:
		$lists = $do->get_list('status=3'.$condition, $dorder[$order]);
		include tpl('index', $module);
	break;
}
?>