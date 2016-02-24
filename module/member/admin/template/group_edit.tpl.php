<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<div class="tt">会员组修改</div>
<form method="post" action="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=edit&groupid=<?php echo $groupid;?>" onsubmit="return check();">
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">会员组名称 <span class="f_red">*</span></td>
<td><input type="text" size="20" name="groupname" id="groupname" value="<?php echo $groupname;?>"/> <span id="dgroupname" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><?php echo VIP;?>指数 <span class="f_red">*</span></td>
<td><input type="text" size="20" name="vip" id="vip" value="<?php echo $vip;?>"/> <span class="f_gray">免费会员请填0，收费会员请填1-9数字</span> <span id="dvip" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">收费设置 <span class="f_red">*</span></td>
<td><input type="text" size="20" name="setting[fee]" id="fee" value="<?php echo $fee;?>"/> 元/年 <span class="f_gray">免费会员请填0</span> <span id="dfee" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">独享买家信息</td>
<td>
<input type="radio" name="setting[buyerinfo]" value="1" <?php if($buyerinfo) echo 'checked';?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="setting[buyerinfo]" value="0" <?php if(!$buyerinfo) echo 'checked';?>> 否
</td>
</tr>

<tr>
<td class="tl">拥有公司主页</td>
<td>
<input type="radio" name="setting[homepage]" value="1" <?php if($homepage) echo 'checked';?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="setting[homepage]" value="0" <?php if(!$homepage) echo 'checked';?>> 否
</td>
</tr>

<tr>
<td class="tl">允许发布信息的模块</td>
<td>
<?php
	foreach($MODULE as $m) {
		if($m['moduleid'] > 4 && is_file(DT_ROOT.'/module/'.$m['module'].'/my.inc.php')) {
			echo '<input type="checkbox" name="setting[moduleids][]" value="'.$m['moduleid'].'" '.(in_array($m['moduleid'], $moduleids) ? 'checked' : '').'/> '.$m['name'].'&nbsp;&nbsp;';
		}
	}
?>
</td>
</tr>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
<script type="text/javascript">
function check() {
	var l;
	var f;
	f = 'groupname';
	l = $(f).value.length;
	if(l < 2) {
		Dmsg('请填写会员组名称', f);
		return false;
	}
	f = 'vip';
	if($(f).value == '') {
		Dmsg('请填写<?php echo VIP;?>指数', f);
		return false;
	}
	f = 'fee';
	if($(f).value == '') {
		Dmsg('请填写收费设置', f);
		return false;
	}
	return true;
}
</script>
<script type="text/javascript">Menuon(1);</script>
</body>
</html>