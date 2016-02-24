<?php 
defined('IN_DESTOON') or exit('Access Denied');
class member {
	var $userid;
	var $username;
	var $db;
	var $tb_member;
	var $tb_company;
	var $tb_company_data;
	var $errmsg = errmsg;

    function member()	{
		global $db, $DT_PRE;
		$this->tb_member = $DT_PRE.'member';
		$this->tb_company = $DT_PRE.'company';
		$this->tb_company_data = $DT_PRE.'company_data';
		$this->db = &$db;
    }

	function is_username($username) {
		global $MOD;
		if(!$username) return $this->_('会员登录名不能为空');		
		if(!$MOD['minusername']) $MOD['minusername'] = 4;
		if(!$MOD['maxusername']) $MOD['maxusername'] = 20;
		if(strlen($username) < $MOD['minusername'] || strlen($username) > $MOD['maxusername']) return $this->_('会员登录名长度应在'.$MOD['minusername'].'-'.$MOD['maxusername'].'之间');
		if(!preg_match("/^[a-z0-9]+$/", $username)) return $this->_('只能使用小写字母(a-z)、数字(0-9)');
		if($MOD['banusername']) {
			$tmp = explode('|', $MOD['banusername']);
			foreach($tmp as $v) {
				if(strpos($username, $v) !== false) return $this->_('会员登录名已经被注册');
			}
		}
		if($this->username_exists($username)) return $this->_('会员登录名已经被注册');
		return true;
	}
	
	function is_password($password, $cpassword) {
		global $MOD;
		if(!$password) return $this->_('会员登录密码不能为空');
		if($password != $cpassword) return $this->_('两次输入的密码不一致');
		if(!$MOD['minpassword']) $MOD['minpassword'] = 6;
		if(!$MOD['maxpassword']) $MOD['maxpassword'] = 20;
		if(strlen($password) < $MOD['minpassword'] || strlen($password) > $MOD['maxpassword']) return $this->_('会员登录密码长度应在'.$MOD['minpassword'].'-'.$MOD['maxpassword'].'之间');
		return true;
	}

	function is_member($member) {
		if(!is_array($member)) return false;
		if($this->userid) {
			if($member['password'] && !$this->is_password($member['password'], $member['cpassword'])) return false;
		} else {
			if(!$this->is_username($member['username'])) return false;
			if(!$this->is_password($member['password'], $member['cpassword'])) return false;
		}
		if(!is_email($member['email'])) return $this->_('Email格式不正确');
		if($this->email_exists($member['email'])) return $this->_('邮件地址已经存在');
		if(empty($member['company'])) return $this->_('请填写公司名称');
		if($this->company_exists($member['company'])) return $this->_('公司名称已经存在');
		if(!$member['groupid']) return $this->_('请选择会员组');
		if(empty($member['truename'])) return $this->_('请填写真实姓名');
		if(empty($member['type'])) return $this->_('请选择公司类型');
		if(!$member['areaid']) return $this->_('请选择公司所在地区');
		if(!$member['catid']) return $this->_('请选择公司所属行业');
		if(empty($member['regyear']) || strlen($member['regyear']) != 4 || !is_numeric($member['regyear'])) return $this->_('请填写公司注册年份');
		if(empty($member['regcity'])) return $this->_('请填写公司注册地');
		if(empty($member['address'])) return $this->_('请填写公司主要经营地点');
		if(empty($member['telephone'])) return $this->_('请填写公司电话');
		if(isset($member['msn']) && $member['msn'] && !is_email($member['msn'])) return $this->_('MSN格式不正确');
		if(isset($member['mail']) && $member['mail'] && !is_email($member['mail'])) return $this->_('公司邮件格式不正确');
		if(isset($member['qq']) && $member['qq'] && !is_numeric($member['qq'])) return $this->_('QQ格式不正确');
		if(isset($member['postcode']) && $member['postcode'] && !is_numeric($member['postcode']))  return $this->_('邮政编码格式不正确');
		return true;
	}

	function set_member($member) {
		global $MOD;
		$member['capital'] = isset($member['capital']) ? dround($member['capital']) : '';
		$member['mode'] = (isset($member['mode']) && $member['mode']) ? implode(',', $member['mode']) : '';
		$member['keyword'] = $member['company'].','.strip_tags(cat_pos($member['catid'], ',')).strip_tags(area_pos($member['areaid'], ',')).','.$member['regcity'].','.$member['business'].','.$member['sell'].','.$member['buy'].','.$member['mode'];
		//clear uploads
		clear_upload($member['thumb'].$member['banner'].$member['introduce']);
		if($this->userid) {
			$new = $member['introduce'];
			if($member['thumb']) $new .= '<img src="'.$member['thumb'].'">';
			if($member['banner']) $new .= '<img src="'.$member['banner'].'">';
			$r = $this->db->get_one("SELECT content FROM {$this->tb_company_data} WHERE userid=$this->userid");
			$old = $r['content'];
			$r = $this->get_one();
			if($r['thumb']) $old .= '<img src="'.$r['thumb'].'">';
			if($r['banner']) $old .= '<img src="'.$r['banner'].'">';
			delete_diff($new, $old);
		}
		if(!defined('DT_ADMIN')) {
			$introduce = dsafe($member['introduce']);
			unset($member['introduce']);
			$member = dhtmlspecialchars($member);
			$member['introduce'] = $introduce;
		}
		if(isset($member['css'])) $member['css'] = preg_replace("/(import|expression|:\/)/i", '', $member['css']);
		$member['content'] = $member['introduce'];
		$member['introduce'] = dsubstr(strip_tags($member['introduce']), $MOD['introduce_length']);
		return $member;
	}

	function email_exists($email) {
		$condition = "email='$email'";
		if($this->userid) $condition .= " AND userid!=$this->userid";
		return $this->db->get_one("SELECT userid FROM {$this->tb_member} WHERE $condition limit 0,1");
	}

	function username_exists($username) {
		return $this->db->get_one("SELECT userid FROM {$this->tb_member} WHERE username='$username' limit 0,1");
	}

	function company_exists($company) {
		$condition = "company='$company'";
		if($this->userid) $condition .= " AND userid!=$this->userid";
		return $this->db->get_one("SELECT userid FROM {$this->tb_company} WHERE $condition limit 0,1");
	}

	function add($member) {
		global $DT, $DT_TIME, $DT_IP;
		if(!$this->is_member($member)) return false;
		$member = $this->set_member($member);		
		$member['linkurl'] = userurl($member['username']);
		$member['password'] = md5(md5($member['password']));
		$member_fields = array('username','company','password','email','gender','truename','mobile','msn','qq','department','career','groupid');
		$company_fields = array('username','groupid','company','type','catid','areaid', 'mode','capital','regunit','size','regyear','regcity','sell','buy','business','telephone','fax','mail','address','postcode','homepage','introduce','thumb','keyword','linkurl');
		$member_sqlk = $member_sqlv = $company_sqlk = $company_sqlv = '';
		foreach($member as $k=>$v) {
			if(in_array($k, $member_fields)) {$member_sqlk .= ','.$k; $member_sqlv .= ",'$v'";}
			if(in_array($k, $company_fields)) {$company_sqlk .= ','.$k; $company_sqlv .= ",'$v'";}
		}
        $member_sqlk = substr($member_sqlk, 1);
        $member_sqlv = substr($member_sqlv, 1);
        $company_sqlk = substr($company_sqlk, 1);
        $company_sqlv = substr($company_sqlv, 1);
		$this->db->query("INSERT INTO {$this->tb_member} ($member_sqlk,regip,regtime,loginip,logintime)  VALUES ($member_sqlv,'$DT_IP','$DT_TIME','$DT_IP','$DT_TIME')");
		$this->userid = $this->db->insert_id();
		$this->username = $member['username'];
	    $this->db->query("INSERT INTO {$this->tb_company} (userid, $company_sqlk) VALUES ('$this->userid', $company_sqlv)");
	    $this->db->query("INSERT INTO {$this->tb_company_data} (userid, content) VALUES ('$this->userid', '$member[content]')");
		return $this->userid;
	}

	function edit($member)	{
		if(!$this->is_member($member)) return false;
		$member = $this->set_member($member);
		$r = $this->get_one();
		$member['linkurl'] = userurl($r['username'], $member['domain']);
		$member_fields = array('password','company','email','msn','qq','gender','truename','mobile','department','career','groupid');
		$company_fields = array('company','type','areaid', 'catid','business','mode','regyear','regunit','capital','size','regcity','address','postcode','telephone','fax','mail','homepage','sell','buy','introduce','thumb','keyword','banner','css','linkurl','groupid', 'domain');
		if($member['password']) {
			$member['password'] = md5(md5($member['password']));
		} else {
			unset($member_fields[0]);
		}
		$member_sql = $company_sql = '';
		foreach($member as $k=>$v) {
			if(in_array($k, $member_fields)) $member_sql .= ",$k='$v'";
			if(in_array($k, $company_fields)) $company_sql .= ",$k='$v'";
		}
        $member_sql = substr($member_sql, 1);
        $company_sql = substr($company_sql, 1);
	    $this->db->query("UPDATE {$this->tb_member} SET $member_sql WHERE userid=$this->userid");
	    $this->db->query("UPDATE {$this->tb_company} SET $company_sql WHERE userid=$this->userid");
	    $this->db->query("UPDATE {$this->tb_company_data} SET content='$member[content]' WHERE userid=$this->userid");
		return true;
	}

	function get_one($username = '') {
		$condition = $username ? "m.username='$username'" : "m.userid='$this->userid'";
        return $this->db->get_one("SELECT * FROM {$this->tb_member} m,{$this->tb_company} c WHERE m.userid=c.userid AND $condition limit 0,1");
	}

	function get_list($condition, $order = 'userid DESC') {
		global $pages, $page, $pagesize, $offset;
		$r = $this->db->get_one("SELECT COUNT(*) AS num FROM {$this->tb_member} WHERE $condition");
		$pages = pages($r['num'], $page, $pagesize);
		$members = array();
		$result = $this->db->query("SELECT * FROM {$this->tb_member} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $this->db->fetch_array($result)) {
			$r['logindate'] = timetodate($r['logintime'], 5);
			$r['regdate'] = timetodate($r['regtime'], 5);
			$members[] = $r;
		}
		return $members;
	}

	function login($login_username, $login_password, $login_cookietime = 0) {
		global $CFG, $DT_TIME, $DT_IP, $MOD;
		if(!preg_match("/^[a-z0-9]+$/i", $login_username)) return $this->_('用户名格式错误');
		if(!$MOD || !isset($MOD['login_times'])) $MOD = cache_read('module-2.php');
		$login_lock = ($MOD['login_times'] && $MOD['lock_hour']) ? true : false;
		$LOCK = array();
		if($login_lock) {
			$LOCK = cache_read($DT_IP.'.php', 'lock');
			if($LOCK) {
				if($DT_TIME - $LOCK['time'] < $MOD['lock_hour']*3600) {
					if($LOCK['times'] >= $MOD['login_times']) return $this->_('累计'.$MOD['login_times'].'次错误尝试 您在'.$MOD['lock_hour'].'小时内不能登录系统');
				} else {
					$LOCK = array();
					cache_delete($DT_IP.'.php', 'lock');
				}
			}
		}
		$user = $this->db->get_one("SELECT * FROM {$this->tb_member} WHERE username='$login_username' limit 0,1");
		if(!$user) {
			$this->lock($login_lock, $LOCK, $DT_IP, $DT_TIME);
			return $this->_('会员不存在');
		}
		if($user['password'] != (is_md5($login_password) ? md5($login_password) : md5(md5($login_password)))) {
			$this->lock($login_lock, $LOCK, $DT_IP, $DT_TIME);
			return $this->_('密码错误,请重试');
		}
		if($user['groupid'] == 2) return $this->_('该帐号已被禁止访问');
		if($user['groupid'] == 4) return $this->_('该帐号尚在审核中');
		$cookietime = $login_cookietime ? $DT_TIME + intval($login_cookietime) : 0;
		$auth = dcrypt($user['userid']."\t".$user['username']."\t".$user['groupid']."\t".$user['password'], 0, md5($CFG['authkey'].$_SERVER['HTTP_USER_AGENT']));
		set_cookie('auth', $auth, $cookietime);
		$this->db->query("UPDATE {$this->tb_member} SET loginip='$DT_IP',logintime=$DT_TIME,logintimes=logintimes+1 WHERE username='$login_username'");
		return $user;
	}

	function lock($login_lock, $LOCK, $DT_IP, $DT_TIME) {
		if($login_lock && $DT_IP) {
			$LOCK['time'] = $DT_TIME;
			$LOCK['times'] = isset($LOCK['times']) ? $LOCK['times']+1 : 1;
			cache_write($DT_IP.'.php', $LOCK, 'lock');
		}
	}

	function logout() {
		set_cookie('auth', '');
		return true;
	}

	function delete($userid) {
		global $DT_PRE, $CFG;
		if(!$userid) return false;
		if($userid == 1 || $userid == $CFG['founderid']) return $this->_('创始人不可删除');
		$userids = is_array($userid) ? implode(',', $userid) : intval($userid);
		$this->db->query("DELETE FROM {$this->tb_member} WHERE userid IN ($userids)");
		$this->db->query("DELETE FROM {$this->tb_company} WHERE userid IN ($userids)");
		$this->db->query("DELETE FROM {$this->tb_company_data} WHERE userid IN ($userids)");
		$this->db->query("DELETE FROM {$DT_PRE}admin WHERE userid IN ($userids)");
		return true;
	}

	function move($userid, $groupid) {
		if(!isset($userid) || !$userid || !$groupid) return false;
		$userids = is_array($userid) ? implode(',', $userid) : intval($userid);
		$this->db->query("UPDATE {$this->tb_member} SET groupid='$groupid' WHERE userid IN ($userids)");
		$this->db->query("UPDATE {$this->tb_company} SET groupid='$groupid' WHERE userid IN ($userids)");
		return true;
	}

	function check($userid) {
		if(is_array($userid)) {
			foreach($userid as $v) { $this->check($v); }
		} else {
			$this->db->query("UPDATE {$this->tb_member} SET groupid=5 WHERE userid=$userid");
			$this->db->query("UPDATE {$this->tb_company} SET groupid=5 WHERE userid=$userid");
			return true;
		}
	}

	function mk_auth($username) {
		$auth = strtoupper(md5($username.random(10)));
	    $this->db->query("UPDATE {$this->tb_member} SET auth='$auth' WHERE username='$username'");
		return $auth;
	}

	function ck_auth($auth) {
        $r = $this->db->get_one("SELECT auth,username FROM {$this->tb_member} WHERE auth='$auth'");
		return $r ? $r['username'] : '';
	}

	function _($e) {
		$this->errmsg = $e;
		return false;
	}
}
?>