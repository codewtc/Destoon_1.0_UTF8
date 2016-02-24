<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form method="post" action="?file=<?php echo $file;?>&moduleid=<?php echo $moduleid;?>&action=<?php echo $action;?>" id="dform" onsubmit="return check();">
<div class="tt">添加<?php echo $MOD['name'];?></div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">会员名 <span class="f_red">*</span></td>
<td><input name="post[username]" type="text"  size="20" value="<?php echo $_username;?>"/></td>
</tr>
<tr>
<td class="tl"><?php echo $MOD['name'];?>图片</td>
<td>
	<input type="hidden" name="post[thumb]" id="thumb"/>
	<input type="hidden" name="post[thumb1]" id="thumb1"/>
	<input type="hidden" name="post[thumb2]" id="thumb2"/>
	<table width="360">
	<tr align="center" height="120" class="c_p">
	<td width="120"><img src="<?php echo SKIN_PATH;?>image/waitpic.gif" id="showthumb" title="预览图片" alt="" onclick="_preview($('showthumb').src, 1);"/></td>
	<td width="120"><img src="<?php echo SKIN_PATH;?>image/waitpic.gif" id="showthumb1" title="预览图片" alt="" onclick="_preview($('showthumb1').src, 1);"/></td>
	<td width="120"><img src="<?php echo SKIN_PATH;?>image/waitpic.gif" id="showthumb2" title="预览图片" alt="" onclick="_preview($('showthumb2').src, 1);"/></td>
	</tr>
	<tr align="center" height="25">
	<td><span onclick="Dalbum('',<?php echo $moduleid;?>,<?php echo $MOD['thumb_width'];?>,<?php echo $MOD['thumb_height'];?>, $('thumb').value, true);" class="jt">[上传]</span>&nbsp;<span onclick="delAlbum('', 'wait');" class="jt">[删除]</span></td>
	<td><span onclick="Dalbum(1,<?php echo $moduleid;?>,<?php echo $MOD['thumb_width'];?>,<?php echo $MOD['thumb_height'];?>, $('thumb1').value, true);" class="jt">[上传]</span>&nbsp;<span onclick="delAlbum(1, 'wait');" class="jt">[删除]</span></td>
	<td><span onclick="Dalbum(2,<?php echo $moduleid;?>,<?php echo $MOD['thumb_width'];?>,<?php echo $MOD['thumb_height'];?>, $('thumb2').value, true);" class="jt">[上传]</span>&nbsp;<span onclick="delAlbum(2, 'wait');" class="jt">[删除]</span></td>
	</tr>
	</table>
</td>
</tr>
<tr>
<td class="tl">产品关键字 <span class="f_red">*</span></td>
<td><input name="post[tag]" id="tag" type="text" size="30"/> <span id="dtag" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">信息标题 <span class="f_red">*</span></td>
<td><input name="post[title]" type="text" id="title" size="50" /> <?php echo level_select('post[level]', '级别');?> <?php echo dstyle('post[style]');?> <br/><span id="dtitle" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">所属行业 <span class="f_red">*</span></td>
<td><?php echo ajax_category_select('post[catid]', '', $catid, 1, 'size="2" style="height:120px;width:180px;"');?> <br/><span id="dcatid" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">详细说明 <span class="f_red">*</span></td>
<td><textarea name="post[content]" id="content" class="dsn"></textarea>
<?php echo deditor($moduleid, 'content', 'Default', '95%', 350);?><br/>
<span id="dcontent" class="f_red"></span>
</td>
</tr>
<tr>
<td class="tl"><?php echo $MOD['name'];?>型号</td>
<td><input name="post[model]" type="text" size="30"/></td>
</tr>
<tr>
<td class="tl"><?php echo $MOD['name'];?>规格</td>
<td><input name="post[standard]" type="text" size="30"/></td>
</tr>
<tr>
<td class="tl"><?php echo $MOD['name'];?>品牌</td>
<td><input name="post[brand]" type="text" size="30"/></td>
</tr>
<tr>
<td class="tl">交易条件</td>
<td>
	<table width="100%">
	<tr>
	<td width="70">计量单位</td>
	<td><input name="post[unit]" type="text" size="10" onblur="if(this.value){$('u1').innerHTML=$('u2').innerHTML=$('u3').innerHTML=this.value;}"/></td>
	</tr>
	<tr>
	<td><?php echo $MOD['name'];?>单价</td>
	<td><input name="post[price]" type="text"  size="10"/> 元/<span id="u1">单位</span></td>
	</tr>
	<tr>
	<td>最小起订量</td>
	<td><input name="post[minamount]" type="text"  size="10"/> <span id="u2">单位</span></td>
	</tr>
	<tr>
	<td>供货总量</td>
	<td><input name="post[amount]" type="text"  size="10"/> <span id="u3">单位</span></td>
	</tr>
	<tr>
	<td>发货期限</td>
	<td>自买家付款之日起 <input name="post[days]" type="text"  size="2"/> 天内发货</td>
	</tr>
	</table>
</td>
</tr>
<tr>
<td class="tl">信息状态</td>
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
<td><?php echo tpl_select('show', $module, 'post[template]', '默认模板');?></td>
</tr>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
<?php load('clear.js'); ?>
<script type="text/javascript">
function check() {
	var l;
	var f;
	f = 'tag';
	l = $(f).value.length;
	if(l < 2) {
		Dmsg('产品关键字最少2字，当前已输入'+l+'字', f);
		return false;
	}
	f = 'title';
	l = $(f).value.length;
	if(l < 2) {
		Dmsg('标题最少2字，当前已输入'+l+'字', f);
		return false;
	}
	f = 'catid';
	if($(f).value == 0) {
		Dmsg('请选择所属行业', f, 1);
		return false;
	}
	f = 'content';
	l = FCKLen();
	if(l < 5) {
		Dmsg('详细说明最少5字，当前已输入'+l+'字', f);
		return false;
	}
	return true;
}
</script>
<script type="text/javascript">Menuon(0);</script>
</body>
</html>