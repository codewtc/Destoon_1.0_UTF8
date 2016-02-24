<?php
defined('IN_DESTOON') or exit('Access Denied');
require MOD_ROOT.'/guestbook.class.php';
$do = new guestbook();
$menus = array (
    array('留言列表', '?moduleid='.$moduleid.'&file='.$file),
    array('审核留言', '?moduleid='.$moduleid.'&file='.$file.'&action=check'),
);
if(in_array($action, array('', 'check'))) {
	$sfields = array('按条件', '留言标题', '会员名', '留言人', '留言IP', '留言内容', '回复内容');
	$dfields = array('title', 'title', 'username', 'poster', 'ip', 'content', 'reply');
	$sorder  = array('结果排序方式', '留言时间降序', '留言时间升序', '回复时间降序', '回复时间升序');
	$dorder  = array('itemid DESC', 'addtime DESC', 'addtime ASC', 'replytime DESC', 'replytime ASC');

	isset($fields) && isset($dfields[$fields]) or $fields = 0;
	isset($order) && isset($dorder[$order]) or $order = 0;

	$fields_select = dselect($sfields, 'fields', '', $fields);
	$order_select  = dselect($sorder, 'order', '', $order);

	$condition = '';
	if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
}
switch($action) {
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
			$menuon = array('0', '0', '1', '0');
			include tpl('guestbook_edit', $module);
		}
	break;
	case 'check':
		if($itemid) {
			if(isset($status)) {
				$status = 2;
				$msg = '取消成功';
			} else {
				$status = 3;
				$msg = '审核成功';
			}
			$do->check($itemid, $status);
			dmsg($msg, $forward);
		} else {
			$menuon = 1;
			$lists = $do->get_list('status=2'.$condition, $dorder[$order]);
			include tpl('guestbook', $module);
		}
	break;
	case 'delete':
		$itemid or msg('请选择留言');
		$do->delete($itemid);
		dmsg('删除成功', $forward);
	break;
	default:
		$menuon = 0;
		$lists = $do->get_list('status=3'.$condition, $dorder[$order]);
		include tpl('guestbook', $module);
	break;
}
?>