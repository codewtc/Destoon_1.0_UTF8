<?php 
defined('IN_DESTOON') or exit('Access Denied');
$filename = DT_ROOT.'/'.$MOD['moduledir'].'/rss.xml';
$rss_num = $MOD['rss_num'] ? $MOD['rss_num'] : 0;
if($rss_num) {
	$rss_title = ($MOD['seo_title'] ? $MOD['seo_title'] : $MOD['name']).' - '.$DT['sitename'];
	$rss_link = linkurl($MOD['linkurl'], 1);
	$rss_mode = $MOD['rss_mode'] ? 1 : 0;
	$rss_length = $MOD['rss_length'] ? $MOD['rss_length'] : 200;
	$rss = array();
	$result = $db->query("SELECT * FROM {$table} t,{$table_data} d WHERE t.status=3 AND t.itemid=d.itemid ORDER BY t.itemid DESC LIMIT 0,$rss_num");
	while($r = $db->fetch_array($result)) {
		$r['title'] = $r['title'].' ['.timetodate($r['fromtime'], 3).'~'.timetodate($r['totime'], 3).']';
		$r['pubdate'] = timetodate($r['addtime']);
		if($r['linkurl'] && strpos($r['linkurl'], '://') === false) $r['linkurl'] = linkurl($MOD['linkurl'].$r['linkurl'], 1);
		$r['description'] = $rss_mode ? dsubstr(($r['introduce'] ? $r['introduce'] : $r['content']), $rss_length) : $r['content'];
		$r['description'] = strip_nr(strip_tags($r['description']));
		$r['description'] = preg_replace("/\&([^;]+);/i", '', $r['description']);
		$rss[] = $r;
	}
	ob_start();
	include template('rss');
	$data = ob_get_contents();
	ob_clean();
	file_put($filename, $data);
} else {
	if(is_file($filename)) unlink($filename);
}
return true;
?>