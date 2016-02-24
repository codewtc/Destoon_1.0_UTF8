<?php
/*
	[Destoon B2B System] Copyright (c) 2009 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_DESTOON') or exit('Access Denied');
function dhtmlspecialchars($string) {
    return is_array($string) ? array_map('dhtmlspecialchars', $string) : htmlspecialchars($string, ENT_QUOTES);
}

function daddslashes($string) {
	if(!is_array($string)) return addslashes($string);
	foreach($string as $key => $val) $string[$key] = daddslashes($val);
	return $string;
}

function dstripslashes($string) {
	if(!is_array($string)) return stripslashes($string);
	foreach($string as $key => $val) $string[$key] = dstripslashes($val);
	return $string;
}

function dtrim($string, $js = false) {
	$string = str_replace(array(chr(10), chr(13)), array('', ''), $string);
	return $js ? str_replace("'", "\'", $string) : $string;
}

function dheader($url) {
	exit(header('location:'.$url));
}

function dmsg($dmsg = '', $dforward = '') {
	if(!$dmsg && !$dforward) {
		$dmsg = get_cookie('dmsg');
		if($dmsg) {
			echo '<script type="text/javascript">showmsg(\''.$dmsg.'\');</script>';
			set_cookie('dmsg', '');
		}
	} else {
		set_cookie('dmsg', $dmsg);
		$dforward = preg_replace("/(.*)([&?]destoon=[0-9]*)(.*)/i", "\\1\\3", $dforward);
		$dforward = $dforward.(strpos($dforward, '?') === false ? '?' : '&').'destoon='.mt_rand(10, 99);
		dheader($dforward);
	}
}

function dsubstr($string, $length, $suffix = '', $start = 0) {
	global $CFG;
	if($start) {
		$tmp = dsubstr($string, $start);
		$string = substr($string, strlen($tmp));
	}
	$strlen = strlen($string);
	if($strlen <= $length) return $string;
	$string = str_replace(array('&', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);
	$str = '';
	if(strtolower($CFG['charset']) == 'utf-8') {
		$n = $tn = $noc = 0;
		while($n < $strlen)	{
			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t < 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}
			if($noc >= $length) break;
		}
		if($noc > $length) $n -= $tn;
		$str = substr($string, 0, $n);
	} else {
		$suffixlen = strlen($suffix);
		$maxi = $length - $suffixlen - 1;
		for($i = 0; $i < $maxi; $i++) {
			$str .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
		}
	}
	$str = str_replace(array('&', '"', '<', '>'), array('&', '&quot;', '&lt;', '&gt;'), $str);
	return $str.$suffix;
}

function dcrypt($str, $decode = false, $key = '') {
	global $CFG;
	$key or $key = $CFG['authkey'];
	require_once DT_ROOT.'/include/crypt.func.php';
    return $decode ? destoon_decrypt($str, $key) : destoon_encrypt($str, $key);
}

function dround($var, $precision = 2) {
	return round(floatval($var), $precision);
}

function dalloc($itemid) {
	return ceil($itemid/5000);
}

function anti_spam($string, $mailto = false, $js = true) {
	if(preg_match("/^[a-z0-9\.\-_@]+$/i", $string)) {
		$str = '';
		$strlen = strlen($string);
		for($i = 0; $i < $strlen; $i++) {
			$str .= '\''.$string{$i}.'\'+';
		}
		$str = substr($str, 0, -1);
		$str = $mailto ? 'document.write(\'<a href="mailto:\'+'.$str.'+\'">\'+'.$str.'+\'</a>\');' : 'document.write('.$str.');';
		return $js ? '<script type="text/javascript">'.$str.'</script>' : $str;
	} else {
		return $string;
	}
}

function strip_sql($string) {
	$search = array("/ union /i","/ select /i","/ update /i","/ outfile /i","/ or /i");
	$replace = array('&nbsp;union&nbsp;','&nbsp;select&nbsp;','&nbsp;update&nbsp;','&nbsp;outfile&nbsp;','&nbsp;or&nbsp;');
	return is_array($string) ? array_map('strip_sql', $string) : preg_replace($search, $replace, $string);
}

function strip_nr($string) {
	return str_replace(array(chr(13), chr(10), "\n", "\r", "\t", '  '),array('', '', '', '', '', ''), $string);
}

function template($template = 'index', $dir = '') {
	global $CFG;
	$to = $dir ? CACHE_ROOT.'/tpl/'.$dir.'-'.$template.'.php' : CACHE_ROOT.'/tpl/'.$template.'.php';
	if($CFG['template_refresh'] || !is_file($to)) {
		if($dir) $dir = $dir.'/';
        $from = DT_ROOT.'/template/'.$CFG['template'].'/'.$dir.$template.'.htm';
		if($CFG['template'] != 'default' && !is_file($from)) {
			$from = DT_ROOT.'/template/default/'.$dir.$template.'.htm';
		}
        if(!is_file($to) || filemtime($from) > filemtime($to)) {
			require_once DT_ROOT.'/include/template.func.php';
			template_compile($from, $to);
		}
	}
	return $to;
}

function ob_template($template, $dir = '') {
	extract($GLOBALS, EXTR_SKIP);
	ob_start();
	include template($template, $dir);
	$contents = ob_get_contents();
	ob_clean();
	return $contents;
}

function message($dmessage = errmsg, $dforward = 'goback', $dtime = 1) {
	global $CFG, $DT;
	if(!$dmessage && $dforward && $dforward != 'goback') dheader($dforward);
	include template('message');
    exit();
}

function login() {
	global $_userid, $MODULE, $DT_URL;
	$_userid or dheader($MODULE[2]['linkurl'].'login.php?forward='.urlencode($DT_URL));
}

function random($length, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz') {
	$hash = '';
	$max = strlen($chars) - 1;
	for($i = 0; $i < $length; $i++)	{
		$hash .= $chars[mt_rand(0, $max)];
	}
	return $hash;
}

function set_cookie($var, $value = '', $time = 0) {
	global $CFG, $DT_TIME;
	$time = $time > 0 ? $time : (empty($value) ? $DT_TIME - 3600 : 0);
	$port = $_SERVER['SERVER_PORT'] == '443' ? 1 : 0;
	$var = $CFG['cookie_pre'].$var;
	return setcookie($var, $value, $time, $CFG['cookie_path'], $CFG['cookie_domain'], $port);
}

function get_cookie($var) {
	global $CFG;
	$var = $CFG['cookie_pre'].$var;
	return isset($_COOKIE[$var]) ? $_COOKIE[$var] : '';
}

function send_message($touser, $title, $content) {
	global $db, $DT_PRE, $DT_TIME;
	if($touser && $title && $content) {
		$title = addslashes($title);
		$content = addslashes($content);
		$db->query("UPDATE {$DT_PRE}member SET message=message+1 WHERE username='$touser' ");
		if($db->affected_rows()) $db->query("INSERT INTO {$DT_PRE}message (title,typeid,touser,content,addtime,status) VALUES ('$title', 3, '$touser','$content','$DT_TIME',3)");
		return $db->affected_rows();
	}
	return false;
}

function send_mail($mail_to, $mail_subject, $mail_body, $mail_from = '', $mail_sign = true) {
	require_once DT_ROOT.'/include/mail.func.php';
	return dmail(trim($mail_to), $mail_subject, $mail_body, $mail_from, $mail_sign);
}

function cache_read($file, $dir = '', $mode = '') {
	$file = $dir ? CACHE_ROOT.'/'.$dir.'/'.$file : CACHE_ROOT.'/'.$file;
	if(!is_file($file)) return array();
	return $mode ? file_get_contents($file) : include $file;
}

function cache_write($file, $string, $dir = '') {
	if(is_array($string)) $string = "<?php defined('IN_DESTOON') or exit('Access Denied'); return ".strip_nr(var_export($string, true))."; ?>";
	$file = $dir ? CACHE_ROOT.'/'.$dir.'/'.$file : CACHE_ROOT.'/'.$file;
	$strlen = file_put($file, $string);
	return $strlen;
}

function cache_delete($file, $dir = '') {
	$file = $dir ? CACHE_ROOT.'/'.$dir.'/'.$file : CACHE_ROOT.'/'.$file;
	return @unlink($file);
}

function cache_clear($str, $type = '', $dir = '') {
	$dir = $dir ? CACHE_ROOT.'/'.$dir.'/' : CACHE_ROOT.'/';
	$files = glob($dir.'*');
	if(is_array($files)) {
		if($type == 'dir') {
			foreach($files as $file) {
				if(is_dir($file)) {dir_delete($file);} else {if(file_ext($file) == $str) @unlink($file);}
			}
		} else {
			foreach($files as $file) {
				if(!is_dir($file) && strpos(basename($file), $str) !== false) @unlink($file);
			}
		}
	}
}

function text_write($itemid, $item, $content) {
	if(!$itemid || !$item || !$content) return;
	$text_dir = DT_ROOT.'/file/text/'.$item.'/'.dalloc($itemid).'/';
	if(!is_dir($text_dir)) {
		dir_create($text_dir);
		copy(DT_ROOT.'/file/index.html', $text_dir.'index.html');
	}
	file_put($text_dir.$itemid.'.php', '<?php exit; ?>'.stripslashes($content));
}

function text_delete($itemid, $item) {
	if(!$itemid || !$item) return;
	$text_file = DT_ROOT.'/file/text/'.$item.'/'.dalloc($itemid).'/'.$itemid.'.php';
	if(is_file($text_file)) unlink($text_file);
}

function text_read($itemid, $item) {
	if(!$itemid || !$item) return '';
	return substr(file_get_contents(DT_ROOT.'/file/text/'.$item.'/'.dalloc($itemid).'/'.$itemid.'.php'), 14);
}

function cache_item($moduleid, $catid, $item) {
	$items = cache_read('items-'.$moduleid.'.php');
	is_array($items) or $items = array();
	$items[$catid] = $item;
	cache_write('items-'.$moduleid.'.php', $items);
}

function banip($IPS) {
	global $DT_IP, $DT_TIME;
	$ban = false;
	foreach($IPS as $v) {
		if($v['totime'] && $v['totime'] < $DT_TIME) continue;
		if($v['ip'] == $DT_IP) { $ban = true; break; }
		if(preg_match("/^".str_replace('*', '[0-9]{1,3}', $v['ip'])."$/", $DT_IP)) { $ban = true; break; }
	}
	if($ban) message('IP '.$DT_IP.' 已经被网站禁止');
}

function keylink($content, $item) {
	global $KEYLINK;
	$KEYLINK or $KEYLINK = cache_read('keylink-'.$item.'.php');
	if(!$KEYLINK) return $content;
	foreach($KEYLINK as $v) {
		$p = strpos($content, $v['title']);
		if($p !== false) {
			$tmp = substr($content, 0, $p);
			$content = $tmp.'<a href="'.$v['url'].'" target="_blank"><strong class="keylink">'.$v['title'].'</strong></a>'.str_replace($tmp.$v['title'], '', $content);
		}
	}
	return $content;
}

function get_env($type) {
	switch($type) {
		case 'ip':
			$DT_IP = '';
			if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
				$DT_IP = getenv('HTTP_CLIENT_IP');
			} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
				$DT_IP = getenv('HTTP_X_FORWARDED_FOR');
			} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
				$DT_IP = getenv('REMOTE_ADDR');
			} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
				$DT_IP = $_SERVER['REMOTE_ADDR'];
			}
			if(!preg_match("/[\d\.]{7,15}/", $DT_IP)) $DT_IP = 'unknown';
			return $DT_IP;
			break;
		case 'self':
			return isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : (isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : $_SERVER['ORIG_PATH_INFO']);
			break;
		case 'referer':
			return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
			break;
		case 'domain':
			return $_SERVER['SERVER_NAME'];
			break;
		case 'scheme':
			return $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
			break;
		case 'port':
			return $_SERVER['SERVER_PORT'] == '80' ? '' : ':'.$_SERVER['SERVER_PORT'];
			break;
		case 'url':
			if(isset($_SERVER['REQUEST_URI'])) {
				$uri = $_SERVER['REQUEST_URI'];
			} else {
				$uri = isset($_SERVER['argv']) ? $_SERVER['PHP_SELF'] .'?'. $_SERVER['argv'][0] : $_SERVER['PHP_SELF'] .'?'. $_SERVER['QUERY_STRING'];
			}
			return get_env('scheme').$_SERVER['HTTP_HOST'].(strpos($_SERVER['HTTP_HOST'], ':') === false ? get_env('port') : '').$uri;
			break;
		default:
			return '';
			break;
	}
}

function convert($str, $from = 'utf-8', $to = 'gb2312') {
	if(!$str) return '';
	if($from == $to) return $str;
	$from = str_replace('gbk', 'gb2312', strtolower($from));
	$to = str_replace('gbk', 'gb2312', strtolower($to));
	if($from == $to) return $str;
	$tmp = array();
	if(function_exists('iconv')) {
		if(is_array($str)) {
			foreach($str as $key => $val) {
				$tmp[$key] = iconv($from, $to."//IGNORE", $val);
			}
			return $tmp;
		} else {
			return iconv($from, $to."//IGNORE", $str);
		}
	} else if(function_exists('mb_convert_encoding')) {
		if(is_array($str)) {
			foreach($str as $key => $val) {
				$tmp[$key] = mb_convert_encoding($val, $to, $from);
			}
			return $tmp;
		} else {
			return mb_convert_encoding($str, $to, $from);
		}	
	} else {
		require_once DT_ROOT.'/include/convert.func.php';
		return dconvert($str, $to, $from);
	}
}

function get_modules() {
	$moduledirs = glob(DT_ROOT.'/module/*');
	$sysmodules = array();
	foreach($moduledirs as $k=>$v) {
		if(is_file($v.'/admin/config.inc.php')) {
			include $v.'/admin/config.inc.php';
			$sysmodules[$MCFG['module']] = $MCFG;
		}
	}
	return $sysmodules;
}

function get_type($item, $cache = 0) {
	$types = array();
	if($cache) {
		$types = cache_read('type-'.$item.'.php');
	} else {
		global $db, $DT_PRE;
		$result = $db->query("SELECT * FROM {$DT_PRE}type WHERE item='$item' ORDER BY listorder DESC,typeid DESC ");
		while($r = $db->fetch_array($result)) {
			$types[$r['typeid']] = $r;
		}
	}
	return $types;
}

function cat_pos($catid, $str = ' &raquo; ', $target = '') {
	global $MOD, $CATEGORY;
	if(!$catid) return '';
	$arrparentid = $CATEGORY[$catid]['arrparentid'] ? explode(',', $CATEGORY[$catid]['arrparentid']) : array();
	$arrparentid[] = $catid;
	$pos = '';
	$target = $target ? ' target="_blank"' : '';
	foreach($arrparentid as $catid) {
		if(!$catid || !isset($CATEGORY[$catid])) continue;
		$pos .= '<a href="'.$MOD['linkurl'].$CATEGORY[$catid]['linkurl'].'"'.$target.'>'.$CATEGORY[$catid]['catname'].'</a>'.$str;
	}
	$_len = strlen($str);
	if($str && substr($pos, -$_len, $_len) === $str) $pos = substr($pos, 0, strlen($pos)-$_len);
	return $pos;
}

function area_pos($areaid, $str = ' &raquo; ', $deep = 0) {
	global $AREA;
	if(!$areaid) return '';
	$AREA or $AREA = cache_read('area.php');
	$arrparentid = $AREA[$areaid]['arrparentid'] ? explode(',', $AREA[$areaid]['arrparentid']) : array();
	$arrparentid[] = $areaid;
	$pos = '';
	if($deep) $i = 1;
	foreach($arrparentid as $areaid) {
		if(!$areaid || !isset($AREA[$areaid])) continue;
		if($deep) {
			if($i > $deep) continue;
			$i++;
		}
		$pos .= $AREA[$areaid]['areaname'].$str;
	}
	$_len = strlen($str);
	if($str && substr($pos, -$_len, $_len) === $str) $pos = substr($pos, 0, strlen($pos)-$_len);
	return $pos;
}

function get_maincat($catid, $category, $all = true) {
	$cat = array();
	foreach($category as $c) {
		if(!$all && !$c['display']) continue;
		if($c['parentid'] == $catid && $c['catid'] != $catid) $cat[] = $c;
	}
	return $cat;
}

function get_childarea($areaid, $area) {
	$are = array();
	foreach($area as $c) {
		if($c['parentid'] == $areaid && $c['areaid'] != $areaid) $are[] = $c;
	}
	return $are;
}

function get_user($value, $key = 'username', $from = 'userid') {
	global $db, $DT_PRE;
	$r = $db->get_one("SELECT `$from` FROM {$DT_PRE}member WHERE `$key`='$value'");
	return $r[$from];
}

function tohtml($htmlfile, $module = '', $parameter = '') {
	defined('TOHTML') or define('TOHTML', true);
    extract($GLOBALS, EXTR_SKIP);
	if($parameter) parse_str($parameter);
    @include $module ? DT_ROOT.'/module/'.$module.'/'.$htmlfile.'.html.php' : DT_ROOT.'/include/'.$htmlfile.'.html.php';
}

function set_style($string, $style = '', $tag = 'span') {
	if(preg_match("/^#[0-9a-zA-Z]{6}$/", $style)) $style = 'color:'.$style;
	return $style ? '<'.$tag.' style="'.$style.'">'.$string.'</'.$tag.'>' : $string;
}

function crypt_action($action) {
	global $CFG, $DT_IP;
	return md5(md5($action.$CFG['authkey'].$DT_IP));
}

function captcha($captcha, $enable = 1) {
	global $CFG, $DT_IP, $session;
	if(!$enable) return true;
	if(!$captcha) message('请填写验证码');
	if(!is_object($session)) $session = new dsession();
	if(!isset($_SESSION['captchastr'])) message('验证码已过期');
	if($_SESSION['captchastr'] != md5(md5(strtoupper($captcha).$CFG['authkey'].$DT_IP))) message('验证码不正确');
	unset($_SESSION['captchastr']);
}

function question($answer, $enable = 1) {
	global $CFG, $DT_IP, $session;
	if(!$enable) return true;
	if(!$answer) message('请填写答案');
	$answer = stripslashes($answer);
	if(!is_object($session)) $session = new dsession();
	if(!isset($_SESSION['answerstr'])) message('问题已过期');
	if($_SESSION['answerstr'] != md5(md5($answer.$CFG['authkey'].$DT_IP))) message('答案不正确');
	unset($_SESSION['answerstr']);
}

function pages($total, $page = 1, $perpage = 20, $step = 2) {
	global $DT_URL, $DT;
	if($total <= $perpage) return '';
	$total = ceil($total/$perpage);
	$page = intval($page);
	if($page < 1 || $page > $total) $page = 1;
	if(defined('PARSE_STR') && $DT['rewrite'] && $_SERVER["SCRIPT_NAME"]) {
		$demo_url = $_SERVER["SCRIPT_NAME"];
		$mark = false;
		if(substr($demo_url, -4) == '.php') {
			if(strpos($_SERVER['QUERY_STRING'], '.html') === false) {
				$qstr = '';
				if($_SERVER['QUERY_STRING']) {
					parse_str($_SERVER['QUERY_STRING'], $qs);
					foreach($qs as $k=>$v) {
						$qstr .= '-'.$k.'-'.rawurlencode($v);
					}
				}
				$demo_url = substr($demo_url, 0, -4).'-htm-page-{destoon_page}'.$qstr.'.html';
			} else {
				$demo_url = substr($demo_url, 0, -4).'-htm-'.$_SERVER['QUERY_STRING'];
				$mark = true;
			}
		} else {
			$mark = true;
		}
		if($mark) {
			$demo_url = rawurlencode($demo_url);
			$demo_url = str_replace(array('%2F', '%3A'), array('/', ':'), $demo_url);
			if(strpos($demo_url, '-page-') !== false) {
				$demo_url = preg_replace("/page-([0-9]+)/", 'page-{destoon_page}', $demo_url);
			} else {
				$demo_url = str_replace('.html', '-page-{destoon_page}.html', $demo_url);
			}
		}
	} else {
		$demo_url = preg_replace("/(.*)([&?]page=[0-9]*)(.*)/i", "\\1\\3", $DT_URL);
		$s = strpos($demo_url, '?') === false ? '?' : '&';
		$demo_url = $demo_url.$s.'page={destoon_page}';
	}
	$pages = '';
	$_page = $page <= 1 ? $total : ($page - 1);//上一页
	$url = str_replace('{destoon_page}', $_page, $demo_url);
	$pages .= '<a href="'.$url.'" id="destoon_previous" title="上一页(支持左方向键)">&nbsp;&#171;&nbsp;</a> ';

	if($total >= 1) {
		$_page = 1;
		$url = str_replace('{destoon_page}', $_page, $demo_url);
		$pages .= $page == $_page ? '<strong>&nbsp;'.$_page.'&nbsp;</strong> ' : ' <a href="'.$url.'">&nbsp;'.$_page.'&nbsp;</a>  ';
	}
	if($total >= 2) {
		$_page = 2;
		$url = str_replace('{destoon_page}', $_page, $demo_url);
		$pages .= $page == $_page ? '<strong>&nbsp;'.$_page.'&nbsp;</strong> ' : ' <a href="'.$url.'">&nbsp;'.$_page.'&nbsp;</a>  ';
	}

	if($total >= 3) {
		$pages .= '&nbsp;&#8230;&nbsp;';
		if($total > 4) {
			if($page <= 2) {
				$min = 3; $max = 3 + $step*2;
			} else if($page >= $total - 1) {
				$min = $total - 2 - $step*2; $max = $total - 2;
			} else {
				$min = $page - $step; $max = $page + $step;
			}
			if($min < 3) $min = 3;
			if($max > $total - 2) $max = $total - 2;
			if($page == 3) while($max < $page + $step*2 && $max < $total - 2) { $max++; }
			if($page == 4) while($max < $page + $step*2 - 1 && $max < $total - 2) { $max++; }
			if($page == $total - 3) while($min > $page - $step*2 + 1 && $min - 1 > 2) { $min--;}
			if($page == $total - 2) while($min > $page - $step*2 && $min - 1 > 2) { $min--; }
			for($_page = $min; $_page <= $max; $_page++) {
				$url = str_replace('{destoon_page}', $_page, $demo_url);
				$pages .= $page == $_page ? '<strong>&nbsp;'.$_page.'&nbsp;</strong> ' : ' <a href="'.$url.'">&nbsp;'.$_page.'&nbsp;</a>  ';
			}
			$pages .= '&nbsp;&#8230;&nbsp;';
		}
		if($total >= 4) {
			$_page = $total - 1;
			$url = str_replace('{destoon_page}', $_page, $demo_url);
			$pages .= $page == $_page ? '<strong>&nbsp;'.$_page.'&nbsp;</strong> ' : ' <a href="'.$url.'">&nbsp;'.$_page.'&nbsp;</a>  ';
		}
		if($total >= 3) {
			$_page = $total;
			$url = str_replace('{destoon_page}', $_page, $demo_url);
			$pages .= $page == $_page ? '<strong>&nbsp;'.$_page.'&nbsp;</strong> ' : ' <a href="'.$url.'">&nbsp;'.$_page.'&nbsp;</a>  ';
		}

	}
	$_page = $page >= $total ? 1 : $page + 1;
	$url = str_replace('{destoon_page}', $_page, $demo_url);
	$pages .= '<a href="'.$url.'" id="destoon_next" title="下一页(支持右方向键)">&nbsp;&#187;&nbsp;</a> ';

	$pages .= '<input type="text" class="pages_inp" id="destoon_pageno" onkeydown="if(event.keyCode==13 && this.value) {window.location=\''.$demo_url.'\'.replace(/\\{destoon_page\\}/, this.value);}"> <input type="button" class="pages_btn" value="GO" onclick="window.location=\''.$demo_url.'\'.replace(/\\{destoon_page\\}/, $(\'destoon_pageno\').value);"/>';
	return $pages;
}

function listpages($moduleid, $catid, $total, $page = 1, $perpage = 20, $category = array(), $step = 2) {
	if($total <= $perpage) return '';
	$M = cache_read('module-'.$moduleid.'.php');
	$C = $category ? $category : cache_read('category-'.$moduleid.'.php');
	$total = ceil($total/$perpage);
	$page = intval($page);
	if($page < 1 || $page > $total) $page = 1;
	$demo_url = $M['linkurl'].listurl($moduleid, $catid, '{destoon_page}', $C, $M);
	$pages = '';

	$_page = $page <= 1 ? $total : ($page - 1);//上一页
	$url = str_replace('{destoon_page}', $_page, $demo_url);
	$pages .= '<a href="'.$url.'" id="destoon_previous" title="上一页(支持左方向键)">&nbsp;&#171;&nbsp;</a> ';

	if($total >= 1) {
		$_page = 1;
		$url = str_replace('{destoon_page}', $_page, $demo_url);
		$pages .= $page == $_page ? '<strong>&nbsp;'.$_page.'&nbsp;</strong> ' : ' <a href="'.$url.'">&nbsp;'.$_page.'&nbsp;</a>  ';
	}
	if($total >= 2) {
		$_page = 2;
		$url = str_replace('{destoon_page}', $_page, $demo_url);
		$pages .= $page == $_page ? '<strong>&nbsp;'.$_page.'&nbsp;</strong> ' : ' <a href="'.$url.'">&nbsp;'.$_page.'&nbsp;</a>  ';
	}

	if($total >= 3) {
		$pages .= '&nbsp;&#8230;&nbsp;';
		if($total > 4) {
			if($page <= 2) {
				$min = 3; $max = 3 + $step*2;
			} else if($page >= $total - 1) {
				$min = $total - 2 - $step*2; $max = $total - 2;
			} else {
				$min = $page - $step; $max = $page + $step;
			}
			if($min < 3) $min = 3;
			if($max > $total - 2) $max = $total - 2;
			if($page == 3) while($max < $page + $step*2 && $max < $total - 2) { $max++; }
			if($page == 4) while($max < $page + $step*2 - 1 && $max < $total - 2) { $max++; }
			if($page == $total - 3) while($min > $page - $step*2 + 1 && $min - 1 > 2) { $min--;}
			if($page == $total - 2) while($min > $page - $step*2 && $min - 1 > 2) { $min--; }
			for($_page = $min; $_page <= $max; $_page++) {
				$url = str_replace('{destoon_page}', $_page, $demo_url);
				$pages .= $page == $_page ? '<strong>&nbsp;'.$_page.'&nbsp;</strong> ' : ' <a href="'.$url.'">&nbsp;'.$_page.'&nbsp;</a>  ';
			}
			$pages .= '&nbsp;&#8230;&nbsp;';
		}
		if($total >= 4) {
			$_page = $total - 1;
			$url = str_replace('{destoon_page}', $_page, $demo_url);
			$pages .= $page == $_page ? '<strong>&nbsp;'.$_page.'&nbsp;</strong> ' : ' <a href="'.$url.'">&nbsp;'.$_page.'&nbsp;</a>  ';
		}
		if($total >= 3) {
			$_page = $total;
			$url = str_replace('{destoon_page}', $_page, $demo_url);
			$pages .= $page == $_page ? '<strong>&nbsp;'.$_page.'&nbsp;</strong> ' : ' <a href="'.$url.'">&nbsp;'.$_page.'&nbsp;</a>  ';
		}

	}
	$_page = $page >= $total ? 1 : $page + 1;
	$url = str_replace('{destoon_page}', $_page, $demo_url);
	$pages .= '<a href="'.$url.'" id="destoon_next" title="下一页(支持右方向键)">&nbsp;&#187;&nbsp;</a> ';

	$pages .= '<input type="text" class="pages_inp" id="destoon_pageno" onkeydown="if(event.keyCode==13 && this.value) {window.location=\''.$demo_url.'\'.replace(/\\{destoon_page\\}/, this.value);}"> <input type="button" class="pages_btn" value="GO" onclick="window.location=\''.$demo_url.'\'.replace(/\\{destoon_page\\}/, $(\'destoon_pageno\').value);"/>';
	return $pages;
}

function linkurl($linkurl, $absurl = 0) {
	global $CFG;
	if($absurl || $CFG['absurl']) {
		if(strpos($linkurl, '://') !== false) return $linkurl;
		return strpos($linkurl, $CFG['path']) === 0 ? $CFG['url'].substr($linkurl, strlen($CFG['path'])) : $CFG['url'].$linkurl;
	} else {
		if(strpos($linkurl, '://') !== false) return strpos($linkurl, $CFG['url']) === 0 ? $CFG['path'].substr($linkurl, strlen($CFG['url'])) : $linkurl;
		return strpos($linkurl, $CFG['path']) === 0 ? $linkurl : $CFG['path'].$linkurl;
	}
}

function imgurl($imgurl = '', $absurl = 0) {
	if(!$imgurl) $imgurl = SKIN_PATH.'image/nopic.gif';
	return linkurl($imgurl, $absurl);
}

function userurl($username, $domain = '') {
	global $CFG, $MODULE;
	if($CFG['com_domain']) {
		if($domain) {
			return get_env('scheme').$domain.'/';
		} else {
			return get_env('scheme').$username.$CFG['com_domain'].'/';
		}
	} else {
		return linkurl($MODULE[4]['linkurl'].rewrite('index.php?homepage='.$username), 1); 
	}
}

function userdomain($username, $linkurl = '') {
	global $CFG, $MODULE;
	if($CFG['com_domain']) {
		$linkurl or $linkurl = userurl($username).'index.php?destoon';
		$url = parse_url($linkurl);
		return $url['scheme'].'://'.$url['host'].'/';
	} else {
		return linkurl($MODULE[4]['linkurl']);
	}
}

function listurl($moduleid, $catid, $page = 0, $category = array(), $mod = array()) {
	global $DT;
	include DT_ROOT.'/include/url.inc.php';
	$MOD = $mod ? $mod : cache_read('module-'.$moduleid.'.php');
	$CATEGORY = $category ? $category : cache_read('category-'.$moduleid.'.php');
	$file_ext = $DT['file_ext'];
	$index = $DT['index'];
	$catdir = $catid ? $CATEGORY[$catid]['catdir'] : '';
	$parentdir = $catid ? $CATEGORY[$catid]['parentdir'] : '';
	isset($MOD['htm_list_prefix']) or $MOD['htm_list_prefix'] = $DT['htm_list_prefix'];
	isset($MOD['list_html']) or $MOD['list_html'] = $DT['list_html'];
	isset($MOD['htm_list_urlid']) or $MOD['htm_list_urlid'] = $DT['htm_list_urlid'];
	isset($MOD['php_list_urlid']) or $MOD['php_list_urlid'] = $DT['php_list_urlid'];
	$prefix = $MOD['htm_list_prefix'];
	$urlid = $MOD['list_html'] ? $MOD['htm_list_urlid'] : $MOD['php_list_urlid'];
	$ext = $MOD['list_html'] ? 'htm' : 'php';
	isset($urls[$ext]['list'][$urlid]) or $urlid = 0;
	$url = $urls[$ext]['list'][$urlid];
	$url = $page ? $url['page'] : $url['index'];
    eval("\$listurl = \"$url\";");
	if(substr($listurl, 0, 1) == '/') $listurl = substr($listurl, 1);
	return $listurl;
}

function itemurl($itemid, $catid, $addtime, $page = 0) {
	global $DT, $MOD, $CATEGORY;
	include DT_ROOT.'/include/url.inc.php';
	$file_ext = $DT['file_ext'];
	$index = $DT['index'];
	$year = date('Y', $addtime);
	$month = date('m', $addtime);
	$day = date('d', $addtime);
	$catdir = $CATEGORY[$catid]['catdir'];
	$prefix = $MOD['htm_item_prefix'];
	$urlid = $MOD['show_html'] ? $MOD['htm_item_urlid'] : $MOD['php_item_urlid'];
	$ext = $MOD['show_html'] ? 'htm' : 'php';
	$alloc = dalloc($itemid);
	$url = $urls[$ext]['item'][$urlid];
	$url = $page ? $url['page'] : $url['index'];
    eval("\$listurl = \"$url\";");
	if(substr($listurl, 0, 1) == '/') $listurl = substr($listurl, 1);
	return $listurl;
}

function rewrite($url, $encode = 0) {
	global $DT, $CFG;
	if(!$DT['rewrite']) return $url;
	if(strpos($url, '.php?') === false || strpos($url, '=') === false) return $url;
	$url = str_replace(array('.php?', '&', '='), array('-htm-', '-', '-'), $url).'.html';
	return $url;
}

function timetodate($time = 0, $type = 6) {
	if(!$time) {global $DT_TIME; $time = $DT_TIME;}
	$types = array('Y-m-d', 'Y', 'm-d', 'Y-m-d', 'm-d H:i', 'Y-m-d H:i', 'Y-m-d H:i:s');
	if(isset($types[$type])) $type = $types[$type];
	return date($type, $time);
}

function log_write($message, $type = 'php') {
	global $CFG, $DT_IP, $DT_TIME, $_username;
	$DT_IP or $DT_IP = get_env('ip');
	$DT_TIME or $DT_TIME = time();
	$user = $_username ? $_username : 'guest';
	$log = "<$type>\n";
	$log .= "\t<time>".date('Y-m-d H:i:s', $DT_TIME)."</time>\n";
	$log .= "\t<ip>".$DT_IP."</ip>\n";
	$log .= "\t<user>".$user."</user>\n";
	$log .= "\t<file>".$_SERVER['SCRIPT_NAME']."</file>\n";
	$log .= "\t<querystring>".str_replace('&', '&amp;', $_SERVER['QUERY_STRING'])."</querystring>\n";
	$log .= "\t<message>\n".$message."\t</message>\n";
	$log .= "</$type>";
	file_put(DT_ROOT.'/file/log/'.date('Ym', $DT_TIME).'/'.$type.'-'.date('Y-m-d-H-i-s', $DT_TIME).'-'.mt_rand(10, 99).'.xml', $log);
}

function load($file) {
	$ext = file_ext($file);
	if($ext == 'css') {
		echo '<link rel="stylesheet" type="text/css" href="'.SKIN_PATH.$file.'" />';
	} else if($ext == 'js') {
		echo '<script type="text/javascript" src="'.DT_PATH.'javascript/'.$file.'"></script>';
	} else if($ext == 'htm') {
		if(is_file(CACHE_ROOT.'/htm/'.$file)) {
			$content = file_get_contents(CACHE_ROOT.'/htm/'.$file);
			if(substr($content, 0, 4) == '<!--') $content = substr($content, 17);
			echo $content;
		} else {
			echo '';
		}
	}
}

function check_post() {
	if(strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') return false;
	return check_referer();
}

function check_referer() {
	global $DT_REF, $CFG;
	if(!$DT_REF) return false;
	$R = parse_url($DT_REF);
	if($CFG['cookie_domain']) {
		if(strpos($R['host'], $CFG['cookie_domain']) === false) return false;
	} else {
		$U = parse_url(DT_URL);
		if(strpos($R['host'], str_replace('www.', '.', $U['host'])) === false) return false;
	}
	return true;
}


function tag($parameter, $expires = 0) {
	global $DT, $CFG, $MODULE, $CATEGORY, $db, $DT_PRE, $DCAT, $DT_TIME, $tags;
	$CATBAK = isset($CATEGORY) ? $CATEGORY : array();
	if($expires > 0) {
		$tag_expires = $expires;
	} else if($expires == -2) {
		$tag_expires = $CFG['db_expires'];
	} else if($expires == -1) {
		$tag_expires = 0;
	} else {
		$tag_expires = $CFG['tag_expires'];
	}
	$tag_cache = false;
	$db_cache = ($expires == -2 || defined('TOHTML')) ? 'CACHE' : '';

	if($tag_expires && $db_cache != 'CACHE' && strpos($parameter, '&page=') === false) {
		$tag_cache = true;
		$cache_fileid = md5($parameter);
		$cache_file = $cache_root = CACHE_ROOT.'/tag/'.$cache_fileid.'.htm';
		if(is_file($cache_file) && ($DT_TIME - filemtime($cache_file) < $tag_expires)) {
			echo substr(file_get_contents($cache_file), 17);
			return;
		}
	}
	parse_str($parameter, $par);
	if(!is_array($par)) return '';
	$par = dstripslashes($par);
	extract($par);
	if(!isset($table)) return '';
	isset($prefix) or $prefix = $DT_PRE;
	isset($moduleid) or $moduleid = 1;
	if(!isset($MODULE[$moduleid])) return '';
	isset($fields) or $fields = '*';
	isset($catid) or $catid = 0;
	isset($child) or $child = 1;
	isset($dir) or $dir = 'tag';
	isset($template) or $template = 'list';
	isset($condition) or $condition = '1';
	isset($page) or $page = 1;
	isset($pagesize) or $pagesize = '10';
	isset($order) or $order = '';
	isset($showpage) or $showpage = 0;
	isset($datetype) or $datetype = 0;
	isset($target) or $target = '';
	isset($length) or $length = 0;
	isset($introduce) or $introduce = 0;
	$mid = $moduleid > 7 ? $moduleid : 1;
	isset($DCAT) or $DCAT = array();
	if(isset($DCAT[$mid])) {
		$CATEGORY = $DCAT[$mid];
	} else {
		$CATEGORY = $DCAT[$mid] = cache_read('category-'.$mid.'.php');
	}
	if($catid) $condition .= ($child && $CATEGORY[$catid]['child']) ? " AND catid IN (".$CATEGORY[$catid]['arrchildid'].")" : " AND catid=$catid";
	$path = $MODULE[$moduleid]['linkurl'];
	$table = $prefix.$table;
	$offset = ($page-1)*$pagesize;
	$condition = stripslashes($condition);
	$num = 0;
	if($showpage) {		
		$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition", 'CACHE');
		$num = $r['num'];
		if($catid) {
			$pages = listpages($moduleid, $catid, $num, $page, $pagesize, $CATEGORY);
			cache_item($moduleid, $catid, $num);
		} else {
			$pages = pages($num, $page, $pagesize);
		}
	}
	$order = $order ? "ORDER BY $order" : '';
	$tags = array();
	$result = $db->query("SELECT $fields FROM {$table} WHERE $condition $order LIMIT $offset,$pagesize", $db_cache, $tag_expires);
	while($r = $db->fetch_array($result)) {
		if(isset($r['title'])) {
			$r['stitle'] = $r['title'];
			if($length) $r['stitle'] = dsubstr($r['title'], $length);
			if(isset($r['style']) && $r['style']) $r['stitle'] = set_style($r['stitle'], $r['style']);
		}
		if(isset($r['introduce']) && $introduce) $r['introduce'] = dsubstr($r['introduce'], $introduce);
		$r['link'] = isset($r['linkurl']) ? $r['linkurl'] : '';
		if(isset($r['linkurl']) && $r['linkurl'] && strpos($r['linkurl'], '://') === false) $r['linkurl'] = $path.$r['linkurl'];
		$tags[] = $r;
	}
	if($template == 'null') {
		$CATEGORY = $CATBAK;
		return;
	}
	if($tag_cache) {
		ob_start();
		echo '<!--'.($DT_TIME + $tag_expires).'-->';
		include template($template, $dir);
		$contents = ob_get_contents();
		ob_clean();
		file_put($cache_file, $contents);
		$CATEGORY = $CATBAK;
		echo $contents;
	} else {
		include template($template, $dir);
		$CATEGORY = $CATBAK;
	}
}
?>