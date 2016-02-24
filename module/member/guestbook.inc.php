<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
if($action != 'add') {
	login();
	$MYGROUP['homepage'] or message('您所在的会员组没有此权限', $MOD['linkurl']);
}
require DT_ROOT.'/include/post.func.php';
require MOD_ROOT.'/guestbook.class.php';
$do = new guestbook();

switch($action) {
	case 'add':
		captcha($captcha);
		if($do->pass($post)) {
			$do->add($post);
			message('留言提交成功，请等待本公司工作员处理', $forward, 5);
		} else {
			message($do->errmsg, $forward);
		}
	break;
	case 'edit':
		$itemid or message();
		$do->itemid = $itemid;
		$r = $do->get_one();
		if(!$r || $r['username'] != $_username) message();
		if($submit) {
			if($do->pass($post)) {
				$do->edit($post);
				dmsg('修改成功', $forward);
			} else {
				message($do->errmsg);
			}
		} else {
			extract($r);
			$replytime = timetodate($DT_TIME, 6);
			$head_title = '处理留言';
		}
	break;
	case 'delete':
		$itemid or message();
		$do->delete($itemid);
		dmsg('删除成功', $forward);
	break;
	case 'check':
		$itemid or message();
		$do->check($itemid);
		dmsg('审核成功', $forward);
	break;
	case 'reject':
		$itemid or message();
		$do->check($itemid, 2);
		dmsg('取消成功', $forward);
	break;
	default:
		$sfields = array('按条件', '标题', '留言人', '留言IP');
		$dfields = array('title', 'title', 'poster', 'ip');
		isset($fields) && isset($dfields[$fields]) or $fields = 0;
		$status = isset($status) ? intval($status) : 2;
		$status = $status == 2 ? 2 : 3;
		$fields_select = dselect($sfields, 'fields', '', $fields);
		$condition = "username='$_username'";
		$condition .= " AND status=$status";
		if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
		$lists = $do->get_list($condition);
		$head_title = '留言本';
	break;
}
$nums = array();
for($i = 2; $i < 4; $i++) {
	$r = $db->get_one("SELECT COUNT(itemid) AS num FROM {$DT_PRE}guestbook WHERE username='$_username' AND status=$i");
	$nums[$i] = $r['num'];
}
include template('guestbook', $module);
?>