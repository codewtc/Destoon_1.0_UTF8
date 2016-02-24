<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<div class="tt">添加<?php echo VIP;?></div>
<table cellpadding="2" cellspacing="1" class="tb">
<form method="post" action="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>" id="dform" onsubmit="return check();">
<tr>
<td class="tl">会员名 <span class="f_red">*</span></td>
<td><input type="text" size="20" name="vip[username]" id="username" value="<?php echo $username;?>"/> <span id="dusername" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">会员组 <span class="f_red">*</span></td>
<td id="groupid">
<?php foreach($GROUP as $g) {
	if($g['vip'] > 0) echo '<input type="radio" name="vip[groupid]" value="'.$g['groupid'].'"'.($g['groupid'] == 6 ? 'checked' : '').'/> '.$g['groupname'].'&nbsp;';
}
?>
</td>
</tr>
<tr>
<td class="tl">服务有效期 <span class="f_red">*</span></td>
<td><?php echo dcalendar('vip[fromtime]', $fromtime);?> 至 <?php echo dcalendar('vip[totime]', $totime);?> <span id="dtime" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">企业资料是否通过认证 <span class="f_red">*</span></td>
<td>
<input type="radio" name="vip[validated]" value="1"/> 是&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="vip[validated]" value="0" checked/> 否
</td>
</tr>
<tr>
<td class="tl">认证名称或机构</td>
<td><input type="text" name="vip[validator]" size="30"/></td>
</tr>
<tr>
<td class="tl">认证日期</td>
<td><?php echo dcalendar('vip[validtime]', $fromtime);?></td>
</tr>
<tr>
<td class="tl">备注</td>
<td><textarea name="vip[note]" rows="4" cols="60"></textarea></td>
</tr>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
<script type="text/javascript">
function check() {
	var l;
	var f;
	f = 'username';
	if($(f).value == '') {
		Dmsg('请填写会员名', f);
		return false;
	}
	if($('vipfromtime').value.length != 10 || $('viptotime').value.length != 10) {
		Dmsg('请选择服务有效期', 'time', 1);
		return false;
	}
	return true;
}
</script>
<script type="text/javascript">Menuon(0);</script>
</body>
</html>