<?php
/*
	[Destoon B2B System] Copyright (c) 2009 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_DESTOON') or exit('Access Denied');
class dsession {
	var $lifetime = 1800;
	var $pre;
	var $db;
	var $time;

    function dsession() {
    	session_set_save_handler(array(&$this,'open'), array(&$this,'close'), array(&$this,'read'), array(&$this,'write'), array(&$this,'destroy'), array(&$this,'gc'));
		session_cache_limiter('private, must-revalidate');
		session_start();
    }

    function open($save_path, $session_name) {
		global $db, $DT_PRE, $DT_TIME;
	    $this->time = $DT_TIME;
		$this->pre = $DT_PRE;
		$this->db = &$db;
		return true;
    }

    function close() {
		$this->gc();
        return true;
    } 

    function read($sid) {
		$r = $this->db->get_one("SELECT data FROM {$this->pre}session WHERE sessionid='$sid'");
		return $r ? $r['data'] : '';
    } 

    function write($sid, $sess_data) {
		$sess_data = addslashes($sess_data);
        $this->db->query("REPLACE INTO {$this->pre}session (sessionid,data,lastvisit) VALUES('$sid', '$sess_data', '$this->time')");
		return true;
    } 

    function destroy($sid) { 
		$this->db->query("DELETE FROM {$this->pre}session WHERE sessionid='$sid'");
		return true;
    } 

	function gc() {
		$expiretime = $this->time-$this->lifetime;
		$this->db->query("DELETE FROM {$this->pre}session WHERE lastvisit<$expiretime");
		return true;
    }
}
?>