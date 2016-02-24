<?php 
defined('IN_DESTOON') or exit('Access Denied');
login();
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$MYGROUP['homepage'] or message('您所在的会员组没有此权限', $MOD['linkurl']);
require DT_ROOT.'/include/post.func.php';
require MOD_ROOT.'/news.class.php';
$do = new news();

switch($action) {
	case 'add':
		if($submit) {
			if($do->pass($post)) {
				$post['username'] = $_username;
				$post['status'] = get_status(3, $MOD['news_check']);
				$do->add($post);
				dmsg('添加成功', $MOD['linkurl'].'news.php?status='.$post['status']);
			} else {
				message($do->errmsg);
			}
		} else {		
			$addtime = timetodate($DT_TIME);
		}
	break;
	case 'edit':
		$itemid or message();
		$do->itemid = $itemid;
		$r = $do->get_one();
		if(!$r || $r['username'] != $_username) message();
		if($submit) {
			if($do->pass($post)) {
				$post['username'] = $_username;
				$post['status'] = get_status($r['status'], $MOD['news_check']);
				$do->edit($post);
				dmsg('修改成功', $forward);
			} else {
				message($do->errmsg);
			}
		} else {
			extract($r);
			$addtime = timetodate($addtime);
		}
	break;
	case 'delete':
		$itemid or message();
		$do->itemid = $itemid;
		$r = $do->get_one();
		if(!$r || $r['username'] != $_username) message();
		$do->recycle($itemid);
		dmsg('删除成功', $forward);
	break;
	default:
		$status = isset($status) ? intval($status) : 3;
		in_array($status, array(1, 2, 3)) or $status = 3;
		$condition = "username='$_username'";
		$condition .= " AND status=$status";
		if($keyword) $condition .= " AND title LIKE '%$keyword%'";
		$lists = $do->get_list($condition);
		$head_title = '公司新闻';
	break;
}
$nums = array();
for($i = 1; $i < 4; $i++) {
	$r = $db->get_one("SELECT COUNT(itemid) AS num FROM {$DT_PRE}news WHERE username='$_username' AND status=$i");
	$nums[$i] = $r['num'];
}
include template('news', $module);
?>