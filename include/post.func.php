<?php
/*
	[Destoon B2B System] Copyright (c) 2009 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_DESTOON') or exit('Access Denied');
function dsafe($string) {
	$search = array("/&#([a-z0-9]+)([;]*)/i", "/(j[\s\r\n\t]*a[\s\r\n\t]*v[\s\r\n\t]*a[\s\r\n\t]*s[\s\r\n\t]*c[\s\r\n\t]*r[\s\r\n\t]*i[\s\r\n\t]*p[\s\r\n\t]*t|jscript|js|vbscript|vbs|about|expression|script|frame|link|import)/i", "/on(mouse|exit|error|click|dblclick|key|load|unload|change|move|submit|reset|cut|copy|select|start|stop)/i");
	$replace = array("", "<d>\\1</d>", "on\n\\1");
	$string = preg_replace($search, $replace, $string);
	return $string;
}

function deditor($moduleid = 1, $textareaid = 'content', $toolbarset = 'Default', $width = 500, $height = 400) {
	$width = is_numeric($width) ? $width.'px' : $width;
	$height = is_numeric($height) ? $height.'px' : $width;
	$editor = '';
	$editor .= '<script type="text/javascript">var ModuleID = '.$moduleid.';</script>';
	$editor .= '<script type="text/javascript">var DTAdmin = '.(defined('DT_ADMIN') ? 1 : 0).';</script>';
	$editor .= '<script type="text/javascript" src="'.DT_PATH.'editor/fckeditor/fckeditor.js"></script>';
	$editor .= '<script type="text/javascript">';
	$editor .= 'window.onload = function() {';
	$editor .= 'var sBasePath = "'.DT_PATH.'editor/fckeditor/";';
	$editor .= 'var oFCKeditor = new FCKeditor("'.$textareaid.'");';
	$editor .= 'oFCKeditor.Width = "'.$width.'";';
	$editor .= 'oFCKeditor.Height = "'.$height.'";';
	$editor .= 'oFCKeditor.BasePath = sBasePath;';
	$editor .= 'oFCKeditor.ToolbarSet = "'.$toolbarset.'";';
	$editor .= 'oFCKeditor.ReplaceTextarea();';
	$editor .= '}';
	$editor .= '</script>';
	echo $editor;
}

function dstyle($name, $value = '') {
	global $destoon_style_id;
	$style = $color = '';
	if(preg_match("/^#[0-9a-zA-Z]{6}$/", $value)) $color = $value;
	if(!$destoon_style_id) {
		$destoon_style_id = 1;
		$style .= '<script type="text/javascript" src="'.DT_PATH.'javascript/color.js"></script>';
	} else {
		$destoon_style_id++;
	}
	$style .= '<input type="hidden" name="'.$name.'" id="color_input_'.$destoon_style_id.'" value="'.$color.'"/><img src="'.SKIN_PATH.'image/color.gif" width="21" height="18" align="absmiddle" id="color_img_'.$destoon_style_id.'" style="cursor:pointer;background:'.$color.'" alt="选择颜色" title="选择颜色" onclick="color_show('.$destoon_style_id.', $(\'color_input_'.$destoon_style_id.'\').value, this);"/>';
	return $style;
}

function dcalendar($name, $value = '', $sep = '-') {
	global $destoon_calendar_id;
	$calendar = '';
	$id = str_replace(array('[', ']'), array('', ''), $name);
	if(!$destoon_calendar_id) {
		$destoon_calendar_id = 1;
		$calendar .= '<script type="text/javascript" src="'.DT_PATH.'javascript/calendar.js"></script>';
	}
	$calendar .= '<input type="text" name="'.$name.'" id="'.$id.'" value="'.$value.'" size="10" onfocus="calendar_show(\''.$id.'\', this, \''.$sep.'\');" readonly/> <img src="'.SKIN_PATH.'image/calendar.gif" align="absmiddle" onclick="calendar_show(\''.$id.'\', this, \''.$sep.'\');" style="cursor:pointer;"/>';
	return $calendar;
}

function dselect($sarray, $name, $title = '', $selected = 0, $extend = '', $key = 1, $ov = '', $abs = 0) {
	$select = '<select name="'.$name.'" '.$extend.'>';
	if($title) $select .= '<option value="'.$ov.'">'.$title.'</option>';
	foreach($sarray as $k=>$v) {
		if(!$v) continue;
		$_selected = ($abs ? ($key ? $k : $v) === $selected : ($key ? $k : $v) == $selected) ? ' selected=selected' : '';
		$select .= '<option value="'.($key ? $k : $v).'"'.$_selected.'>'.$v.'</option>';
	}	
	$select .= '</select>';
	return $select;
}

function dcheckbox($sarray, $name, $checked = '', $extend = '', $key = 1, $except = '', $abs = 0) {
	$checked = $checked ? explode(',', $checked) : array();
	$except = $except ? explode(',', $except) : array();
	$checkbox = $sp = '';
	foreach($sarray as $k=>$v) {
		if(in_array($key ? $k : $v, $except)) continue;
		$sp = in_array($key ? $k : $v, $checked) ? ' checked ' : '';
		$checkbox .= '<input type="checkbox" name="'.$name.'" value="'.($key ? $k : $v).'"'.$sp.$extend.'> '.$v.'&nbsp;';
	}
	return $checkbox;
}

function type_select($item, $cache = 0, $name = 'typeid', $title = '', $typeid = 0, $extend = '', $all = '') {
	global $TYPE;
	$TYPE or $TYPE = get_type($item, $cache);
	$select = '<select name="'.$name.'" '.$extend.'>';
	if($all) $select .= '<option value="-1"'.($typeid == -1 ? ' selected=selected' : '').'>'.$all.'</option>';
	if($title) $select .= '<option value="0"'.($typeid == 0 ? ' selected=selected' : '').'>'.$title.'</option>';
	foreach($TYPE as $k=>$v) {
		$select .= ' <option value="'.$k.'"'.($k == $typeid ? ' selected' : '').'> '.$v['typename'].'</option>';
	}
	$select .= '</select>';
	return $select;
}

function url_select($name, $ext = 'htm', $type = 'list', $urlid = 0, $extend = '') {
	include DT_ROOT."/include/url.inc.php";
	$select = '<select name="'.$name.'" '.$extend.'>';
	$types = count($urls[$ext][$type]);
	for($i = 0; $i < $types; $i++) {
		$select .= ' <option value="'.$i.'"'.($i == $urlid ? ' selected' : '').'>例 '.$urls[$ext][$type][$i]['example'].'</option>';
	}
	$select .= '</select>';
	return $select;
}

function module_select($name = 'module', $title = '', $module = '', $extend = '') {
	$modules = get_modules();
	$select = '<select name="'.$name.'" '.$extend.'><option value="0">'.$title.'</option>';
	foreach($modules as $k=>$v) {
		$select .= '<option value="'.$v['module'].'"'.($module == $v['module'] ? ' selected' : '').'>'.$v['name'].'</option>';
	}
	$select .= '</select>';
	return $select;
}

function tpl_select($file = 'index', $module = '', $name = 'template', $title = '', $template = '', $extend = '') {
	global $CFG;
    $tpldir = $module ? DT_ROOT."/template/".$CFG['template']."/".$module : DT_ROOT."/template/".$CFG['template'];
	@include $tpldir."/these.name.php";
	$select = '<select name="'.$name.'" '.$extend.'><option value="">'.$title.'</option>';
	$files = glob($tpldir."/*.htm");
	foreach($files as $tplfile)	{
		$tplfile = basename($tplfile);
		$tpl = str_replace('.htm', '', $tplfile);
		if(preg_match("/^".$file."-(.*)/i", $tpl) || !$file) {//$file == $tpl || 
			$selected = ($template && $tpl == $template) ? 'selected' : '';
            $templatename = (isset($names[$tpl]) && $names[$tpl]) ? $names[$tpl] : $tpl;
			$select .= '<option value="'.$tpl.'" '.$selected.'>'.$templatename.'</option>';
		}
	}
	$select .= '</select>';
	return $select;
}

function group_select($name = 'groupid', $title = '', $groupid = '', $extend = '') {
	global $GROUP;
	if(!$GROUP) $GROUP = cache_read('group.php');
	$select = '<select name="'.$name.'" '.$extend.'><option value="0">'.$title.'</option>';
	foreach($GROUP as $k=>$v) {
		$select .= '<option value="'.$k.'"'.($k == $groupid ? ' selected' : '').'>'.$v['groupname'].'</option>';
	}
	$select .= '</select>';
	return $select;
}

function group_checkbox($name = 'groupid', $checked = '', $except = '1,2,3,4') {
	global $GROUP;
	if(!$GROUP) $GROUP = cache_read('group.php');
	$checked = $checked ? explode(',', $checked) : array();
	$except = $except ? explode(',', $except) : array();
	$str = $sp = '';
	foreach($GROUP as $k=>$v) {
		if(in_array($k, $except)) continue;
		$sp = in_array($k, $checked) ? ' checked' : '';
		$str .= '<input type="checkbox" name="'.$name.'" value="'.$k.'"'.$sp.'> '.$v['groupname'].'&nbsp;';
	}
	return $str;
}

function category_select($name = 'catid', $title = '', $catid = 0, $moduleid = 1, $extend = '') {
	$option = cache_read('cattree-'.$moduleid.'.php', '', true);
	if($catid) $option = str_replace('value="'.$catid.'"', 'value="'.$catid.'" selected', $option);
	$select = '<select name="'.$name.'" '.$extend.'>';
	if($title) $select .= '<option value="0">'.$title.'</option>';
	$select .= $option ? $option : '</select>';
	return $select;
}

function get_category_select($title = '', $catid = 0, $moduleid = 1, $extend = '', $deep = 0) {
	global $CATEGORY;
	$CATEGORY or $CATEGORY = cache_read('category-'.$moduleid.'.php');
	$parents = array();
	$cid = $catid;
	if($catid && $CATEGORY[$catid]['child']) $parents[] = $catid;
	while($catid) {
		if($CATEGORY[$cid]['parentid']) {
			$parents[] = $cid = $CATEGORY[$cid]['parentid'];
		} else {
			break;
		}
	}
	$parents[] = 0;
	$parents = array_reverse($parents);
	$select = '';
	foreach($parents as $k=>$v) {
		if($deep && $deep <= $k) break;
		$select .= '<select onchange="$(\'catid\').value=this.value;load_category(this.value);" '.$extend.'>';
		if($title) $select .= '<option value="0">'.$title.'</option>';
		foreach($CATEGORY as $c) {
			if($c['parentid'] == $v) {
				$selectid = isset($parents[$k+1]) ? $parents[$k+1] : $catid;
				$selected = $c['catid'] == $selectid ? ' selected' : '';
				$select .= '<option value="'.$c['catid'].'"'.$selected.'>'.$c['catname'].'</option>';
			}
		}
		$select .= '</select> ';
	}
	return $select;
}

function ajax_category_select($name = 'catid', $title = '', $catid = 0, $moduleid = 1, $extend = '', $deep = 0) {
	return '<input name="'.$name.'" id="catid" type="hidden" value="'.$catid.'"><span id="load_category">'.get_category_select($title, $catid, $moduleid, $extend, $deep).'</span><script type="text/javascript">var category_title = \''.$title.'\';var category_moduleid = '.$moduleid.';var category_extend = \''.$extend.'\';var category_deep = '.intval($deep).';</script><script type="text/javascript" src="'.DT_PATH.'javascript/category.js"></script>';
}

function area_select($name = 'areaid', $title = '', $areaid = 0, $extend = '') {
	$option = cache_read('areatree.php', '', true);
	if($areaid) $option = str_replace('value="'.$areaid.'"', 'value="'.$areaid.'" selected', $option);
	$select = '<select name="'.$name.'" '.$extend.'><option value="0">'.$title.'</option>';
	$select .= $option ? $option : '</select>';
	return $select;
}

function get_area_select($title = '', $areaid = 0, $extend = '', $deep = 0) {
	global $AREA;
	$AREA or $AREA = cache_read('area.php');
	$parents = array();
	$aid = $areaid;
	if($areaid && $AREA[$areaid]['child']) $parents[] = $areaid;
	while($areaid) {
		if($AREA[$aid]['parentid']) {
			$parents[] = $aid = $AREA[$aid]['parentid'];
		} else {
			break;
		}
	}
	$parents[] = 0;
	$parents = array_reverse($parents);
	$select = '';
	foreach($parents as $k=>$v) {
		if($deep && $deep <= $k) break;
		$select .= '<select onchange="$(\'areaid\').value=this.value;load_area(this.value);" '.$extend.'>';
		if($title) $select .= '<option value="0">'.$title.'</option>';
		foreach($AREA as $a) {
			if($a['parentid'] == $v) {
				$selectid = isset($parents[$k+1]) ? $parents[$k+1] : $areaid;
				$selected = $a['areaid'] == $selectid ? ' selected' : '';
				$select .= '<option value="'.$a['areaid'].'"'.$selected.'>'.$a['areaname'].'</option>';
			}
		}
		$select .= '</select> ';
	}
	return $select;
}

function ajax_area_select($name = 'areaid', $title = '', $areaid = 0, $extend = '', $deep = 0) {
	return '<input name="'.$name.'" id="areaid" type="hidden" value="'.$areaid.'"><span id="load_area">'.get_area_select($title, $areaid, $extend, $deep).'</span><script type="text/javascript">var area_title = \''.$title.'\';var area_extend = \''.$extend.'\';var area_deep = '.intval($deep).';</script><script type="text/javascript" src="'.DT_PATH.'javascript/area.js"></script>';
}

function level_select($name, $title = '', $level = 0, $extend = '') {
	$select = '<select name="'.$name.'" '.$extend.'>';
	if($title) $select .= '<option value="0">'.$title.'</option>';
	for($i = 1; $i < 10; $i++) {
		$select .= '<option value="'.$i.'"'.($i == $level ? ' selected' : '').'>'.$i.' 级</option>';
	}
	$select .= '</select>';
	return $select;
}

function is_email($email) {
	return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
}

function is_gbk($string) {
	return preg_match("/^([\s\S]*?)([\x81-\xfe][\x40-\xfe])([\s\S]*?)/", $string);
}

function is_date($date, $sep = '-') {
	if(empty($date)) return false;
	if(strlen($date) > 10)  return false;
	list($year, $month, $day) = explode($sep, $date);
	return checkdate($month, $day, $year);
}

function is_image($file) {
	return preg_match("/^(jpg|jpeg|gif|png)$/i", file_ext($file));
}

function is_user($username) {
	global $db, $DT_PRE;
	$r = $db->get_one("SELECT username FROM {$DT_PRE}member WHERE username='$username'");
	return $r ? true : false;
}

function is_password($username, $password) {
	global $db, $DT_PRE;
	$r = $db->get_one("SELECT password FROM {$DT_PRE}member WHERE username='$username'");
	if(!$r) return false;
	return $r['password'] == (is_md5($password) ? md5($password) : md5(md5($password)));
}

function is_md5($password) {
	return preg_match("/^[a-z0-9]{32}$/", $password);
}

function match_userid($file) {
	$file = basename($file);
	if(preg_match("/\-([0-9]{2}+)\-([0-9]{1,}+)\./", $file, $m)) {
		return $m[2];
	} else {
		return 0;
	}
}

function clear_link($content) {
	$content = preg_replace("/<a[^>]*>/i", "", $content);
	return preg_replace("/<\/a>/i", "", $content); 
}

function save_remote($content, $ext = 'jpg|jpeg|gif|png') {
	global $DT, $DT_TIME, $_userid;
	if(!$_userid || !$content) return $content;
	if(!preg_match_all("/src=([\"|']?)([^ \"'>]+\.($ext))\\1/i", $content, $matches)) return $content;
	require_once DT_ROOT.'/include/image.class.php';
	$dftp = false;
	if($DT['ftp_remote'] && $DT['remote_url']) {
		require_once DT_ROOT.'/include/ftp.class.php';
		$ftp = new dftp($DT['ftp_host'], $DT['ftp_user'], $DT['ftp_pass'], $DT['ftp_port'], $DT['ftp_path'], $DT['ftp_pasv'], $DT['ftp_ssl']);
		$dftp = $ftp->connected;
	}
	$urls = $oldpath = $newpath = array();
	foreach($matches[2] as $k=>$url) {
		if(in_array($url, $urls)) continue;
		$urls[$url] = $url;		
		if(strpos($url, '://') === false || match_userid($url) == $_userid) continue;
		$filedir = 'file/upload/'.date('Ym/d', $DT_TIME).'/';
		$filepath = DT_PATH.$filedir;
		$fileroot = DT_ROOT.'/'.$filedir;
		$file_ext = file_ext($url);
		$filename = date('H-i-s', $DT_TIME).'-'.rand(10, 99).'-'.$_userid.'.'.$file_ext;
		$newfile = $fileroot.$filename;
		if(file_copy($url, $newfile)) {
			if(is_image($newfile) && $DT['water_type']) {
				$image = new image($newfile);
				if($DT['water_type'] == 1) {
					$image->watertext();
				} else {
					$image->waterimage();
				}
			}
			$oldpath[] = $url;
			$newurl = linkurl($filepath.$filename, 1);
			if($dftp) {
				$exp = explode("file/upload/", $newurl);
				if($ftp->dftp_put($filedir.$filename, $exp[1])) {
					$newurl = $DT['remote_url'].$exp[1];
					@unlink($newfile);
				}
			}
			$newpath[] = $newurl;
		}
	}
	unset($matches);
	return str_replace($oldpath, $newpath, $content);
}

function delete_local($content, $userid, $ext = 'jpg|jpeg|gif|png|swf') {
	if(preg_match_all("/src=([\"|']?)([^ \"'>]+\.($ext))\\1/i", $content, $matches)) {
		foreach($matches[2] as $url) {
			delete_upload($url, $userid);
		}
		unset($matches);
	}
}

function delete_diff($new, $old, $ext = 'jpg|jpeg|gif|png|swf') {
	global $_userid;
	$new = stripslashes($new);
	$diff_urls = $new_urls = $old_urls = array();
	if(preg_match_all("/src=([\"|']?)([^ \"'>]+\.($ext))\\1/i", $old, $matches)) {
		foreach($matches[2] as $url) {
			$old_urls[] = $url;
		}
	} else {
		return;
	}
	if(preg_match_all("/src=([\"|']?)([^ \"'>]+\.($ext))\\1/i", $new, $matches)) {
		foreach($matches[2] as $url) {
			$new_urls[] = $url;
		}
	}
	foreach($old_urls as $url) {
		in_array($url, $new_urls) or $diff_urls[] = $url;
	}
	if(!$diff_urls) return;
	foreach($diff_urls as $url) {
		delete_upload($url, $_userid);
	}
	unset($new, $old, $matches, $url, $diff_urls, $new_urls, $old_urls);
}

function delete_upload($file, $userid) {
	global $CFG, $DT, $DT_TIME, $ftp;
	if(!$userid || $userid != match_userid($file)) return false;
	if(strpos($file, 'file/upload') === false) {//Remote
		if($DT['ftp_remote'] && $DT['remote_url']) {
			if(strpos($file, $DT['remote_url']) !== false) {
				if(!is_object($ftp)) {
					require_once DT_ROOT.'/include/ftp.class.php';
					$ftp = new dftp($DT['ftp_host'], $DT['ftp_user'], $DT['ftp_pass'], $DT['ftp_port'], $DT['ftp_path'], $DT['ftp_pasv'], $DT['ftp_ssl']);
				}
				$file = str_replace($DT['remote_url'], '', $file);
				$ftp->dftp_delete($file);
				if(strpos($file, '.thumb.') !== false) {
					$file = str_replace('.thumb.'.file_ext($file), '', $file);
					$ftp->dftp_delete($file);
				}
				return true;
			}
		}
	} else {//Local
		$exp = explode("file/upload/", $file);
		$file = DT_ROOT.'/file/upload/'.$exp[1];
		if(is_file($file)) {
			unlink($file);
			if(strpos($file, '.thumb.') !== false) @unlink(str_replace('.thumb.'.file_ext($file), '', $file));
		}
		return true;
	}
	return false;
}

function clear_upload($content = '') {
	global $CFG, $session, $_userid;
	if(!is_object($session)) $session = new dsession();
	if(!isset($_SESSION['uploads']) || !$_SESSION['uploads'] || !$content) return;
	foreach($_SESSION['uploads'] as $file) {
		if(strpos($content, $file) === false) delete_upload($file, $_userid);
	}
	$_SESSION['uploads'] = array();
}

function get_status($status, $check) {
	if($status == 0) {//Recycle
		return 0;
	} else if($status == 1) {//Rejected
		return 2;
	} else if($status == 2) {//Checking
		return 2;
	} else if($status == 3) {//
		return $check ? 2 : 3;
	} else if($status == 4) {//Expired
		return $check ? 2 : 3;
	} else {
		return 2;
	}
}
?>