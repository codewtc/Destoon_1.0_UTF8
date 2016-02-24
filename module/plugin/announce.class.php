<?php 
defined('IN_DESTOON') or exit('Access Denied');
class announce {
	var $itemid;
	var $db;
	var $table;
	var $fields;
	var $errmsg = errmsg;

    function announce() {
		global $db, $DT_PRE;
		$this->table = $DT_PRE.'announce';
		$this->db = &$db;
		$this->fields = array('typeid', 'title','style','content','addtime','fromtime','totime','editor','edittime','template', 'islink', 'linkurl');
    }

	function pass($post) {
		if(!is_array($post)) return false;
		if(!$post['typeid']) return $this->_('请选择公告分类');
		if(!$post['title']) return $this->_('请填写公告标题');
		if(isset($post['islink'])) {
			if(!$post['linkurl']) return $this->_('请填写链接地址');
		} else {
			if(!$post['content']) return $this->_('请填写公告内容');
		}
		return true;
	}

	function set($post) {
		global $MOD, $DT_TIME, $_username, $_userid;
		$post['islink'] = isset($post['islink']) ? 1 : 0;
		$post['addtime'] = (isset($post['addtime']) && $post['addtime']) ? strtotime($post['addtime']) : $DT_TIME;
		$post['edittime'] = $DT_TIME;
		$post['editor'] = $_username;
		//clear link
		if($post['content'] && isset($post['clear_link'])) $post['content'] = preg_replace("/<a[^>]*>(.+)<\/a>/i", "\\1", $post['content']);
		//save pictures
		if($post['content'] && isset($post['save_remotepic'])) $post['content'] = addslashes(save_remote($post['content'], $MOD['moduledir']));
		//clear uploads
		clear_upload($post['content']);
		if($this->itemid) {
			$new = $post['content'];
			$r = $this->get_one();
			$old = $r['content'];
			delete_diff($new, $old);
		}
		if($post['fromtime']) $post['fromtime'] = strtotime($post['fromtime'].' 0:0:0');
		if($post['totime']) $post['totime'] = strtotime($post['totime'].' 23:59:59');
		return $post;
	}

	function get_one() {
        return $this->db->get_one("SELECT * FROM {$this->table} WHERE itemid='$this->itemid' limit 0,1");
	}

	function get_list($condition = '1', $order = 'listorder DESC,addtime DESC') {
		global $MOD, $TYPE, $pages, $page, $pagesize, $offset;
		$r = $this->db->get_one("SELECT COUNT(*) AS num FROM {$this->table} WHERE $condition");
		$pages = pages($r['num'], $page, $pagesize);		
		$lists = array();
		$result = $this->db->query("SELECT * FROM {$this->table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $this->db->fetch_array($result)) {
			$r['title'] = set_style($r['title'], $r['style']);
			$r['adddate'] = timetodate($r['addtime'], 5);
			$r['editdate'] = timetodate($r['edittime'], 5);
			$r['fromdate'] = $r['fromtime'] ? timetodate($r['fromtime'], 3) : '不限';
			$r['todate'] = $r['totime'] ? timetodate($r['totime'], 3) : '不限';
			$r['typename'] = $TYPE[$r['typeid']]['typename'];
			$r['linkurl'] = $r['islink'] ? $r['linkurl'] : $MOD['linkurl'].$r['linkurl'];
			$r['typeurl'] = $MOD['linkurl'].rewrite('announce.php?typeid='.$r['typeid']);
			$lists[] = $r;
		}
		return $lists;
	}

	function add($post) {
		global $DT, $MOD, $module;
		$post = $this->set($post);
		$sqlk = $sqlv = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) { $sqlk .= ','.$k; $sqlv .= ",'$v'"; }
		}
        $sqlk = substr($sqlk, 1);
        $sqlv = substr($sqlv, 1);
		$this->db->query("INSERT INTO {$this->table} ($sqlk) VALUES ($sqlv)");
		$this->itemid = $this->db->insert_id();
		if(!$post['islink']) {
			$linkurl = rewrite('announce.php?itemid='.$this->itemid);
			$this->db->query("UPDATE {$this->table} SET linkurl='$linkurl' WHERE itemid=$this->itemid");
		}
		return $this->itemid;
	}

	function edit($post) {
		global $DT, $MOD, $module;
		$post = $this->set($post);
		$sql = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) $sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
	    $this->db->query("UPDATE {$this->table} SET $sql WHERE itemid=$this->itemid");
		if(!$post['islink']) {
			$linkurl = rewrite('announce.php?itemid='.$this->itemid);
			$this->db->query("UPDATE {$this->table} SET linkurl='$linkurl' WHERE itemid=$this->itemid");
		}
		return true;
	}

	function update() {
		$result = $this->db->query("SELECT * FROM {$this->table} WHERE islink=0");
		while($r = $this->db->fetch_array($result)) {
			$itemid = $r['itemid'];
			$linkurl = rewrite('announce.php?itemid='.$itemid);
			$this->db->query("UPDATE {$this->table} SET linkurl='$linkurl' WHERE itemid=$itemid");
		}
		return true;
	}

	function delete($itemid, $all = true) {
		global $CFG;
		if(is_array($itemid)) {
			foreach($itemid as $v) { 
				$this->delete($v, $all); 
			}
		} else {
			$this->itemid = $itemid;
			$r = $this->get_one();
			if($all) {
				$userid = get_user($r['editor']);
				if($r['content']) delete_local($r['content'], $userid);
				$this->db->query("DELETE FROM {$this->table} WHERE itemid=$itemid");
			}
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