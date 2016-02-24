<?php
/*
	[Destoon B2B System] Copyright (c) 2009 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
@set_time_limit(0);
@ignore_user_abort(true);
require './common.inc.php';
include template('line');
$html = (isset($html) && in_array($html, array('index', 'list', 'show'))) ? $html : '';
if($html) {
	$task_index = $DT['task_index'] ? $DT['task_index'] : 600;
	$task_list = $DT['task_list'] ? $DT['task_list'] : 3600;
	$task_item = $DT['task_item'] ? $DT['task_item'] : 36000;
	if($moduleid == 1) {
		if($DT['index_html'] && $DT_TIME - @filemtime(DT_ROOT.'/'.$DT['index'].'.'.$DT['file_ext']) > $task_index) tohtml('index');
	} else {
		$task_file = DT_ROOT.'/module/'.$module.'/task.inc.php';
		if(is_file($task_file)) include $task_file;
	}
}
?>