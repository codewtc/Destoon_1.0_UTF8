<?php
/*
	[Destoon B2B System] Copyright (c) 2009 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
error_reporting(0);
set_time_limit(0);
set_magic_quotes_runtime(0);
define('IN_DESTOON', true);
define('IN_ROOT', str_replace("\\", '/', dirname(__FILE__)));
define('DT_ROOT', substr(IN_ROOT, 0, -8));
define('CACHE_ROOT', DT_ROOT.'/cache');
if($_POST) extract($_POST, EXTR_SKIP);
if($_GET) extract($_GET, EXTR_SKIP);
$submit = isset($_POST['submit']) ? true : false;
$step = isset($_POST['step']) ? $_POST['step'] : 1;
$percent = '0%';
include DT_ROOT.'/config.inc.php';
include DT_ROOT.'/version.inc.php';
header("Content-Type:text/html;charset=".$CFG['charset']);
if(file_exists(DT_ROOT.'/cache/install.dat')) {
	$msg = '安装程序已经被锁定，如果需要解除锁定继续安装<br/>请删除 ./cache/install.dat 文件';
	include IN_ROOT.'/msg.tpl.php';
	exit;
}
require DT_ROOT.'/include/global.func.php';
require DT_ROOT.'/include/file.func.php';

switch($step) {
	case '1'://协议
		$license = file_get_contents(DT_ROOT.'/license.txt');
		if(strtoupper(md5($license)) != DT_LICENSE) {
			$msg = '请检查网站根目录下 license.txt 文件是否存在或被修改<br/>使用Destoon B2B网站管理系统，必须同意license.txt内容，并保留此文件';
			include IN_ROOT.'/msg.tpl.php';
			exit;
		}
		include IN_ROOT.'/step_'.$step.'.tpl.php';
	break;
	case '2'://环境
		$pass = true;
		$PHP_VERSION = PHP_VERSION;
		if(version_compare($PHP_VERSION, '4.3.0', '<')) {
			$php_pass = $pass = false;
		} else {
			$php_pass = true;
		}
		$PHP_MYSQL = '';
		if(extension_loaded('mysql')) {
			$PHP_MYSQL = '支持';
			$mysql_pass = true;
		} else {
			$PHP_MYSQL = '不支持';
			$mysql_pass = $pass = false;
		}
        $PHP_GD = '';
        if(function_exists('imagejpeg')) $PHP_GD .= 'jpg';
        if(function_exists('imagegif')) $PHP_GD .= ' gif';
        if(function_exists('imagepng')) $PHP_GD .= ' png';
		if($PHP_GD) {
			$gd_pass = true;
		} else {
			$gd_pass = $pass = false;
		}
		$PHP_URL = @get_cfg_var("allow_url_fopen");
		$url_pass = $PHP_URL ? true : false;
		$percent = '20%';
		include IN_ROOT.'/step_'.$step.'.tpl.php';
	break;
	case '3'://属性
		$ISWIN = strrpos(strtolower(PHP_OS), 'win') === false ? false : true;
		$files = file_get_contents(IN_ROOT.'/chmod.txt');
		$files = explode("\n", $files);
		$files = array_map('trim', $files);
		$FILES = array();
		$pass = true;
		foreach($files as $k=>$v) {
			$FILES[$k]['name'] = $v;
			if($ISWIN) {
				$FILES[$k]['write'] = true;
			} else {
				dir_chmod(DT_ROOT.'/'.$v, 0777);
				if(is_writable(DT_ROOT.'/'.str_replace('*', '', $v))) {
					$FILES[$k]['write'] = true;
				} else {
					$FILES[$k]['write'] = $pass = false;
				}
			}
		}
		$percent = '40%';
		include IN_ROOT.'/step_'.$step.'.tpl.php';
	break;
	case '4'://数据库
		$DT_PATH = substr(dirname(get_env('self')), 0, -7);
		$DT_URL = substr(get_env('url'), 0, -17);
		$percent = '60%';
		include IN_ROOT.'/step_'.$step.'.tpl.php';
	break;
	case '5'://安装进度
		function dexit($msg) {
			echo '<script>alert("'.$msg.'");window.history.back();</script>';
			exit;
		}
		if(!preg_match("/^[a-z0-9]+$/i", $username) || strlen($username) < 4) dexit('请填写正确的超级管理员户名');
		if(strlen($password) < 6) dexit('超级管理员密码最少6位');
		if(strlen($email) < 6 || !preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email)) dexit('请填写正确的超级管理员Email');
		if(!mysql_connect($db_host, $db_user, $db_pass)) dexit('无法连接到数据库服务器，请检查配置');
		$db_name or dexit('请填写数据库名');
		if(!mysql_select_db($db_name)) {
			if(!mysql_query("CREATE DATABASE $db_name")) dexit('指定的数据库不存在\n\n系统尝试创建失败，请通过其他方式建立数据库');
		}

		$config = array();
		$config['db_host'] = $CFG['db_host'] = $db_host;
		$config['db_user'] = $CFG['db_user'] = $db_user;
		$config['db_pass'] = $CFG['db_pass'] = $db_pass;
		$config['db_name'] = $CFG['db_name'] = $db_name;
		$config['tb_pre'] = $CFG['tb_pre'] = $DT_PRE = $tb_pre;
		$config['path'] = $CFG['path'] = $path;
		$config['url'] = $CFG['url'] = $url;
		$config['cookie_pre'] = $CFG['cookie_pre'] = $cookie_pre;
		$config['authkey'] = $CFG['authkey'] = random(15);
		//保存配置文件
		$tmp = file_get_contents(DT_ROOT.'/config.inc.php');
		foreach($config as $k=>$v)	{
			$tmp = preg_replace("/[$]CFG\['$k'\]\s*\=\s*[\"'].*?[\"']/is", "\$CFG['$k'] = '$v'", $tmp);
		}
		file_put(DT_ROOT.'/config.inc.php', $tmp);
		define('DT_URL', $url);
		define('DT_PATH', $url);
		define('SKIN_PATH', DT_PATH.'skin/'.$CFG['skin'].'/');
		define('VIP', $CFG['com_vip']);
		define('errmsg', 'Invalid Request');

		//创建数据
		require DT_ROOT.'/include/db_mysql.class.php';
		require DT_ROOT.'/include/sql.func.php';
		require DT_ROOT.'/admin/global.func.php';
		$db = new db_mysql();
		$db->connect($db_host, $db_user, $db_pass, $db_name);
		sql_execute(file_get_contents(IN_ROOT.'/mysql.sql'));

		//Setting
		$DT = array();
		for($i = 1; $i <= 10; $i++) {
			$setting = array();
			$setting = cache_read('module-'.$i.'.php');
			if($i == 1) $DT = $setting;			unset($setting['moduleid'],$setting['name'],$setting['moduledir'],$setting['ismenu'],$setting['domain'],$setting['linkurl']);
			update_setting($i, $setting);
		}
		$pay = cache_read('pay.php');		
		foreach($pay as $k=>$v) {
			update_setting('pay-'.$k, $v);
		}
		$DT_TIME = time();
		$DT_IP = get_env('ip');
		//模块安装时间
		$db->query("UPDATE {$DT_PRE}module SET installtime='$DT_TIME'");

		//设置管理员
		$md5_password = md5(md5($password));
		$db->query("UPDATE {$DT_PRE}member SET username='$username',password='$md5_password',email='$email',regip='$DT_IP',regtime='$DT_TIME',loginip='$DT_IP',logintime='$DT_TIME' WHERE userid=1");
		$userurl = $CFG['url'].'company/index.php?homepage='.$username;
		$db->query("UPDATE {$DT_PRE}company SET username='$username',linkurl='$userurl' WHERE userid=1");

		//替换广告位 单网页路径
		$content = cache_read('ad_13.htm', 'htm', 1);
		$content = str_replace('/skin/', $CFG['url'].'skin/', $content);
		cache_write('ad_13.htm', $content, 'htm');
		$files = glob(DT_ROOT.'/plugin/*.html');
		foreach($files as $file) {
			$content = file_get_contents($file);
			$content = str_replace('http://www.destoon.com/', $CFG['url'], $content);
			file_put($file, $content);
		}
		$db->query("UPDATE {$DT_PRE}ad_place SET addtime='$DT_TIME',edittime='$DT_TIME',editor='$username'");
		$db->query("UPDATE {$DT_PRE}ad SET addtime='$DT_TIME',edittime='$DT_TIME',username='$username',editor='$username'");
		$db->query("UPDATE {$DT_PRE}link SET addtime='$DT_TIME',edittime='$DT_TIME',editor='$username'");
		$db->query("UPDATE {$DT_PRE}style SET addtime='$DT_TIME',edittime='$DT_TIME',editor='$username'");
		

		//更新缓存
		require DT_ROOT.'/include/cache.func.php';
		cache_all();
		cache_module();//Again

		//生成首页
		$CACHE = cache_read('module.php');
		$DT = $CACHE['dt'];
		$MODULE = $CACHE['module'];
		$moduleid = 1;
		$module = 'destoon';
		tohtml('index');

		$msgs = array(
				'保存系统配置.................成功',
				'数据库连接....................成功',
				'创建数据库....................成功',
				'创建数据表....................成功',
				'插入初始数据.................成功',
				'设置管理员....................成功',
				'安装系统模型.................成功',
				'更新系统缓存.................成功',
				'更新模块缓存.................成功',
				'更新模板缓存.................成功',
				'生成网站密钥.................成功',
				'生成网站首页.................成功',
				'锁定安装程序.................就绪',
			);
		$percent = '80%';
		include IN_ROOT.'/step_'.$step.'.tpl.php';
	break;
	case '6'://安装成功
		$percent = '100%';
		include IN_ROOT.'/step_'.$step.'.tpl.php';
		file_put(DT_ROOT.'/cache/install.dat', time());
		file_put(DT_ROOT.'/file/backup/backup.dat', time());
		file_put(DT_ROOT.'/install/index.php', '<meta http-equiv="refresh" content="0;url=../">');
	break;
	case 'db_test':
		if(!mysql_connect($tdb_host, $tdb_user, $tdb_pass)) exit('<script>alert("无法连接到数据库服务器，请检查配置");</script>');
		if(!mysql_select_db($tdb_name)) {
			if(!mysql_query("CREATE DATABASE $tdb_name")) exit('<script>alert("指定的数据库不存在\n\n系统尝试创建失败，请通过其他方式建立数据库");</script>');
			mysql_select_db($tdb_name);
		}
		$tables = array();
		$query = mysql_list_tables($tdb_name);
		while($r = mysql_fetch_row($query)) {
			$tables[] = $r[0];
		}
		if(is_array($tables) && in_array($ttb_pre."company", $tables)) {
			exit('<script>alert("数据库设置正确，连接正常\n\n提示:系统检测到您已经安装过Destoon，如果继续安装将会清空现有数据\n\n如果需要保留现有数据，建议您修改数据表前缀");</script>');
		}
		exit('<script>alert("数据库设置正确，连接正常");</script>');
	break;
}
?>