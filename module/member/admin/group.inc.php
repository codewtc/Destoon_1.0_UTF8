<?php
defined('IN_DESTOON') or exit('Access Denied');
require MOD_ROOT.'/group.class.php';
$menus = array (
    array('会员组添加', '?moduleid='.$moduleid.'&file='.$file.'&action=add'),
    array('会员组管理', '?moduleid='.$moduleid.'&file='.$file),
);
$do = new group;
if(isset($groupid)) $do->groupid = $groupid;
if(isset($groupname)) $do->groupname = $groupname;
if(isset($vip)) $do->vip = intval($vip);
$this_forward = '?moduleid='.$moduleid.'&file='.$file;

if($action == 'add') {
	if($submit) {
		if(!$groupname) msg('会员组名称不能为空');
		if($do->vip > 9) msg(VIP.'指数请填写0-9数字');
		$setting['fee'] = intval($setting['fee']);
		if($setting['fee'] && !$do->vip) msg('收费会员组'.VIP.'指数不能为0');
		if(!$setting['fee'] && $do->vip) msg('免费会员组'.VIP.'指数只能为0');
		$setting['moduleids'] = implode(',', $setting['moduleids']);
		$do->add($setting);
		dmsg('添加成功', $this_forward);
	} else {
		include tpl('group_add', $module);
	}
} else if($action == 'edit') {
	$groupid or msg();
	if($submit) {
		if(!$groupname) msg('会员组名称不能为空');
		if($do->vip > 9) msg(VIP.'指数请填写0-9数字');
		$setting['fee'] = intval($setting['fee']);
		if($setting['fee'] && !$do->vip) msg('收费会员组'.VIP.'指数不能为0');
		if(!$setting['fee'] && $do->vip) msg('免费会员组'.VIP.'指数只能为0');
		$setting['moduleids'] = implode(',', $setting['moduleids']);
		$do->edit($setting);
		dmsg('修改成功', $this_forward);
	} else {
		extract($do->get_one());
		$moduleids = explode(',', $moduleids);
		include tpl('group_edit', $module);
	}
} else if($action == 'delete') {
	$groupid or msg();
	$do->delete();
	dmsg('删除成功', $this_forward);
} else {
	$groups = array();
	$result = $db->query("SELECT * FROM {$DT_PRE}group order by groupid");
	while($r = $db->fetch_array($result)) {
		$r['type'] = $r['groupid'] > 6 ? '自定义' : '系统';
		$groups[]=$r;
	}
	include tpl('group', $module);
}
?>