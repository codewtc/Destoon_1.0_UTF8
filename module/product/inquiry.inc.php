<?php 
defined('IN_DESTOON') or exit('Access Denied');
login();
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$itemid or message('请指定需要询盘的信息');

$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid AND status>2");
$item or message('信息不存在或正在审核');
extract($item);
unset($item);
$title = '我对您在发布的“'.$title.'”很感兴趣';
$linkurl = $MOD['linkurl'].$linkurl;
$content = '<br/>地址：<a href="'.$linkurl.'" target="_blank">'.$linkurl.'</a>';
?>
<html>
<head>
<title>正在发送...</title>
<meta http-equiv="Content-Type" content="text/html;charset=<?php echo $CFG['charset'];?>">
</head>
<body onload="document.getElementById('inquiry').submit();">
<form action="<?php echo $MODULE[2]['linkurl'];?>message.php" method="post" id="inquiry">
<input type="hidden" name="typeid" value="1" />
<input type="hidden" name="action" value="send" />
<input type="hidden" name="touser" value="<?php echo $username;?>" />
<input type="hidden" name="title" value="<?php echo $title;?>" />
<textarea name="content" style="display:none;"><?php echo $content;?></textarea>
</form>
</body>
</html>