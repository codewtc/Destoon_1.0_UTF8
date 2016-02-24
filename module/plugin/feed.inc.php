<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$FD = array();
foreach($MODULE as $m) {
	if(is_file(DT_ROOT.'/'.$m['moduledir'].'/rss.xml')) {
		$m['linkurl'] = linkurl($m['linkurl'], 1);
		$m['feedtime'] = timetodate(filemtime(DT_ROOT.'/'.$m['moduledir'].'/rss.xml'), 5);
		$FD[] = $m;
	}
}
$head_title = $head_keywords = $head_description = 'RSS订阅';
include template('feed', $module);
if($CFG['cache_page']) cache_page();
?>