<?php
/*
	[Destoon B2B System] Copyright (c) 2009 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
//error_reporting(E_ALL);
set_magic_quotes_runtime(0);
if(defined('PARSE_STR')) {
	$pstr = '';
	if($_SERVER['QUERY_STRING']) {
		if(preg_match("/^(.*)\.html$/", $_SERVER['QUERY_STRING'], $_match)) {// list.php?catid-1-page-1.html && list-htm-catid-1-page-1.html
			$pstr = $_match[1];
		} else if(preg_match("/^(.*)\/$/", $_SERVER['QUERY_STRING'], $_match)) {// list.php?catid-1-page-1/
			$pstr = $_match[1];
		}
	} else if($_SERVER["REQUEST_URI"] != $_SERVER["SCRIPT_NAME"]) {// list.php/catid-1-page-1/
		$string = str_replace($_SERVER["SCRIPT_NAME"], '', $_SERVER["REQUEST_URI"]);
		if($string && preg_match("/^\/(.*)\/$/", $string, $_match)) $pstr = $_match[1];
	}
	if($pstr && strpos($pstr, '-') !== false) {
		$pstr = explode('-', $_match[1]);
		$pstr_count = count($pstr);
		if($pstr_count%2 == 1) --$pstr_count;
		for($i = 0; $i < $pstr_count; $i++) {
			$_GET[$pstr[$i]] = $pstr[++$i];
		}
	}
}
define('IN_DESTOON', true);
define('DT_ROOT', str_replace("\\", '/', dirname(__FILE__)));
require DT_ROOT.'/config.inc.php';
define('DT_PATH', $CFG['absurl'] ? $CFG['url'] : $CFG['path']);
define('DT_URL', $CFG['url']);
define('CACHE_ROOT', DT_ROOT.'/cache');
define('SKIN_PATH', DT_PATH.'skin/'.$CFG['skin'].'/');
define('VIP', $CFG['com_vip']);
define('errmsg', 'Invalid Request');
require DT_ROOT.'/version.inc.php';
require DT_ROOT.'/include/global.func.php';
$CFG['errlog'] ? set_error_handler('php_error') : error_reporting(0);

if(!get_magic_quotes_gpc()) {
	if($_POST) $_POST = daddslashes($_POST);
	if($_GET) $_GET = daddslashes($_GET);
	if($_FILES) $_FILES = daddslashes($_FILES);
}

$DT_PRE = $CFG['tb_pre'];
$DT_QST = $_SERVER['QUERY_STRING'];
$DT_TIME = time() + $CFG['timediff'];
$DT_IP = get_env('ip');
$DT_URL = get_env('url');
$DT_REF = get_env('referer');
if(function_exists('date_default_timezone_set')) date_default_timezone_set($CFG['timezone']);
header("Content-Type:text/html;charset=".$CFG['charset']);
if(!defined('DT_ADMIN')) {
	if($_POST) $_POST = strip_sql($_POST);
	if($_GET) $_GET = strip_sql($_GET);
	if($CFG['cache_page'] && !defined('DT_MEMBER')) {
		$cache_fileid = md5($DT_URL);
		$cache_root = CACHE_ROOT.'/php/'.substr($cache_fileid, 0, 2).'/';
		$cache_file = $cache_root.$cache_fileid.'.php';
		if(is_file($cache_file) && ($DT_TIME - filemtime($cache_file) < $CFG['page_expires'])) {
			include $cache_file; exit;
		}
	}
	$destoon_task = '';
}

require DT_ROOT.'/include/'.'db_'.$CFG['database'].'.class.php';
require DT_ROOT.'/include/session_'.$CFG['database'].'.class.php';
require DT_ROOT.'/include/file.func.php';

if($_POST) extract($_POST, EXTR_SKIP);
if($_GET) extract($_GET, EXTR_SKIP);

$db_class = 'db_'.$CFG['database'];
$db = new $db_class;
$db->halt = 1;//show sql errors
$db->connect($CFG['db_host'], $CFG['db_user'], $CFG['db_pass'], $CFG['db_name'], $CFG['pconnect']);

$CACHE = cache_read('module.php');
if(!$CACHE) {
	require_once DT_ROOT.'/admin/global.func.php';
	require_once DT_ROOT.'/include/cache.func.php';
    cache_all();
	$CACHE = cache_read('module.php');
}

$DT = $CACHE['dt'];
$MODULE = $CACHE['module'];
unset($CACHE, $CFG['timezone'], $CFG['db_host'], $CFG['db_user'], $CFG['db_pass'], $CFG['pconnect'], $db_class, $db_file);

if(!isset($moduleid)) {
	$moduleid = 1;
	$module = 'destoon';
} else if($moduleid == 1) {
	$module = 'destoon';
} else {
	$moduleid = intval($moduleid);
	isset($MODULE[$moduleid]) or message('', DT_PATH);
	$module = $MODULE[$moduleid]['module'];
	$MOD = cache_read('module-'.$moduleid.'.php');
}

$DT['gzip_enable'] && !$_POST && !$CFG['cache_page'] && @extension_loaded('zlib') && !headers_sent() ? ob_start('ob_gzhandler') : ob_start();

isset($forward) or $forward = $DT_REF;
isset($action) or $action = '';

$submit = isset($_POST['submit']) ? true : false;
if($submit) isset($captcha) or $captcha = '';
$page = isset($page) ? max(intval($page), 1) : 1;
$catid = isset($catid) ? intval($catid) : 0;
$itemid = isset($itemid) ? (is_array($itemid) ? $itemid : intval($itemid)) : 0;
$pagesize = $DT['pagesize'] ? $DT['pagesize'] : 30;
$offset = ($page-1)*$pagesize;
isset($kw) or $kw = '';
$keyword = $kw ? str_replace(array(' ','*'), array('%','%'), urldecode($kw)) : '';

unset($_POST, $_GET);

$head_title = $DT['seo_title'];
$head_keywords = $DT['seo_keywords'];
$head_description = $DT['seo_description'];

$_userid = $_message = 0;
$_username = $_company = '';
$_groupid = 3;
$destoon_auth = get_cookie('auth');
if($destoon_auth) {
	$destoon_key = md5($CFG['authkey'].$_SERVER['HTTP_USER_AGENT']);
	$_dauth = explode("\t", dcrypt($destoon_auth, 1, $destoon_key));
	$_userid = isset($_dauth[0]) ? intval($_dauth[0]) : 0;
	$_username = isset($_dauth[1]) ? trim($_dauth[1]) : '';
	$_groupid = isset($_dauth[2]) ? intval($_dauth[2]) : 3;
	if($_userid) {
		$_password = isset($_dauth[3]) ? trim($_dauth[3]) : '';
		$user = $db->get_one("SELECT username,company,password,groupid,email,message,money,loginip,level FROM {$DT_PRE}member WHERE userid=$_userid LIMIT 0,1");
		if($user && $user['password'] == $_password) {
			if($user['groupid'] == 2)  message('您的用户级别为禁止访问');
			if($user['message'] != $_message) set_cookie('message', $user['message']);
			extract($user, EXTR_PREFIX_ALL, '');
			if($user['loginip'] != $DT_IP && ($DT['ip_login'] == 2 || ($DT['ip_login'] == 1 && defined('DT_ADMIN')))) {
				$_userid = 0; set_cookie('auth', '');
				message('您的帐号在别处(IP:'.$user['loginip'].')登录，您被迫下线<br/>如果不是您操作的，请尽快修改登录密码', DT_PATH);
			}
		} else {
			$_userid = 0; set_cookie('auth', '');
		}
		unset($destoon_auth, $destoon_key, $user, $_dauth, $_password);
	}
}
?>