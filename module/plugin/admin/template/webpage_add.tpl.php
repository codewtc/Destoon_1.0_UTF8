<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form method="post" action="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>&item=<?php echo $item;?>" id="dform" onsubmit="return check();">
<div class="tt">添加单页</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">单页标题 <span class="f_red">*</span></td>
<td><input name="post[title]" type="text" id="title" size="50"/> <?php echo dstyle('post[style]');?>&nbsp;&nbsp;<input type="checkbox" name="post[islink]" value="1" id="islink" onclick="_islink();"/> 外部链接 <br/><span id="dtitle" class="f_red"></span></td>
</tr>
<tr style="display:none;" id="link">
<td class="tl">链接地址 <span class="f_red">*</span></td>
<td><input name="post[linkurl]" type="text" id="linkurl" size="50" /> <span id="dlinkurl" class="f_red"></span></td>
</tr>
<tbody id="basic">
<tr>
<td class="tl">
单页内容 <span class="f_red">*</span>
</td>
<td><textarea name="post[content]" id="content" class="dsn"></textarea>
<?php echo deditor($moduleid, 'content', 'Default', '95%', 350);?>
<br/> <span id="dcontent" class="f_red"></span>
</td>
</tr>
<tr>
<td class="tl" height="30">内容选项</td>
<td><input type="checkbox" name="post[save_remotepic]" value="1"/> 下载内容远程图片
<input type="checkbox" name="post[clear_link]" value="1"/> 清除内容链接
</td>
</tr>
<tr>
<td class="tl">保存路径</td>
<td><input name="post[filepath]" type="text" size="20"/> <span class="f_gray">如不填写则生成在网站根目录，否则请以‘/’结尾，例如‘about/’</span></td>
</tr>
<tr>
<td class="tl">文件名称</td>
<td><input name="post[filename]" type="text" size="20"/> <span class="f_gray">如不填写则自动按ID生成文件名，例如‘page-1.html’</span></td>
</tr>
<tr>
<td class="tl">SEO标题</td>
<td><input name="post[seo_title]" type="text" size="60" /></td>
</tr>
<tr>
<td class="tl">SEO关键词</td>
<td><input name="post[seo_keywords]" type="text" size="60" /></td>
</tr>
<tr>
<td class="tl">SEO描述</td>
<td><input name="post[seo_description]" type="text" size="60" /></td>
</tr>
<tr>
<td class="tl">内容模板</td>
<td><?php echo tpl_select('webpage', $module, 'post[template]', '默认模板');?></td>
</tr>
</tbody>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
<?php load('clear.js'); ?>
<script type="text/javascript">
function check() {
	var l;
	var f;
	f = 'title';
	l = $(f).value.length;
	if(l < 2) {
		Dmsg('标题最少2字，当前已输入'+l+'字', f);
		return false;
	}
	if($('islink').checked) {
		f = 'linkurl';
		l = $(f).value.length;
		if(l < 12) {
			Dmsg('请输入正确的链接地址', f);
			return false;
		}
	} else {
		f = 'content';
		l = FCKLen();
		if(l < 5) {
			Dmsg('内容最少5字，当前已输入'+l+'字', f);
			return false;
		}
	}
	return true;
}
</script>
<script type="text/javascript">Menuon(0);</script>
</body>
</html>