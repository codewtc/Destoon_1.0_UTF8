<?php
/*
	[Destoon B2B System] Copyright (c) 2009 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_DESTOON') or exit('Access Denied');
if(!function_exists('file_put_contents')) {
	define('FILE_APPEND', 8);
	function file_put_contents($file, $string, $append = '') {
		$mode = $append == '' ? 'wb' : 'ab';
		$fp = @fopen($file, $mode) or exit("Can not open $file");
		flock($fp, LOCK_EX);
		$stringlen = @fwrite($fp, $string);
		flock($fp, LOCK_UN);
		@fclose($fp);
		return $stringlen;
	}
}

function file_ext($filename) {
	return strtolower(trim(substr(strrchr($filename, '.'), 1)));
}

function file_down($file, $filename = '') {
	if(!is_file($file)) message('', DT_PATH);
	$filename = $filename ? $filename : basename($file);
	$filetype = file_ext($filename);
	$filesize = filesize($file);
    ob_end_clean();
	@set_time_limit(0);
	header('Cache-control: max-age=31536000');
	header('Expires: '.gmdate('D, d M Y H:i:s', time() + 31536000).' GMT');
	header('Content-Encoding: none');
	header('Content-Length: '.$filesize);
	header('Content-Disposition: attachment; filename='.$filename);
	header('Content-Type: '.$filetype);
	readfile($file);
	exit;
}

function file_list($dir, $fs = array()) {
	$files = glob($dir.'/*');
	if(!is_array($files)) return $fs;
	foreach($files as $file) {
		if(is_dir($file)) {
			$fs = file_list($file, $fs);
		} else {
			$fs[] = $file;
		}
	}
	return $fs;
}

function file_copy($from, $to) {
	dir_create(dirname($to));
	if(is_file($to)) @chmod($to, 0777);
	if(@copy($from, $to)) {
		@chmod($to, 0777);
		return true;
	} else {
		return false;
	}
}

function file_put($filename, $data) {
	dir_create(dirname($filename));
	file_put_contents($filename, $data);
	@chmod($filename, 0777);
	return is_file($filename);
}

function dir_path($dirpath) {
	$dirpath = str_replace('\\', '/', $dirpath);
	if(substr($dirpath, -1) != '/') $dirpath = $dirpath.'/';
	return $dirpath;
}

function dir_create($path, $mode = 0777) {
	if(is_dir($path)) return true;
	$dir = str_replace(DT_ROOT.'/', '', $path);
	$dir = dir_path($dir);
    $temp = explode('/', $dir);
    $cur_dir = DT_ROOT.'/';
	$max = count($temp) - 1;
    for($i = 0; $i < $max; $i++) {
        $cur_dir .= $temp[$i].'/';
        if(is_dir($cur_dir)) continue;
		//@mkdir($cur_dir, $mode);
		@mkdir($cur_dir);
		@chmod($cur_dir, $mode);
    }
	return is_dir($path);           
}

function dir_chmod($dir, $mode = 0777, $require = 0) {
	if(!$require) $require = substr($dir, -1) == '*' ? 2 : 0;
	if($require) {
		if($require == 2) $dir = substr($dir, 0, -1);
	    $dir = dir_path($dir);
		$list = glob($dir.'*');
		foreach($list as $v) {
			if(is_dir($v)) {
				dir_chmod($v, $mode, 1);
			} else {
				@chmod(basename($v), $mode);
			}
		}
	}
	if(is_dir($dir)) {
		@chmod($dir, $mode);
	} else {
		@chmod(basename($dir), $mode);
	}
}

function dir_copy($fromdir, $todir) {
	$fromdir = dir_path($fromdir);
	$todir = dir_path($todir);
	if(!is_dir($fromdir)) return false;
	if(!is_dir($todir)) dir_create($todir);
	$list = glob($fromdir.'*');
	foreach($list as $v) {
		$path = $todir.basename($v);
		if(is_file($path) && !is_writable($path)) @chmod($path, 0777);
		if(is_dir($v)) {
		    dir_copy($v, $path);
		} else {
			@copy($v, $path);
			@chmod($path, 0777);
		}
	}
    return true;
}

function dir_delete($dir) {
	$dir = dir_path($dir);
	if(!is_dir($dir)) return false;
	$systemdirs = array(DT_ROOT.'/admin/', DT_ROOT.'/api/', CACHE_ROOT.'/', DT_ROOT.'/editor/', DT_ROOT.'/file/', DT_ROOT.'/include/', DT_ROOT.'/javascript/', DT_ROOT.'/member/', DT_ROOT.'/module/', DT_ROOT.'/plugin/', DT_ROOT.'/skin/', DT_ROOT.'/template/', DT_ROOT.'/wap/');
	if(substr($dir, 0, 1) == '.' || in_array($dir, $systemdirs)) die("Cannot remove system dir $dir ");
	$list = glob($dir.'*');
	if($list) {
		foreach($list as $v) {
			is_dir($v) ? dir_delete($v) : @unlink($v);
		}
	}
    return @rmdir($dir);
}
?>