<?php
/*
	[Destoon B2B System] Copyright (c) 2009 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
require 'common.inc.php';
require DT_ROOT.'/include/post.func.php';
switch($action) {
	case 'area':
		if(strtolower($CFG['charset']) != 'utf-8') $area_title = convert($area_title, 'utf-8', $CFG['charset']);
		$area_extend = isset($area_extend) ? stripslashes($area_extend) : '';
		$areaid = isset($areaid) ? intval($areaid) : 0;
		$area_deep = isset($area_deep) ? intval($area_deep) : 0;
		echo get_area_select($area_title, $areaid, $area_extend, $area_deep);
	break;
	case 'category':
		if(strtolower($CFG['charset']) != 'utf-8') $category_title = convert($category_title, 'utf-8', $CFG['charset']);
		$category_extend = isset($category_extend) ? stripslashes($category_extend) : '';
		$category_moduleid = isset($category_moduleid) ? intval($category_moduleid) : 1;
		if(!$category_moduleid) exit;
		$category_deep = isset($category_deep) ? intval($category_deep) : 0;
		echo get_category_select($category_title, $catid, $category_moduleid, $category_extend, $category_deep);
	break;
	case 'clear':
		@ignore_user_abort(true);
		$session = new dsession();
		if($_SESSION['uploads']) {
			foreach($_SESSION['uploads'] as $file) {
				delete_upload($file, $_userid);
			}
			$_SESSION['uploads'] = array();
		}
	break;
	case 'ipage':
		isset($job) or exit;
		in_array($job, array('sell', 'buy', 'product')) or exit;
		$CATEGORY = cache_read('category-1.php');
		$AREA = cache_read('area.php');
		if($job == 'sell') {
			tag("moduleid=5&table=sell&length=40&condition=status=3&pagesize=6&page=$page&datetype=2&order=editdate desc,vip desc,edittime desc&template=list-idx");
		} else if($job == 'buy') {
			tag("moduleid=6&table=buy&length=40&condition=status=3&pagesize=6&page=$page&datetype=2&order=editdate desc,vip desc,edittime desc&template=list-idx");
		} else if($job == 'product') {
			tag("moduleid=7&table=product&length=14&condition=status=3 and thumb!=''&pagesize=6&page=$page&order=editdate desc,vip desc,edittime desc&width=80&height=80&cols=6&target=_blank&template=thumb-table");
		}
	break;
	case 'captcha':
		if(strlen($captcha) < 4) exit('1');
		$session = new dsession();
		if(!isset($_SESSION['captchastr'])) exit('2');
		if($_SESSION['captchastr'] != md5(md5(strtoupper($captcha).$CFG['authkey'].$DT_IP))) exit('3');
		exit('0');
	break;
	case 'question':
		if(strlen($answer) < 1) exit('1');
		$answer = stripslashes($answer);
		if(strtolower($CFG['charset']) != 'utf-8') $answer = convert($answer, 'utf-8', $CFG['charset']);
		$session = new dsession();
		if(!isset($_SESSION['answerstr'])) exit('2');
		if($_SESSION['answerstr'] != md5(md5($answer.$CFG['authkey'].$DT_IP))) exit('3');
		exit('0');
	break;
	case 'letter':
		preg_match("/[a-z]{1}/", $letter) or exit;
		$cols = isset($cols) ? intval($cols) : 5;
		$precent = ceil(100/$cols);
		$CATEGORY = cache_read('category-1.php');
		$CATALOG = array();
		foreach($CATEGORY as $k=>$v) {
			if($v['letter'] == $letter) $CATALOG[] = $v;
		}
		include template('letter');
	break;
	case 'member':
		isset($job) or $job = '';
		require DT_ROOT.'/module/'.$module.'/common.inc.php';
		isset($value) or $value == '';
		if(strtolower($CFG['charset']) != 'utf-8' && $value) $value = convert($value);
		require MOD_ROOT.'/member.class.php';
		$do = new member;
		if(isset($userid) && $userid) $do->userid = $userid;
		switch($job) {
			case 'username':
				if(!$value) exit('会员名不能为空');
				if(!$do->is_username($value)) echo $do->errmsg;
			break;
			case 'passport':
				if(!$value) exit();
				if(!$do->is_passport($value)) echo $do->errmsg;
			break;
			case 'password':
				if(!$do->is_password($value, $value)) echo $do->errmsg;
			break;
			case 'email':
				if(!is_email($value)) exit('邮件格式不正确');
				if($do->email_exists($value)) echo '邮件地址已经存在';
			break;
			case 'company':
				if(!$value) exit('公司名称不能为空');
				if($do->company_exists($value)) echo '公司名称已经存在';
			break;
			case 'get_company':
				$user = $do->get_one($value);
				if($user) {
					echo '<a href="'.$user['linkurl'].'" target="_blank" class="t">'.$user['company'].'</a>'.( $user['vip'] ? ' <img src="'.SKIN_PATH.'image/vip.gif" align="absmiddle"/> <img src="'.SKIN_PATH.'image/vip_'.$user['vip'].'.gif" align="absmiddle"/>' : '');
				} else {
					echo '1';
				}
			break;
		}
	break;
}
?>