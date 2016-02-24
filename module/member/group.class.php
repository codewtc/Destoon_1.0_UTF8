<?php 
defined('IN_DESTOON') or exit('Access Denied');
class group {
	var $groupid;
	var $groupname;
	var $vip;
	var $db;
	var $pre;

	function group() {
		global $db, $DT_PRE;
		$this->pre = $DT_PRE;
		$this->db = &$db;
	}

	function add($setting) {
		if(!is_array($setting)) return false;
		$this->db->query("INSERT INTO {$this->pre}group (groupname,vip) VALUES('$this->groupname','$this->vip')");
		$this->groupid = $this->db->insert_id();
		update_setting('group-'.$this->groupid, $setting);
		cache_group();
		return $this->groupid;
	}

	function edit($setting) {
		if($this->groupid < 4) return false;
		if(!is_array($setting)) return false;
		update_setting('group-'.$this->groupid, $setting);
		$setting = addslashes(serialize(dstripslashes($setting)));
		$this->db->query("UPDATE {$this->pre}group SET groupname='$this->groupname',vip='$this->vip' WHERE groupid=$this->groupid");
		cache_group();
		return true;
	}

	function delete() {
		if($this->groupid < 5) return false;
		$this->db->query("DELETE FROM {$this->pre}group WHERE groupid=$this->groupid");
		cache_delete('group-'.$this->groupid.'.php');
		cache_group();
		return true;
	}

	function get_one() {
		$r = $this->db->get_one("SELECT * FROM {$this->pre}group WHERE groupid=$this->groupid");
		$tmp = get_setting('group-'.$this->groupid);
		if($tmp) {
			foreach($tmp as $k=>$v) {
				$r[$k] = $v;
			}
		}
		return $r;
	}
}
?>