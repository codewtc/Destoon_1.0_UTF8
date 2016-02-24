<?php
/*
	[Destoon B2B System] Copyright (c) 2009 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
require './common.inc.php';
$_userid or exit;
require DT_ROOT.'/include/post.func.php';
$from = isset($from) ? trim($from) : '';
if(!$_FILES) exit;
$uploaddir = 'file/upload/'.date('Ym/d', $DT_TIME).'/';
if(!is_dir(DT_ROOT.'/'.$uploaddir)) file_copy(DT_ROOT.'/file/index.html', DT_ROOT.'/'.$uploaddir.'index.html');
require DT_ROOT.'/include/upload.class.php';
$upload = new upload($_FILES, $uploaddir);
if($upload->uploadfile()) {	
	$session = new dsession();
	if($upload->image) {
		require_once DT_ROOT.'/include/image.class.php';
		if($from == 'thumb' || $from == 'album') {
			if(strtolower($upload->ext) == 'gif' && (!function_exists('imagegif') || !function_exists('imagecreatefromgif'))) {
				unlink(DT_ROOT.'/'.$upload->saveto);
				echo '<script type="text/javascript">alert("抱歉！系统不支持GIF格式图片处理，请上传JPG或者PNG格式");</script>';
				exit;
			}
			$width or $width = 150;
			$height or $height = 120;
		}
		if($from == 'thumb') {
			$image = new image(DT_ROOT.'/'.$upload->saveto);
			$image->thumb($width, $height);
		} else if($from == 'album') {
			$saveto = $upload->saveto;
			$upload->saveto = $upload->saveto.'.thumb.'.$upload->ext;
			file_copy(DT_ROOT.'/'.$saveto, DT_ROOT.'/'.$upload->saveto);
			$image = new image(DT_ROOT.'/'.$saveto);
			if($DT['water_type'] == 1) {
				$image->watertext();
			} else {
				$image->waterimage();
			}	
			$image = new image(DT_ROOT.'/'.$upload->saveto);
			$image->thumb($width, $height);		
		} else if($from == 'editor') {
			if($DT['water_type']) {
				$image = new image(DT_ROOT.'/'.$upload->saveto);
				if($DT['water_type'] == 1) {
					$image->watertext();
				} else {
					$image->waterimage();
				}
			}
		}
	}
	$saveto = linkurl($upload->saveto, 1);
	if($DT['ftp_remote'] && $DT['remote_url']) {
		require_once DT_ROOT.'/include/ftp.class.php';
		$ftp = new dftp($DT['ftp_host'], $DT['ftp_user'], $DT['ftp_pass'], $DT['ftp_port'], $DT['ftp_path'], $DT['ftp_pasv'], $DT['ftp_ssl']);
		if($ftp->connected) {
			$exp = explode("file/upload/", $saveto);
			if($ftp->dftp_put($upload->saveto, $exp[1])) {
				$saveto = $DT['remote_url'].$exp[1];
				@unlink(DT_ROOT.'/'.$upload->saveto);
				if(strpos($upload->saveto, '.thumb.') !== false) {
					$ext = file_ext($upload->saveto);
					$local = str_replace('.thumb.'.$ext, '', $upload->saveto);
					$ftp->dftp_put($local, str_replace('.thumb.'.$ext, '', $exp[1]));
					@unlink(DT_ROOT.'/'.$local);
				}
			}
		}
	}
	$fid = isset($fid) ? $fid : '';
	if(isset($old) && $old) delete_upload($old, $_userid);
	if($from == 'thumb') {
		echo '<script type="text/javascript">try{parent.document.getElementById("d'.$fid.'").src="'.$saveto.'";}catch(e){}parent.document.getElementById("'.$fid.'").value="'.$saveto.'";window.parent.cDialog();</script>';
	} else if($from == 'album') {
		echo '<script type="text/javascript">window.parent.getAlbum("'.$saveto.'", "'.$fid.'");window.parent.cDialog();</script>';
	} else if($from == 'editor') {
		echo '<script type="text/javascript">window.parent.SetUrl("'.$saveto.'");window.parent.GetE("frmUpload").reset();</script>';
	} else if($from == 'file') {
		echo '<script type="text/javascript">parent.document.getElementById("'.$fid.'").value="'.$saveto.'";window.parent.cDialog();</script>';
	}
	$_SESSION['uploads'][] = $saveto;
} else {
	echo '<script type="text/javascript">alert("'.$upload->errmsg.'");</script>';
}
?>