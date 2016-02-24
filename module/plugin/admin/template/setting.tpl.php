<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
$menus = array (
    array('模块设置'),
);
show_menu($menus);
?>
<form method="post" action="?moduleid=<?php echo $moduleid;?>&file=setting">
<div id="Tabs0" style="display:">
<div class="tt">模块设置</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">广告位预览</td>
<td>
<input type="radio" name="setting[ad_view]" value="1"  <?php if($ad_view) echo 'checked';?>> 开启&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="setting[ad_view]" value="0"  <?php if(!$ad_view) echo 'checked';?>> 关闭
</td>
</tr>
<tr>
<td class="tl">友情链接在线申请</td>
<td>
<input type="radio" name="setting[link_reg]" value="1"  <?php if($link_reg) echo 'checked';?>> 开启&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="setting[link_reg]" value="0"  <?php if(!$link_reg) echo 'checked';?>> 关闭
</td>
</tr>
</table>
</div>

<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
</body>
</html>