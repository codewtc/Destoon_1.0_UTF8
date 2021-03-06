<?php 
defined('IN_DESTOON') or exit('Access Denied');
class credit {
	var $itemid;
	var $db;
	var $table;
	var $fields;
	var $errmsg = errmsg;

    function credit() {
		global $db, $DT_PRE;
		$this->table = $DT_PRE.'credit';
		$this->db = &$db;
		$this->fields = array('title','style','authority','thumb','status','username','addtime','eidtor','edittime','fromtime','totime','note');
    }

	function pass($post) {
		global $DT_TIME;
		if(!is_array($post)) return false;
		if(!$post['title']) return $this->_('请填写证书名称');
		if(!$post['authority']) return $this->_('请填写发证机构');
		if(!$post['thumb']) return $this->_('请上传证书图片');
		if(!$post['fromtime'] || !is_date($post['fromtime'])) return $this->_('请选择证书发证时间');
		if(strtotime($post['fromtime'].' 00:00:00') > $DT_TIME) return $this->_('证书发证时间必须在当前时间之前');
		if(!$post['totime'] || !is_date($post['totime'])) return $this->_('请选择证书到期时间');
		if(strtotime($post['totime'].' 23:59:59') < $DT_TIME) return $this->_('证书到期时间必须在当前时间之后');
		return true;
	}

	function set($post) {
		global $MOD, $DT_TIME, $_username, $_userid;
		$post['addtime'] = (isset($post['addtime']) && $post['addtime']) ? strtotime($post['addtime']) : $DT_TIME;
		$post['edittime'] = $DT_TIME;
		$post['fromtime'] = strtotime($post['fromtime'].' 00:00:00');
		$post['totime'] = strtotime($post['totime'].' 23:59:59');
		//clear uploads
		clear_upload($post['content'].$post['thumb']);
		if($this->itemid) {
			$post['editor'] = $_username;
			$new = $post['content'];
			if($post['thumb']) $new .= '<img src="'.$post['thumb'].'">';
			$r = $this->get_one();
			$old = $r['content'];
			if($r['thumb']) $old .= '<img src="'.$r['thumb'].'">';
			delete_diff($new, $old);
		}
		if(!defined('DT_ADMIN')) {
			$post = dhtmlspecialchars($post);
		}
		return $post;
	}

	function get_one() {
        return $this->db->get_one("SELECT * FROM {$this->table} WHERE itemid='$this->itemid' limit 0,1");
	}

	function get_list($condition = 'status=3', $order = 'addtime DESC') {
		global $MOD, $pages, $page, $pagesize, $offset;
		$r = $this->db->get_one("SELECT COUNT(*) AS num FROM {$this->table} WHERE $condition");
		$pages = pages($r['num'], $page, $pagesize);		
		$lists = array();
		$result = $this->db->query("SELECT * FROM {$this->table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $this->db->fetch_array($result)) {
			$r['adddate'] = timetodate($r['addtime'], 5);
			$r['editdate'] = timetodate($r['edittime'], 5);
			$r['fromdate'] = timetodate($r['fromtime'], 3);
			$r['todate'] = timetodate($r['totime'], 3);
			$r['image'] = str_replace('.thumb.'.file_ext($r['thumb']), '', $r['thumb']);
			$r['title'] = set_style($r['title'], $r['style']);
			$lists[] = $r;
		}
		return $lists;
	}

	function add($post) {
		//if(!$this->pass($post)) return false;
		$post = $this->set($post);
		$sqlk = $sqlv = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) { $sqlk .= ','.$k; $sqlv .= ",'$v'"; }
		}
        $sqlk = substr($sqlk, 1);
        $sqlv = substr($sqlv, 1);
		$this->db->query("INSERT INTO {$this->table} ($sqlk) VALUES ($sqlv)");
		return $this->itemid;
	}

	function edit($post) {
		$post = $this->set($post);
		$sql = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) $sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
	    $this->db->query("UPDATE {$this->table} SET $sql WHERE itemid=$this->itemid");
		return true;
	}

	function recycle($itemid) {
		if(is_array($itemid)) {
			foreach($itemid as $v) { $this->recycle($v); }
		} else {
			$this->db->query("UPDATE {$this->table} SET status=0 WHERE itemid=$itemid");
			return true;
		}		
	}

	function delete($itemid, $all = true) {
		global $CFG, $MOD;
		if(is_array($itemid)) {
			foreach($itemid as $v) { $this->delete($v); }
		} else {
			$this->itemid = $itemid;
			$r = $this->get_one();
			$userid = get_user($r['username']);
			if($r['thumb']) delete_upload($r['thumb'], $userid);
			$this->db->query("DELETE FROM {$this->table} WHERE itemid=$itemid");
		}
	}

	function check($itemid) {
		global $_username, $DT_TIME;
		if(is_array($itemid)) {
			foreach($itemid as $v) { $this->check($v); }
		} else {
			$this->db->query("UPDATE {$this->table} SET status=3,editor='$_username',edittime=$DT_TIME WHERE itemid=$itemid");
			return true;
		}
	}

	function reject($itemid) {
		global $_username, $DT_TIME;
		if(is_array($itemid)) {
			foreach($itemid as $v) { $this->reject($v); }
		} else {
			$this->db->query("UPDATE {$this->table} SET status=1,editor='$_username',edittime=$DT_TIME WHERE itemid=$itemid");
			return true;
		}
	}

	function expire($condition = '') {
		global $DT_TIME;
		$this->db->query("UPDATE {$this->table} SET status=4 WHERE status=3 AND totime<$DT_TIME $condition");
	}

	function clear() {		
		$result = $this->db->query("SELECT itemid FROM {$this->table} WHERE status=0");
		while($r = $this->db->fetch_array($result)) {
			$this->delete($r['itemid']);
		}
	}
	
	function order($listorder) {
		if(!is_array($listorder)) return false;
		foreach($listorder as $k=>$v) {
			$k = intval($k);
			$v = intval($v);
			$this->db->query("UPDATE {$this->table} SET listorder=$v WHERE itemid=$k");
		}
		return true;
	}

	function _($e) {
		$this->errmsg = $e;
		return false;
	}
}
?>