<?php 
require './config.inc.php';
require '../common.inc.php';
login();
$mid = isset($mid) ? intval($mid) : 0;
if($mid) {
	$MYGROUP = cache_read('group-'.$_groupid.'.php');
	$MYMODS = array();
	if(isset($MYGROUP['moduleids']) && $MYGROUP['moduleids']) {
		$MYMODS = explode(',', $MYGROUP['moduleids']);
	}
	if(!$MYMODS || !in_array($mid, $MYMODS)) message('', $MODULE[2]['linkurl']);
	$IMVIP = isset($MYGROUP['vip']) && $MYGROUP['vip']; 
	$moduleid = $mid;
	$module = $MODULE[$moduleid]['module'];
	if(!$module) message();
	$MOD = cache_read('module-'.$moduleid.'.php');
	$my_file = DT_ROOT.'/module/'.$module.'/my.inc.php';
	if(file_exists($my_file)) {
		require $my_file;
	} else {
		message('', $MODULE[2]['linkurl']);
	}
} else {
	require DT_ROOT.'/module/'.$module.'/my.inc.php';
}
?>