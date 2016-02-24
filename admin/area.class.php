<?php
/*
	[Destoon B2B System] Copyright (c) 2009 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_DESTOON') or exit('Access Denied');
class area {
	var $areaid;
	var $area = array();
	var $db;
	var $pre;

	function area($areaid = 0)	{
		global $db, $DT_PRE, $AREA;
		$this->areaid = $areaid;
		if(!isset($AREA)) $AREA = cache_read('area.php');
		$this->area = $AREA;
		$this->pre = $DT_PRE;
		$this->db = &$db;
	}

	function add($area)	{
		if(!is_array($area)) return false;
		$sql1 = $sql2 = $s = '';
		foreach($area as $key=>$value) {
			$sql1 .= $s.$key;
			$sql2 .= $s."'".$value."'";
			$s = ',';
		}
		$this->db->query("INSERT INTO {$this->pre}area ($sql1) VALUES($sql2)");		
		$this->areaid = $this->db->insert_id();
		if($area['parentid']) {
			$area['arrparentid'] = $this->area[$area['parentid']]['arrparentid'].",".$area['parentid'];
			$parentids = explode(',', $area['arrparentid']);
			foreach($parentids as $parentid) {
				if($parentid) {
					$arrchildid = $this->area[$parentid]['arrchildid'].','.$this->areaid;
					$this->db->query("UPDATE {$this->pre}area SET child=1,arrchildid='$arrchildid' WHERE areaid='$parentid'");
				}
			}
		} else {
			$area['arrparentid'] = '0';
		}

		$arrparentid = $area['arrparentid'];
		$this->db->query("UPDATE {$this->pre}area SET arrchildid='$this->areaid',listorder=$this->areaid,arrparentid='$arrparentid' WHERE areaid=$this->areaid");
		cache_area();
		$this->area = cache_read('area.php');
		return true;
	}

	function delete() {
		if(!isset($this->area[$this->areaid])) return false;
        $arrparentid = $this->area[$this->areaid]['arrparentid'];
        $arrchildid = $this->area[$this->areaid]['arrchildid'];
		$this->db->query("DELETE FROM {$this->pre}area WHERE areaid IN ($arrchildid)");
		$areaids = explode(',', $arrchildid);
		foreach($areaids as $id) {
            unset($this->area[$id]);
		}
		if($arrparentid) {
		    $arrparentids = explode(',', $arrparentid);
			foreach($arrparentids as $id) {
				if($id == 0) continue;
			    $arrchildid = $this->get_arrchildid($id);
			    $child = is_numeric($arrchildid) ? 0 : 1;                   
			    $this->db->query("UPDATE {$this->pre}area SET arrchildid='$arrchildid',child='$child' WHERE areaid='$id'");
			}
		}
		cache_area();
		return true;
	}

	function update($area) {
	    if(!is_array($area)) return false;
		foreach($area as $k=>$v) {
			if(!$v['areaname']) continue;
			$v['listorder'] = intval($v['listorder']);
			$this->db->query("UPDATE {$this->pre}area SET areaname='$v[areaname]',listorder='$v[listorder]' WHERE areaid=$k ");
		}
		cache_area();
		return true;
	}

	function repair() {
		if(is_array($this->area)) {
			foreach($this->area as $areaid => $area) {
				if($areaid == 0) continue;
				$this->areaid = $areaid;
				$arrparentid = $this->get_arrparentid($areaid);
				$arrchildid = $this->get_arrchildid($areaid);
				$child = is_numeric($arrchildid) ? 0 : 1;
		        $this->db->query("UPDATE {$this->pre}area SET arrparentid='$arrparentid',arrchildid='$arrchildid',child='$child' WHERE areaid=$areaid");
			}
		}
		cache_area();
        return true;
	}

	function get_arrparentid($areaid, $arrparentid='') {
		if(is_array($this->area)) {
			$parentid = $this->area[$areaid]['parentid'];
			$arrparentid = $arrparentid ? $parentid.",".$arrparentid : $parentid;
			if($parentid) {
				$arrparentid = $this->get_arrparentid($parentid,$arrparentid);
			} else {
				$this->area[$areaid]['arrparentid'] = $arrparentid;
			}
		}
		return $arrparentid;
	}

	function get_arrchildid($areaid) {
		$arrchildid = $areaid;
		if(is_array($this->area)) {
			foreach($this->area as $id => $area) {
				if($area['parentid'] && $id != $areaid) {
					$arrparentids = explode(',', $area['arrparentid']);
					if(in_array($areaid,$arrparentids)) $arrchildid .= ','.$id;
				}
			}
		}
		return $arrchildid;
	}
}
?>