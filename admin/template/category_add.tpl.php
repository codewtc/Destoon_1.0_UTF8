<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form method="post" action="?file=<?php echo $file;?>&mid=<?php echo $mid;?>&action=<?php echo $action;?>" onsubmit="return check();">
<div class="tt">栏目添加</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">上级栏目 <span class="f_red">*</span></td>
<td><?php echo category_select('category[parentid]', '一级栏目', $parentid, $mid);?></td>
</tr>
<tr>
<td class="tl">栏目名称 <span class="f_red">*</span></td>
<td><input name="category[catname]" type="text" id="catname" size="20" onblur="get_letter(this.value);"/> <?php echo dstyle('category[style]');?> <span id="dcatname" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">栏目目录[英文名] <span class="f_red">*</span></td>
<td><input name="category[catdir]" type="text" id="catdir" size="20" /> <input type="button" class="btn" value="目录检测" onclick="ckDir();"><?php tips('限英文、数字、中划线、下划线，该栏目相关的html文件将保存在此目录');?> <span id="dcatdir" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">字母索引</td>
<td><input name="category[letter]" type="text" id="letter" size="2" /><?php tips('填写栏目名称后系统会自动获取 如果没有获取成功请填写<br/>例如 栏目名称为 嘉客 则填写 j');?></td>
</tr>
<?php if($mid > 1) { ?>
<tr>
<td class="tl">栏目模板</td>
<td><?php echo tpl_select('list', $MODULE[$mid]['module'], 'category[template]', '默认模板');?></td>
</tr>
<tr>
<td class="tl">内容模板</td>
<td><?php echo tpl_select('show', $MODULE[$mid]['module'], 'category[show_template]', '默认模板');?></td>
</tr>
<?php } ?>
<tr>
<td class="tl">Title(SEO标题)</td>
<td><input name="category[seo_title]" type="text" size="61"></td>
</tr>
<tr>
<td class="tl">Meta Keywords<br/>(网页关键词)</td>
<td><textarea name="category[seo_keywords]" cols="60" rows="3" id="seo_keywords"></textarea></td>
</tr>
<tr>
<td class="tl">Meta Description<br/>(网页描述)</td>
<td><textarea name="category[seo_description]" cols="60" rows="3" id="seo_description"></textarea></td>
</tr>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
<script type="text/javascript">
function ckDir() {
	if($('catdir').value == '') {
		Dtip('请填写栏目目录[英文名]');
		$('catdir').focus();
		return false;
	}
	var url = '?file=category&action=ckdir&moduleid=<?php echo $moduleid;?>&catdir='+$('catdir').value;
	Diframe(url, 0, 0, 1);
}
function check() {
	if($('catname').value == '') {
		Dmsg('请填写栏目名称', 'catname');
		return false;
	}
	if($('catdir').value == '') {
		Dmsg('请填写栏目目录', 'catdir');
		return false;
	}
	return true;
}
function get_letter(catname) {
	makeRequest('file=<?php echo $file;?>&mid=<?php echo $mid;?>&action=letter&catname='+catname, '?', '_get_letter');
}
function _get_letter() {    
	if(xmlHttp.readyState==4 && xmlHttp.status==200) {
		if(xmlHttp.responseText) $('letter').value = xmlHttp.responseText;
	}
}
</script>
<script type="text/javascript">Menuon(0);</script>
</body>
</html>