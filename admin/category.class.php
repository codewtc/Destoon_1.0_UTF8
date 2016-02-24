<?php
/*
	[Destoon B2B System] Copyright (c) 2009 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_DESTOON') or exit('Access Denied');
class category {
	var $moduleid;
	var $catid;
	var $category = array();
	var $db;
	var $pre;
	var $errmsg = errmsg;

	function category($moduleid = 1, $catid = 0) {
		global $db, $DT_PRE, $CATEGORY;
		$this->moduleid = $moduleid;
		$this->catid = $catid;
		if(!isset($CATEGORY)) $CATEGORY = cache_read('category-'.$this->moduleid.'.php');
		$this->category = $CATEGORY;
		$this->pre = $DT_PRE;
		$this->db = &$db;
	}

	function pass($category, $edit = 0) {
		if(!is_array($category)) return false;
		if(!$category['catname']) return $this->_('请填写栏目名称');
		if(!$category['catdir']) return $this->_('请填写栏目目录[英文名]');
		if(!preg_match("/^[0-9a-z_-]+$/i", $category['catdir'])) return $this->_('目录名不合法,请更换一个再试');
		if($edit) {
			if($this->db->get_one("SELECT catid FROM {$this->pre}category WHERE catdir='$category[catdir]' AND moduleid='$this->moduleid' AND catid!=$this->catid")) return $this->_('目录名已经被使用,请更换一个再试');
		} else {
			if($this->db->get_one("SELECT catid FROM {$this->pre}category WHERE catdir='$category[catdir]' AND moduleid='$this->moduleid'")) return $this->_('目录名已经被使用,请更换一个再试');
		}
		return true;
	}

	function add($category)	{
		if(!$this->pass($category)) return false;
		$category['moduleid'] = $this->moduleid;
		$category['letter'] = preg_match("/^[a-z]{1}+$/i", $category['letter']) ? strtolower($category['letter']) : '';
		$sqlk = $sqlv = '';
		foreach($category as $k=>$v) {
			$sqlk .= ','.$k; $sqlv .= ",'$v'"; 
		}
        $sqlk = substr($sqlk, 1);
        $sqlv = substr($sqlv, 1);
		$this->db->query("INSERT INTO {$this->pre}category ($sqlk) VALUES ($sqlv)");		
		$this->catid = $this->db->insert_id();
		if($category['parentid']) {
			$category['arrparentid'] = $this->category[$category['parentid']]['arrparentid'].','.$category['parentid'];
			$category['parentdir'] = $this->category[$category['parentid']]['parentdir'].$this->category[$category['parentid']]['catdir'].'/';
			$parentids = explode(',', $category['arrparentid']);
			foreach($parentids as $parentid) {
				if($parentid) {
					$arrchildid = $this->category[$parentid]['arrchildid'].','.$this->catid;
					$this->db->query("UPDATE {$this->pre}category SET child=1,arrchildid='$arrchildid' WHERE catid='$parentid'");
				}
			}
		} else {
			$category['arrparentid'] = '0';
			$category['parentdir'] = '/';
		}
		$this->db->query("UPDATE {$this->pre}category SET arrchildid='$this->catid',listorder=$this->catid,arrparentid='$category[arrparentid]',parentdir='$category[parentdir]' WHERE catid=$this->catid");
		$this->cache();
		return true;
	}

	function edit($category) {
		if(!$this->pass($category, 1)) return false;
		$category['letter'] = preg_match("/^[a-z]{1}+$/i", $category['letter']) ? strtolower($category['letter']) : '';
		$sql = '';
		foreach($category as $k=>$v) {
			$sql .= ",$k='$v'";
		}
		$sql = substr($sql, 1);
		$this->db->query("UPDATE {$this->pre}category SET $sql where catid=$this->catid");
		$this->cache();
		if($category['parentid'] != $this->category[$catid]['parentid']) {
			$this->category = cache_read('category-'.$this->moduleid.'.php');
			$this->repair();
			$this->category = cache_read('category-'.$this->moduleid.'.php');
			$this->repair();
		}
		return true;
	}

	function delete() {
		if(!isset($this->category[$this->catid])) return false;
        $arrparentid = $this->category[$this->catid]['arrparentid'];
        $arrchildid = $this->category[$this->catid]['arrchildid'];
		$this->db->query("DELETE FROM {$this->pre}category WHERE catid IN ($arrchildid)");
		$catids = explode(',', $arrchildid);
		foreach($catids as $id) {
			cache_delete('category_'.$id.'.php');
            unset($this->category[$id]);
		}
		if($arrparentid) {
		    $arrparentids = explode(',', $arrparentid);
			foreach($arrparentids as $id) {
				if($id == 0) continue;
			    $arrchildid = $this->get_arrchildid($id);
			    $child = is_numeric($arrchildid) ? 0 : 1;                   
			    $this->db->query("UPDATE {$this->pre}category SET arrchildid='$arrchildid',child='$child' WHERE catid='$id'");
			}
		}
		$this->cache();
		return true;
	}

	function update($category) {
	    if(!is_array($category)) return false;
		foreach($category as $k=>$v) {
			if(!$v['catname']) continue;
			$v['listorder'] = intval($v['listorder']);
			$this->db->query("UPDATE {$this->pre}category SET catname='$v[catname]',listorder='$v[listorder]',style='$v[style]' WHERE catid=$k ");
		}
		$this->cache();
		return true;
	}

	function repair() {
		foreach($this->category as $catid => $category) {
			if($catid == 0) continue;
			$this->catid = $catid;
			$arrparentid = $this->get_arrparentid($catid);
			$parentdir = $this->get_parentdir($catid);
			$arrchildid = $this->get_arrchildid($catid);
			$child = is_numeric($arrchildid) ? 0 : 1;
			$this->db->query("UPDATE {$this->pre}category SET arrparentid='$arrparentid',parentdir='$parentdir',arrchildid='$arrchildid',child='$child' WHERE catid=$catid");
		}
		$this->cache();
        return true;
	}

	function get_arrparentid($catid, $arrparentid = '') {
		if(is_array($this->category)) {
			$parentid = $this->category[$catid]['parentid'];
			$arrparentid = $arrparentid ? $parentid.",".$arrparentid : $parentid;
			if($parentid) {
				$arrparentid = $this->get_arrparentid($parentid, $arrparentid);
			} else {
				$this->category[$catid]['arrparentid'] = $arrparentid;
			}
		}
		return $arrparentid;
	}

	function get_arrchildid($catid) {
		$arrchildid = $catid;
		if(is_array($this->category)) {
			foreach($this->category as $id=>$category) {
				if($category['parentid'] && $id != $catid) {
					$arrparentids = explode(',', $category['arrparentid']);
					if(in_array($catid,$arrparentids)) $arrchildid .= ','.$id;
				}
			}
		}
		return $arrchildid;
	}

	function get_parentdir($catid) {
		if($this->category[$catid]['parentid'] == 0) return '/';
		$arrparentid = $this->category[$catid]['arrparentid'];
		$arrparentid = explode(",",$arrparentid);
		foreach($arrparentid as $id) {
			if($id == 0) continue;
			$arrcatdir[$id] = $this->category[$id]['catdir'];
		}
		return '/'.implode('/',$arrcatdir).'/';
	}

	function get_letter($catname) {
		return substr(gb2py($catname), 0, 1);
	}

	function cache() {
		cache_category($this->moduleid);
	}

	function _($e) {
		$this->errmsg = $e;
		return false;
	}
}
?>