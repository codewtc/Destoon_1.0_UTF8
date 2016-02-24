<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
$menus = array (
    array('基本设置'),
    array('SEO设置'),
);
show_menu($menus);
?>
<form method="post" action="?moduleid=<?php echo $moduleid;?>&file=setting">
<div id="Tabs0" style="display:">
<div class="tt">基本设置</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">模块首页模板</td>
<td><?php echo tpl_select('index', $module, 'setting[template]', '默认模板', $template);?></td>
</tr>
<tr>
<td class="tl">列表每页默认信息条数</td>
<td><input type="text" size="3" name="setting[pagesize]" value="<?php echo $pagesize;?>"/> 条</td>
</tr>
<tr>
<td class="tl">信息排序方式</td>
<td>
<select name="setting[order]">
<option value="vip desc"<?php if($order == 'vip desc') echo ' selected';?>><?php echo VIP;?>级别</option>
<option value="userid desc"<?php if($order == 'userid desc') echo ' selected';?>>会员ID</option>
</select>
</td>
</tr>
<tr>
<td class="tl"><?php echo VIP;?>指数计算规则</td>
<td>
	<table cellpadding="3" cellspacing="1" width="400" bgcolor="#E5E5E5" style="margin:5px;">
	<tr align="center">
	<td>项目</td>
	<td>值</td>
	<td>最大值</td>
	</tr>
	<tr align="center">
	<td>会员组<?php echo VIP;?>指数</td>
	<td>相等</td>
	<td><input type="text" size="2" name="setting[vip_maxgroupvip]" value="<?php echo $vip_maxgroupvip;?>"/></td>
	</tr>
	<tr align="center">
	<td>企业资料认证</td>
	<td><input type="text" size="2" name="setting[vip_cominfo]" value="<?php echo $vip_cominfo;?>"/></td>
	<td><?php echo $vip_cominfo;?></td>
	</tr>
	<tr align="center">
	<td>VIP年份（单位：值/年）</td>
	<td><input type="text" size="2" name="setting[vip_year]" value="<?php echo $vip_year;?>"/></td>
	<td><input type="text" size="2" name="setting[vip_maxyear]" value="<?php echo $vip_maxyear;?>"/></td>
	</tr>
	<tr align="center">
	<td>5张以上资质证书</td>
	<td><input type="text" size="2" name="setting[vip_credit]" value="<?php echo $vip_credit;?>"/></td>
	<td><?php echo $vip_credit;?></td>
	</tr>
	</table>
	<span class="f_gray">&nbsp;&nbsp;所有数值均为整数。<?php echo VIP;?>指数满分10分，故最大值之和应等于10</span>
</td>
</tr>
</table>
</div>

<div id="Tabs1" style="display:none">
<div class="tt">SEO优化</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">Title(网页标题)</td>
<td><input name="setting[seo_title]" type="text" id="seo_title" value="<?php echo $seo_title;?>" size="61"></td>
</tr>
<tr>
<td class="tl">Meta Keywords<br/>(网页关键词)</td>
<td><textarea name="setting[seo_keywords]" cols="60" rows="3" id="seo_keywords"><?php echo $seo_keywords;?></textarea></td>
</tr>
<tr>
<td class="tl">Meta Description<br/>(网页描述)</td>
<td><textarea name="setting[seo_description]" cols="60" rows="3" id="seo_description"><?php echo $seo_description;?></textarea></td>
</tr>
</table>
</div>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
</body>
</html>