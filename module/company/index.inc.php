<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$username = $urlsp = '';
if(isset($homepage) && preg_match("/^[a-z0-9]+$/", $homepage)) {
	$username = $homepage;
	$urlsp = '&homepage='.$username;
} else if($CFG['com_domain']) {
	$host = $_SERVER['HTTP_HOST'];
	if(strpos(DT_URL, $host) === false && strpos($MOD['linkurl'], $host) === false) {
		$www = str_replace($CFG['com_domain'], '', $host);
		if(preg_match("/^[a-z0-9]+$/", $www)) {
			$username = $homepage = $www;
		} else {
			$c = $db->get_one("SELECT username FROM {$DT_PRE}company WHERE domain='$_SERVER[HTTP_HOST]'");
			if($c) $username = $homepage = $c['username'];
		}
	}
}

if($username) {
	$COM = $db->get_one("SELECT * FROM {$table} c, {$table_member} m WHERE c.userid=m.userid AND c.username='$username' AND m.groupid>4");
	if(!$COM) {
		$head_title = '公司不存在';
		include template('notfound', $module);
		exit;
	}
	$COMGROUP = cache_read('group-'.$COM['groupid'].'.php');
	if(!isset($COMGROUP['homepage']) || !$COMGROUP['homepage']) {
		$COM['thumb'] = $COM['thumb'] ? $COM['thumb'] : SKIN_PATH.'image/company.jpg';
		$head_title = $COM['company'];
		$head_keywords = $COM['keyword'];
		$head_description = $COM['introduce'];
		$member = $COM;
		$content = $db->get_one("SELECT content FROM {$DT_PRE}company_data WHERE userid=$member[userid]");
		$content = $content['content'];
		include template('show', $module);
		exit;
	}
	$COM['year'] = $COM['fromtime'] ? intval(date('Y', $DT_TIME) - date('Y', $COM['fromtime'])) + 1  : 1;
	isset($file) or $file = 'homepage';
	isset($action) or $action = '';
	in_array($file, array('homepage', 'sell', 'introduce', 'product', 'buy', 'news', 'credit', 'contact', 'guestbook')) or message('', $MOD['linkurl']);
	$skin = $COM['skin'] ? $COM['skin'] : 'default';
	$template = $COM['template'] ? $COM['template'] : 'homepage';
	$MENU = array(
		'index'     => array("公司首页", $COM['linkurl']),
		'news'      => array("公司新闻", rewrite('index.php?file=news'.$urlsp)),
		'product'   => array("产品展示", rewrite('index.php?file=product'.$urlsp)),
		'sell'      => array("最新供应", rewrite('index.php?file=sell'.$urlsp)),
		'buy'       => array("采购清单", rewrite('index.php?file=buy'.$urlsp)),
		'introduce' => array("公司介绍", rewrite('index.php?file=introduce'.$urlsp)),
		'credit'    => array("荣誉资质", rewrite('index.php?file=credit'.$urlsp)),
		'contact'   => array("联系方式", rewrite('index.php?file=contact'.$urlsp)),
		'guestbook' => array("留 言 本", rewrite('index.php?file=guestbook'.$urlsp)),
		);
	$head_title = '';
	$head_keywords = $COM['company'];
	$head_description = $COM['introduce'];
	(@include MOD_ROOT.'/'.$file.'.inc.php') or message('', $MOD['linkurl']);
} else {
	$head_title = $MOD['seo_title'] ? $MOD['seo_title'] : $MOD['name'];
	$head_keywords = $MOD['seo_keywords'] ? $MOD['seo_keywords'] : $DT['seo_keywords'];
	$head_description = $MOD['seo_description'] ? $MOD['seo_description'] : $DT['seo_description'];
	$template = $MOD['template'] ? $MOD['template'] : 'index';
	include template($template, $module);
}
?>