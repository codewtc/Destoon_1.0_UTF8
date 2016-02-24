<?php
defined('IN_DESTOON') or exit('Access Denied');
function money_add($username, $amount) {
	global $db, $DT_PRE;
	$db->query("UPDATE {$DT_PRE}member SET money=money+{$amount} WHERE username='$username'");
}

function money_lock($username, $amount) {
	global $db, $DT_PRE;
	$db->query("UPDATE {$DT_PRE}member SET money_lock=money_lock+{$amount} WHERE username='$username'");
}

function record_add($username, $amount, $bank, $editor, $reason, $note = '') {
	global $db, $DT_PRE, $DT_TIME;
	$db->query("INSERT INTO {$DT_PRE}finance_record (username,bank,amount,addtime,reason,note,editor) VALUES ('$username','$bank','$amount','$DT_TIME','$reason','$note','$editor')");
}

function secondstodate($seconds) {
	$date = '';
	$t = floor($seconds/86400);
	if($t) {
		$date .= $t.'天';
		$seconds = $seconds%86400;
	}
	$t = floor($seconds/3600);
	if($t) {
		$date .= $t.'小时';
		$seconds = $seconds%3600;
	}
	$t = floor($seconds/60);
	if($t) {
		$date .= $t.'分钟';
	}
	return $date;
}
?>