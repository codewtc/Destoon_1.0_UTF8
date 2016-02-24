<?php
/*
	[Destoon B2B System] Copyright (c) 2009 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_DESTOON') or exit('Access Denied');
class captcha {
	var $func;
	var $chars;
	var $length;
	var $soundtag;
	var $soundstr;

	function captcha() {
		global $DT;
		$this->func = true;
		$this->chars = 'abcdefghjkmnpqrstuwxyz23456789ABCDEFGHIJKLMNPRSTUVWXYZ';
		$this->length = 4;
		$this->ck_func();
	}

	function question() {
		global $db, $DT_PRE, $DT_IP, $CFG;
		$r = $db->get_one("SELECT * FROM {$DT_PRE}question ORDER BY rand()");
		$_SESSION['answerstr'] = md5(md5($r['answer'].$CFG['authkey'].$DT_IP));
		exit('document.write("'.$r['question'].'");');
	}

	function image() {
		global $CFG, $DT_IP, $_username;
		header("Expires: Sun, 11 Apr 1999 08:00:00 GMT");
		header("Cache-Control: no-cache, no-store, max-age=0");
		header("Pragma: no-cache");
		header("Content-type: image/png");
		if($this->func) {
			$string = $this->mk_str();
			$_SESSION['captchastr'] = md5(md5(strtoupper($string).$CFG['authkey'].$DT_IP));
			$imageX = $this->length*21;
			$imageY = 22;
			$bgimg = '';
			if(mt_rand(1, 2) == 1) {
				$bgs = glob(DT_ROOT.'/file/background/*.jpg');
				if(is_array($bgs)) {
					$bgimg = $bgs[mt_rand(0, count($bgs)-1)];
					$bgimg = imagecreatefromjpeg($bgimg);
				}
			}
			$im = imagecreatetruecolor($imageX, $imageY);  
			imagefill($im, 0, 0, imagecolorallocate($im, 250, 250, 250));  
			if($bgimg) imagecopy($im, $bgimg, 0, 0, mt_rand(0, 10), 0, $imageX, $imageY);
			$num = mt_rand(3, 10);
			for ($i = 0; $i < $num; $i++) {
				imageline($im, mt_rand(0, intval($imageX/2)), mt_rand(0, $imageY), mt_rand(intval($imageX/2), $imageX), mt_rand(0, $imageY), imagecolorallocate($im, mt_rand(120, 255), mt_rand(120, 255), mt_rand(120, 255)));
			}
			$fonts = glob(DT_ROOT.'/file/font/*.ttf');
			$num = count($fonts) - 1;
			for($i = 0; $i < $this->length; $i++) {
				$size = mt_rand(12, 16);
				$angle = mt_rand(-10, 10);
				$X = $i*18 + mt_rand(6, 10);
				$Y = 15 + mt_rand(0, 5);
				$color = imagecolorallocate($im, mt_rand(0, 120), mt_rand(0, 120), mt_rand(0, 120));
				$shadow = imagecolorallocate($im, mt_rand(120, 255), mt_rand(120, 255), mt_rand(120, 255));
				$font = $fonts[mt_rand(0, $num)];
				imagettftext($im, $size, $angle, $X+1, $Y+1, $shadow, $font, $string{$i});
				imagettftext($im, $size, $angle, $X, $Y, $color, $font, $string{$i});
			}
			for($i = 0; $i < 50; $i++) {
				imagesetpixel($im, mt_rand(0, $imageX), mt_rand(0, $imageY), imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255)));
			}
			imagepng($im);
			imagedestroy($im);
			if($bgimg) imagedestroy($bgimg);
		} else {
			$pngs = glob(DT_ROOT.'/file/captcha/*.png');
			if(!is_array($pngs)) return false;
			$captcha = $pngs[mt_rand(0, count($pngs)-1)];
			$string = substr(basename($captcha), 0, 4);
			$_SESSION['captchastr'] = md5(md5(strtoupper($string).$CFG['authkey'].$DT_IP));
			include $captcha;
		}
		exit;
	}

	function mk_str() {
		$str = '';
		$max = strlen($this->chars) - 1;
		while(1) {
			if(strlen($str) == $this->length) break;
			$r = mt_rand(0, $max);
			if(strpos(strtolower($str), strtolower($this->chars{$r})) === false) $str .= $this->chars{$r};
		}
		return $str;
	}

	function ck_func() {
		$gd_funcs = array('imagecreatefromjpeg', 'imagecreatetruecolor', 'imagefill', 'imagecolorallocate', 'imagecopy', 'imagestring', 'imagerectangle', 'imagepng', 'imagedestroy', 'imagettftext');
		foreach($gd_funcs as $gd_func) {
			if(!function_exists($gd_func)) { $this->func = false; break; }
		}
	}
}
?>