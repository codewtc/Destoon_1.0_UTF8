<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form method="post" action="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>" id="dform" onsubmit="return check();">
<div class="tt">添加链接</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">网站分类 <span class="f_red">*</span></td>
<td><?php echo type_select('link', 1, 'post[typeid]', '请选择分类', 0, 'id="typeid"');?> <span id="dtypeid" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">网站名称 <span class="f_red">*</span></td>
<td><input name="post[title]" type="text" id="title" size="40" /> <?php echo level_select('post[level]', '级别');?> <?php echo dstyle('post[style]');?> <span id="dtitle" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">网站地址 <span class="f_red">*</span></td>
<td><input name="post[linkurl]" type="text" id="linkurl" size="40" value="http://"/> <span id="dlinkurl" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">网站LOGO</td>
<td><input name="post[thumb]" type="text" id="thumb" size="40"/>&nbsp;&nbsp;<span onclick="Dfile(<?php echo $moduleid;?>, $('thumb').value, 'thumb');" class="jt">[上传]</span>&nbsp;&nbsp;<span onclick="_preview($('thumb').value);" class="jt">[预览]</span>&nbsp;&nbsp;<span onclick="$('thumb').value='';" class="jt">[删除]</span></td>
</tr>
<tr>
<td class="tl">网站介绍</td>
<td><textarea name="post[introduce]" style="width:400px;height:40px;"></textarea>
</td>
</tr>
<tr>
<td class="tl">链接状态</td>
<td>
<input type="radio" name="post[status]" value="3" checked/> 通过
<input type="radio" name="post[status]" value="2" /> 待审
</td>
</tr>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
<?php load('clear.js'); ?>
<script type="text/javascript">
function check() {
	var l;
	var f;
	f = 'typeid';
	l = $(f).value;
	if(l == 0) {
		Dmsg('请选择分类', f);
		return false;
	}
	f = 'title';
	l = $(f).value.length;
	if(l < 2) {
		Dmsg('请输入网站名称', f);
		return false;
	}
	f = 'linkurl';
	l = $(f).value.length;
	if(l < 12) {
		Dmsg('请输入网站地址', f);
		return false;
	}
}
</script>
<script type="text/javascript">Menuon(0);</script>
</body>
</html>