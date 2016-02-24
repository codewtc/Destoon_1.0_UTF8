<?php
defined('IN_DESTOON') or exit('Access Denied');
$partner = $PAY[$bank]['partnerid'];			//合作伙伴ID
$security_code = $PAY[$bank]['keycode'];		//安全检验码
$seller_email = $PAY[$bank]['email'];	//卖家邮箱
$_input_charset = $CFG['charset'];		//字符编码格式  目前支持 GBK 或 utf-8
$sign_type = 'MD5';				//加密方式  系统默认(不要修改)
$transport= 'http';			//访问模式,你可以根据自己的服务器是否支持ssl访问而选择http以及https访问模式(系统默认,不要修改)
$notify_url = DT_URL.'api/'.$PAY[$bank]['notify'];		// 异步返回地址
$return_url = $receive_url;		//同步返回地址
$show_url   = DT_URL;		//你网站商品的展示地址,可以为空
?>