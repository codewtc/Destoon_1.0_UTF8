<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$MOD['member_add'] or message('系统禁止发布产品', $MOD['linkurl']);
require DT_ROOT.'/include/post.func.php';
require MOD_ROOT.'/product.class.php';
$TYPE = get_type('product-'.$_userid);
$TYPE or message('请先建立产品分类', $MODULE[2]['linkurl'].'type.php?item=product');
$do = new product($moduleid);
switch($action) {
	case 'add':
		if($submit) {
			captcha($captcha, $MOD['captcha_add']);
			if($do->pass($post)) {
				$post['addtime'] = $post['level'] = 0;
				$post['style'] = $post['template'] = $post['note'] = '';
				if(!$IMVIP) $post['thumb1'] = $post['thumb2'] = '';
				$post['status'] = get_status(3, $MOD['member_check']);
				$post['username'] = $_username;
				$do->add($post);
				dmsg('添加成功', $MODULE[2]['linkurl'].'my.php?mid='.$mid.'&status='.$post['status']);
			} else {
				message($do->errmsg);
			}
		} else {
			$type_select = type_select('product-'.$_userid, 0, 'post[typeid]', '默认');
		}
	break;
	case 'edit':
		$itemid or message();
		$do->itemid = $itemid;
		$r = $do->get_one();
		if(!$r || $r['username'] != $_username) message();
		if($DT['edit_limit'] && $DT_TIME - $r['addtime'] > $DT['edit_limit']*24*3600) message('此信息发布已经超过 '.$DT['edit_limit'].' 天，不可再修改');
		if($submit) {
			if($do->pass($post)) {
				$post['addtime'] = timetodate($r['addtime']);
				$post['level'] = $r['level'];
				$post['style'] = $r['style'];
				$post['template'] = $r['template'];
				$post['note'] = $r['note'];
				if(!$IMVIP) {
					$post['thumb1'] = $r['thumb1'];
					$post['thumb2'] = $r['thumb2'];
				}
				$post['status'] = get_status($r['status'], $MOD['member_check']);
				$post['username'] = $_username;
				$do->edit($post);
				dmsg('修改成功', $forward);
			} else {
				message($do->errmsg);
			}
		} else {
			extract($r);
			$type_select = type_select('product-'.$_userid, 0, 'post[typeid]', '默认', $typeid);
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
	case 'update':
		$do->_update($_username);
		dmsg('更新成功', $forward);
	break;
	default:
		$status = isset($status) ? intval($status) : 3;
		in_array($status, array(1, 2, 3)) or $status = 3;
		$condition = "username='$_username'";
		$condition .= " AND status=$status";
		$typeid = isset($typeid) ? ($typeid === '' ? -1 : intval($typeid)) : -1;
		$type_select = type_select('product-'.$_userid, 0, 'typeid', '默认', $typeid, '', '所属分类');
		if($keyword) $condition .= " AND keyword LIKE '%$keyword%'";
		if($catid) $condition .= ($CATEGORY[$catid]['child']) ? " AND catid IN (".$CATEGORY[$catid]['arrchildid'].")" : " AND catid=$catid";
		if($typeid >= 0) $condition .= " AND typeid=$typeid";
		$timetype = strpos($MOD['order'], 'add') !== false ? 'add' : '';
		$lists = $do->get_list($condition, $MOD['order']);
		foreach($lists as $k=>$v) {
			$lists[$k]['type'] = $v['typeid'] && isset($TYPE[$v['typeid']]) ? set_style($TYPE[$v['typeid']]['typename'], $TYPE[$v['typeid']]['style']) : '默认';
		}
	break;
}
$head_title = $MOD['name'].'管理';
$nums = array();
for($i = 1; $i < 4; $i++) {
	$r = $db->get_one("SELECT COUNT(itemid) AS num FROM {$table} WHERE username='$_username' AND status=$i");
	$nums[$i] = $r['num'];
}
include template('my_'.$module, 'member');
?>