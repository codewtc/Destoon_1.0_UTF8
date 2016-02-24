<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form method="post" action="?file=<?php echo $file;?>&moduleid=<?php echo $moduleid;?>&action=<?php echo $action;?>" id="dform" onsubmit="return check();">
<div class="tt">添加<?php echo $MOD['name'];?></div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">所属栏目 <span class="f_red">*</span></td>
<td><?php echo category_select('post[catid]', '选择栏目', $catid, $moduleid, 'id="catid" onchange="cat(this.value);"');?>&nbsp;&nbsp;<input type="checkbox" name="post[islink]" value="1" id="islink" onclick="_islink();"/> 外部链接 <span id="dcatid" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><?php echo $MOD['name'];?>标题 <span class="f_red">*</span></td>
<td><input name="post[title]" type="text" id="title" size="60" /> <?php echo level_select('post[level]', '级别');?> <?php echo dstyle('post[style]');?> <br/><span id="dtitle" class="f_red"></span></td>
</tr>
<tr style="display:none;" id="link">
<td class="tl">链接地址 <span class="f_red">*</span></td>
<td><input name="post[linkurl]" type="text" id="linkurl" size="40" /> <span id="dlinkurl" class="f_red"></span></td>
</tr>
<tbody id="basic">
<tr>
<td class="tl">
<?php echo $MOD['name'];?>内容 <span class="f_red">*</span><br/><br/>
<span onclick="pagebreak();" class="jt">[插入分页符]</span>
</td>
<td><textarea name="post[content]" id="content" class="dsn"></textarea>
<?php echo deditor($moduleid, 'content', 'Default', '95%', 350);?>
<br/> <span id="dcontent" class="f_red"></span>
</td>
</tr>
<tr>
<td class="tl" height="30">内容选项</td>
<td><input type="checkbox" name="post[save_remotepic]" value="1"<?php if($MOD['save_remotepic']) echo 'checked';?>/>下载远程图片
<input type="checkbox" name="post[clear_link]" value="1"<?php if($MOD['clear_link']) echo 'checked';?>/>清除链接
<input type="checkbox" name="post[get_introduce]" value="1"<?php if($MOD['get_introduce']) echo 'checked';?>/>截取内容 <input name="post[introduce_length]" type="text" size="2" value="<?php echo $MOD['introduce_length']?>"/> 字符至<?php echo $MOD['name'];?>简介
</td>
</tr>
</tbody>
<tr>
<td class="tl"><?php echo $MOD['name'];?>简介</td>
<td><textarea name="post[introduce]" style="width:90%;height:30px;"></textarea></td>
</tr>
<tr>
<td class="tl" height="30"><?php echo $MOD['name'];?>作者</td>
<td><input type="text" size="10" name="post[author]"/>&nbsp;&nbsp; <?php echo $MOD['name'];?>来源 <input type="text" size="12" name="post[copyfrom]"/>&nbsp;&nbsp; 来源链接 <input type="text" size="25" name="post[fromurl]"/></td>
</tr>
<tr>
<td class="tl">标题图片</td>
<td><input name="post[thumb]" type="text" size="60" id="thumb"/>&nbsp;&nbsp;<span onclick="Dthumb(<?php echo $moduleid;?>,<?php echo $MOD['thumb_width'];?>,<?php echo $MOD['thumb_height'];?>, $('thumb').value);" class="jt">[上传]</span>&nbsp;&nbsp;<span onclick="_preview($('thumb').value);" class="jt">[预览]</span>&nbsp;&nbsp;<span onclick="$('thumb').value='';" class="jt">[删除]</span></td>
</tr>
<tr>
<td class="tl">关键词(Tag)</td>
<td><input name="post[tag]" type="text" size="60" /><?php tips('多个关键词请用空格隔开');?></td>
</tr>
<tr>
<td class="tl"><?php echo $MOD['name'];?>状态</td>
<td>
<input type="radio" name="post[status]" value="3" checked/> 通过
<input type="radio" name="post[status]" value="2" /> 待审
</td>
</tr>
<tr title="请保持时间格式">
<td class="tl">添加时间</td>
<td><input type="text" size="22" name="post[addtime]" value="<?php echo $addtime;?>"/></td>
</tr>
<tr>
<td class="tl">内容模板</td>
<td><?php echo tpl_select('show', $module, 'post[template]', '默认模板', '', 'id="template"');?></td>
</tr>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
<?php load('clear.js'); ?>
<script type="text/javascript">
function pagebreak() {
	var oEditor = FCKeditorAPI.GetInstance('content');
	if(oEditor.EditMode == FCK_EDITMODE_WYSIWYG) {
		oEditor.InsertHtml('[pagebreak]');
	} else {
		alert('请切换到设计模式');
	}
}
function cat(catid) {
	if(catid) {
		var templates = new Array();
		<?php foreach($CATEGORY as $k=>$v) { ?>
		templates[<?php echo $k;?>] = '<?php echo $v['show_template'];?>';
		<?php } ?>
		select_op('template', templates[catid]);
	}
}
<?php if($catid) echo 'cat('.$catid.');' ?>

function check() {
	var l;
	var f;
	f = 'catid';
	if($(f).value == 0) {
		Dmsg('请选择所属栏目', f, 1);
		return false;
	}
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