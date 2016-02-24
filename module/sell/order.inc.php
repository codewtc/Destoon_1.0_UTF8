<?php 
defined('IN_DESTOON') or exit('Access Denied');
login();
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$itemid or message('请指定信息', $MOD['linkurl']);
$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid AND status>2");
$item or message('信息不存在或正在审核', $MOD['linkurl']);
extract($item);
unset($item);
if($DT_TIME > $totime) message('此信息已过期', $MOD['linkurl'].$linkurl);
if(!$price || !$unit || !$minamount) message('此信息未设置价格或计量单位或起定量，无法在线订购', $MOD['linkurl'].$linkurl, 5);
$userurl = userurl($username);
$thumb = $thumb ? imgurl($thumb, 1) : '';
$linkurl = linkurl($MOD['linkurl'].$linkurl, 1);
if($submit) {
	if(!$number) message('请填写订货总量');
	if($minamount && $number < $minamount) message('订货总量不能小于最小起订量');
	if($amount && $number > $amount) message('订货总量不能大于供货总量');
	$order_amount = dround($number*$price);
	$user = $db->get_one("SELECT m.truename,m.mobile,c.postcode,c.address FROM {$DT_PRE}member m,{$DT_PRE}company c WHERE m.userid=c.userid AND m.userid='$_userid'");
	$head_title = '确认订单 - '.$title;
} else {
	$head_title = '订购产品 - '.$title;
}
include template('order', $module);
?>