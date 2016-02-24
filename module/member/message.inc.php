<?php 
defined('IN_DESTOON') or exit('Access Denied');
login();
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require DT_ROOT.'/include/post.func.php';
require MOD_ROOT.'/message.class.php';
$do = new message;
$action or $action = 'inbox';
$typeid = isset($typeid) ? intval($typeid) : '';
$TYPE = array('类型', '普通', '询盘', '报价', '信使');
$type_select = dselect($TYPE, 'typeid', '', $typeid);
$condition = '';
if($typeid) $condition .= " AND typeid=$typeid-1";
if($keyword) $condition .= " AND title LIKE '%$keyword%'";
$head_title = '站内信';
switch($action) {
	case 'send'://发信
		if($submit) {
			captcha($captcha, $MOD['captcha_sendmessage']);
			$message['typeid'] = $typeid;
			clear_upload($message['content']);
			if($do->send($message)) {
				dmsg(isset($message['save']) ? '草稿保存成功' : '信件发送成功', '?action=send');
			} else {
				message($do->errmsg);
			}
		} else {
			$touser = isset($touser) ? trim($touser) : '';
			$title = isset($title) ? stripslashes($title) : '';
			$content = isset($content) ? stripslashes($content) : '';
			if($typeid == 1) {
				$head = '发送询盘';
			} else if($typeid == 2) {
				$head = '发送报价';
			} else {
				$typeid = 0;
				$head = '发送信件';
			}
			$head_title = $head.' - '.$head_title;
		}
		break;
	case 'edit':
		$itemid or message('请指定要修改的信件');
		$do->itemid = $itemid;
		if($submit) {
			clear_upload($message['content']);
			if($do->edit($message)) {
				dmsg(isset($message['send']) ? '信件发送成功' : '草稿修改成功', '?action=draft');
			} else {
				message($do->errmsg);
			}
		} else {
			$message = $do->get_one();
			if(!$message || $message['status'] != 1 || $message['fromuser'] != $_username) message('信件不存在或无权修改');
			$touser = $message['touser'];
			$title = $message['title'];
			$content = $message['content'];
		}
		break;
	case 'clear':
		$status or message();
		$message = $do->clear($status);
		dmsg('成功清空', $forward);
		break;
	case 'delete':
		$itemid or message('请指定要删除的信件');
		$recycle = isset($recycle) ? 0 : 1;
		$do->itemid = $itemid;
		$message = $do->delete($recycle);
		dmsg('成功删除', $forward);
		break;
	case 'mark':
		$itemid or message('请指定要标记的信件');
		$do->itemid = $itemid;
		$message = $do->mark();
		dmsg('已标记为已读', $forward);
		break;
	case 'restore':
		$itemid or message('请指定要还原的信件');
		$do->itemid = $itemid;
		$message = $do->restore();
		dmsg('成功还原', $forward);
		break;
	case 'show':
		$itemid or message();
		$do->itemid = $itemid;
		$message = $do->get_one();
		if(!$message) message('信件不存在或无权查看');
		$fback = isset($feedback) ? 1 : 0;
		extract($message);
		if($status == 4 || $status == 3) {
			if($touser != $_username) message('无权限查看此信件');
			if(!$isread) {
				$do->read();
				--$_message;
				if($fback && $feedback) $do->feedback($message);
			}
		} else if($status == 2 || $status == 1) {
			if($fromuser != $_username) message('无权限查看此信件');
		}
		$addtime = timetodate($addtime, 5);
		$messages = array();
		if($_message) {
			$messages = $do->get_list("touser='$_username' AND status=3 AND isread=0");
		}
		break;
	case 'export':
		$head_title = '信件导出 - '.$head_title;
		if($submit) {
			$do->export($message) or message($do->errmsg);
		} else {
			$fromdate = timetodate(strtotime('-1 month'), 3);
			$todate = timetodate($DT_TIME, 3);
		}
		break;
	case 'refuse':
		if(!$username) message('请指定要加入黑名单的会员');
		if(!$do->is_member($username)) message('会员不存在，请检查');
		$black = $db->get_one("SELECT black FROM {$DT_PRE}member WHERE userid=$_userid");
		$black = $black['black'];
		if($black) {
			$tmp = explode(' ', trim($black));
			if(in_array($username, $tmp)) {
				message('会员已经位于黑名单');
			} else {
				$black = $black.' '.$username;
			}
		} else {
			$black = $username;
		}
		$db->query("UPDATE {$DT_PRE}member SET black='$black' WHERE userid=$_userid");
		dmsg('黑名单更新成功', '?action=setting');
		break;
	case 'setting':
		if($submit) {
			if($black) {
				$blacks = array();
				$tmp = explode(' ', trim($black));
				foreach($tmp as $v) {
					if($do->is_member($v) && !in_array($v, $blacks)) $blacks[] = $v;
				}
				$black = $blacks ? implode(' ', $blacks) : '';
			} else {
				$black = '';
			}
			$db->query("UPDATE {$DT_PRE}member SET black='$black' WHERE userid=$_userid");
			dmsg('设置更新成功', '?action=setting');
		} else {
			$head_title = '黑名单 - '.$head_title;
			$user = $db->get_one("SELECT black FROM {$DT_PRE}member WHERE userid=$_userid");
			$black = $user['black'];
		}
		break;
	case 'outbox':
		$status = 2;
		$name = '已发送';
		$condition = "fromuser='$_username' AND status=$status ".$condition;
		$messages = $do->get_list($condition);
		$head_title = $name.' - '.$head_title;
		break;
	case 'draft':
		$status = 1;
		$name = '草稿箱';
		$condition = "fromuser='$_username' AND status=$status ".$condition;
		$messages = $do->get_list($condition);
		$head_title = $name.' - '.$head_title;
		break;
	case 'recycle':
		$status = 4;
		$name = '回收站';
		$condition = "touser='$_username' AND status=$status ".$condition;
		$messages = $do->get_list($condition);
		$head_title = $name.' - '.$head_title;
		break;
	case 'last':
		if($_message) {
			$item = $db->get_one("SELECT itemid,feedback FROM {$DT_PRE}message WHERE touser='$_username' AND status=3 AND isread=0 ORDER BY itemid DESC");
			if($item) message('', $MOD['linkurl'].'message.php?action=show&itemid='.$item['itemid'].($item['feedback'] ? '&feedback=1' : ''));
		} 
		message('', $MOD['linkurl'].'message.php');
		break;
	default:
		$status = 3;
		$name = '收件箱';
		$condition = "touser='$_username' AND status=$status ".$condition;
		$messages = $do->get_list($condition);
		$systems = $do->get_sys();
		$head_title = $name.' - '.$head_title;
}
include template('message', $module);
?>