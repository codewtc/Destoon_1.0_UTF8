<?php
defined('IN_DESTOON') or exit('Access Denied');
require MOD_ROOT.'/message.class.php';
$menus = array (
    array('发送信件', '?moduleid='.$moduleid.'&file='.$file.'&action=send'),
    array('系统信件', '?moduleid='.$moduleid.'&file='.$file),
    array('信件转发', '?moduleid='.$moduleid.'&file='.$file.'&action=mail'),
    array('信件清理', '?moduleid='.$moduleid.'&file='.$file.'&action=clear'),
);
$do = new message;
$this_forward = '?moduleid='.$moduleid.'&file='.$file;

switch($action) {
	case 'send':
		if($submit) {
			if($do->_send($message)) {
				dmsg('发送成功', $this_forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			include tpl('message_send', $module);
		}
	break;
	case 'edit':
		$itemid or msg();
		$do->itemid = $itemid;
		if($submit) {
			$do->_edit($message);
			dmsg('修改成功', $this_forward);
		} else {
			extract($do->get_one());
			include tpl('message_edit', $module);
		}
	break;
	case 'clear':
		if($submit) {
			if($do->_clear($message)) {
				dmsg('清理成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			$todate = timetodate(strtotime('-1 year'), 3);
			include tpl('message_clear', $module);
		}
	break;
	case 'mail':
		if(isset($send)) {
			isset($num) or $num = 0;
			$hour = intval($hour);
			if(!$hour) $hour = 48;
			$pernum = intval($pernum);
			if(!$pernum) $pernum = 10;
			$pagesize = $pernum;
			$offset = ($page-1)*$pagesize;
			$time = $DT_TIME - $hour*3600;
			$result = $db->query("SELECT * FROM {$DT_PRE}message WHERE isread=0 AND issend=0 AND addtime<$time AND status=3 ORDER BY itemid DESC LIMIT $offset,$pagesize");
			$i = false;
			while($r = $db->fetch_array($result)) {
				$m = $db->get_one("SELECT email FROM {$DT_PRE}member WHERE username='$r[touser]' AND groupid>4");
				if(!$m) continue;
				$linkurl = linkurl($MODULE[2]['linkurl'], 2).'message.php?action=show&itemid='.$r['itemid'];
				$r['fromuser'] or $r['fromuser'] = '系统信使';
				$r['content'] = $r['fromuser'].' 于 '.timetodate($r['addtime'], 5).' 向您发送一封站内信，内容如下：<br/><br/>'.$r['content'].'<br/><br/>原始地址：<a href="'.$linkurl.'" target="_blank">'.$linkurl.'</a><br/><br/>此邮件通过 <a href="'.DT_URL.'" target="_blank">'.$DT['sitename'].'</a> 邮件系统发出<br/><br/>如果您不希望收到类似邮件，请经常登录网站查收站内信件或将未读信件标记为已读<br/><br/>';
				send_mail($m['email'], $r['title'], $r['content']);
				$db->query("UPDATE {$DT_PRE}message SET issend=1 WHERE itemid=$r[itemid]");
				$i = true;
				$num++;
			}
			if($i) {
				$page++;
				msg('已发送 '.$num.' 封邮件，系统将自动继续，请稍候...', '?moduleid='.$moduleid.'&file='.$file.'&action='.$action.'&page='.$page.'&hour='.$hour.'&pernum='.$pernum.'&num='.$num.'&send=1');
			} else {
				file_put_contents(CACHE_ROOT.'/message.dat', $DT_TIME);
				msg('邮件发送成功 共发送 '.$num.' 封邮件', '?moduleid='.$moduleid.'&file='.$file.'&action='.$action, 5);
			}
		} else {
			$lasttime = '';
			if(is_file(CACHE_ROOT.'/message.dat')) $lasttime = file_get_contents(CACHE_ROOT.'/message.dat');
			$lasttime = $lasttime ? timetodate($lasttime, 5) : '';
			include tpl('message_mail', $module);
		}
	break;
	case 'delete':
		if(!$itemid) msg();
		$do->_delete($itemid);
		dmsg('删除成功', $this_forward);
	break;
	default:
		$messages = array();
		$result = $db->query("SELECT * FROM {$DT_PRE}message WHERE groupids!='' ORDER BY itemid DESC");
		while($r = $db->fetch_array($result)) {
			$r['addtime'] = timetodate($r['addtime'], 5);
			$r['group'] = '<select>';
			$groupids = explode(',', $r['groupids']);
			foreach($groupids as $groupid) {
				$r['group'] .= '<option>'.$GROUP[$groupid]['groupname'].'</option>';
			}
			$r['group'] .= '</select>';
			$messages[] = $r;
		}
		include tpl('message', $module);
	break;
}
?>