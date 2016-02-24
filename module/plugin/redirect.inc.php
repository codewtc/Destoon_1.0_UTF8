<?php 
defined('IN_DESTOON') or exit('Access Denied');
$url = isset($url) ? (strpos($url, '://') !== false ? $url : 'http://'.$url) : DT_PATH;
if(isset($username)) {
	if(preg_match("/^[a-z0-9]+$/i", $username)) {
		$r = $db->get_one("SELECT linkurl FROM {$DT_PRE}company WHERE username='$username'");
		if($r) $url = $r['linkurl'] ? $r['linkurl'] : userurl($username);
	}
} else if(isset($aid)) {
	$aid = intval($aid);
	if($aid) {
		$r = $db->get_one("SELECT url FROM {$DT_PRE}ad WHERE aid=$aid AND url!='' AND fromtime<$DT_TIME AND totime>$DT_TIME");
		if($r) {
			$url = $r['url'];
			$db->query("UPDATE {$DT_PRE}ad SET hits=hits+1 WHERE aid=$aid");
		}
	}
}
header('location:'.$url);
?>