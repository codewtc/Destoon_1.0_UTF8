<?php 
defined('IN_DESTOON') or exit('Access Denied');
$fileroot = DT_ROOT.'/'.$MOD['moduledir'].'/';
$filename = $fileroot.$DT['index'].'.'.$DT['file_ext'];
if(!$MOD['index_html']) {
	if(is_file($filename)) unlink($filename);
	return false;
}
$maincat = get_maincat(0, $CATEGORY);
$head_title = $MOD['seo_title'] ? $MOD['seo_title'] : $MOD['name'];
$head_keywords = $MOD['seo_keywords'] ? $MOD['seo_keywords'] : $DT['seo_keywords'];
$head_description = $MOD['seo_description'] ? $MOD['seo_description'] : $DT['seo_description'];
$template = $MOD['template'] ? $MOD['template'] : 'index';
$destoon_task = "moduleid=$moduleid&html=index";
ob_start();
include template($template, $module);
$data = ob_get_contents();
ob_clean();
file_put($filename, $data);
return true;
?>