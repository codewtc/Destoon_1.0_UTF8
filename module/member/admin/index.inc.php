<?php
defined('IN_DESTOON') or exit('Access Denied');
require MOD_ROOT.'/member.class.php';
$menus = array (
    array('添加会员', '?moduleid='.$moduleid.'&action=add'),
    array('会员列表', '?moduleid='.$moduleid),
    array('审核会员', '?moduleid='.$moduleid.'&action=check'),
    array('公司列表', '?moduleid=4'),
);
$do = new member;
isset($userid) or $userid = 0;
if(in_array($action, array('', 'check'))) {
	$sfields = array('按条件', '公司名', '会员名', '姓名', '手机号码', '部门', '职位', 'Email', 'MSN', 'QQ');
	$dfields = array('username', 'company', 'username', 'truename', 'mobile', 'department', 'career', 'email', 'msn', 'qq');
	$sorder  = array('结果排序方式', '注册时间降序', '注册时间升序', '登录时间降序', '登录时间升序', '登录次数降序', '登录次数升序');
	$dorder  = array('userid DESC', 'regtime DESC', 'regtime ASC', 'logintime DESC', 'logintime ASC', 'logintimes DESC', 'logintimes ASC');
	$sgender = array('性别', '先生' , '女士');

	isset($fields) && isset($dfields[$fields]) or $fields = 0;
	isset($order) && isset($dorder[$order]) or $order = 0;
	$groupid = isset($groupid) ? intval($groupid) : 0;
	$gender = isset($gender) ? intval($gender) : 0;

	$fields_select = dselect($sfields, 'fields', '', $fields);
	$order_select  = dselect($sorder, 'order', '', $order);
	$gender_select = dselect($sgender, 'gender', '', $gender);
	$group_select = group_select('groupid', '会员组', $groupid);

	$condition = $action ? 'groupid=4' : '1';
	if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
	if($gender) $condition .= " AND gender=$gender";
	if($groupid) $condition .= " AND groupid=$groupid";
}
if(in_array($action, array('add', 'edit'))) {
	$COM_TYPE = explode('|', $MOD['com_type']);
	$COM_SIZE = explode('|', $MOD['com_size']);
	$COM_MODE = explode('|', $MOD['com_mode']);
	$MONEY_UNIT = explode('|', $MOD['money_unit']);
}
switch($action) {
	case 'add':
		if($submit) {
			$member['banner'] = '';
			if($do->add($member)) {
				dmsg('添加成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			include tpl('member_add', $module);
		}
	break;
	case 'edit':
		$userid or msg();
		$do->userid = $userid;
		if($submit) {
			if($do->edit($member)) {
				dmsg('修改成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			extract($do->get_one());
			$d = $db->get_one("SELECT content FROM {$DT_PRE}company_data WHERE userid=$userid");
			$introduce = $d['content'];
			include tpl('member_edit', $module);
		}
	break;
	case 'show':
		$username = isset($username) ? $username : '';
		($userid || $username) or msg();
		if($userid) $do->userid = $userid;
		extract($do->get_one($username));
		include tpl('member_show', $module);
	break;
	case 'delete':
		$userid or msg('请选择会员');
		if($do->delete($userid)) {
			dmsg('删除成功', $forward);
		} else {
			msg($do->errmsg);
		}
	break;
	case 'move':
		$userid or msg('请选择会员');
		if($do->move($userid, $groupid)) {
			dmsg('移动成功', $forward);
		} else {
			msg($do->errmsg);
		}
	break;
	case 'check':
		if($userid) {
			$do->check($userid);
			dmsg('审核成功', $forward);
		} else {
			$members = $do->get_list($condition, $dorder[$order]);
			include tpl('member_check', $module);
		}
	break;
	default:
		$members = $do->get_list($condition, $dorder[$order]);
		include tpl('member', $module);
	break;
}
?>