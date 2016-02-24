<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<div class="tt"><?php if($parentid) echo $CATEGORY[$parentid]['catname'];?>栏目管理</div>
<form method="post" action="?file=<?php echo $file;?>&action=update&mid=<?php echo $mid;?>&parentid=<?php echo $parentid;?>">
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="80">排序</th>
<th width="80">ID</th>
<th>栏目名</th>
<th width="80">子栏目</th>
<th width="120">操作</th>
</tr>
<?php foreach($DCAT as $k=>$v) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><input name="category[<?php echo $v['catid'];?>][listorder]" type="text" size="3" value="<?php echo $v['listorder'];?>"/></td>
<td>&nbsp;<?php echo $v['catid'];?></td>
<td>
<input name="category[<?php echo $v['catid'];?>][catname]" type="text" value="<?php echo $v['catname'];?>" style="width:120px;color:<?php echo $v['style'];?>"/>
<?php echo dstyle('category['.$v['catid'].'][style]', $v['style']);?>
</td>
<td>&nbsp;<a href="?file=<?php echo $file;?>&mid=<?php echo $mid;?>&parentid=<?php echo $v['catid'];?>"><?php echo $v['childs'];?></a></td>
<td>
<a href="?file=<?php echo $file;?>&mid=<?php echo $mid;?>&parentid=<?php echo $v['catid'];?>"><img src="<?php echo IMG_PATH;?>child.png" width="16" height="16" title="管理子栏目，当前有<?php echo $v['childs'];?>个子栏目" alt=""/></a>&nbsp;
<a href="?file=<?php echo $file;?>&action=add&mid=<?php echo $mid;?>&parentid=<?php echo $v['catid'];?>"><img src="<?php echo IMG_PATH;?>new.png" width="16" height="16" title="添加子栏目" alt=""/></a>&nbsp;
<a href="?file=<?php echo $file;?>&action=edit&mid=<?php echo $mid;?>&catid=<?php echo $v['catid'];?>"><img src="<?php echo IMG_PATH;?>edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
<a href="?file=<?php echo $file;?>&action=delete&mid=<?php echo $mid;?>&catid=<?php echo $v['catid'];?>&parentid=<?php echo $parentid;?>" onclick="return _delete();"><img src="<?php echo IMG_PATH;?>delete.png" width="16" height="16" title="删除" alt=""/></a></td>
</tr>
<?php }?>
</table>
<div class="btns">
<input type="submit" name="submit" value=" 更新栏目 " class="btn"/>
<?php if($parentid) {?>&nbsp;
<input type="button" value=" 上级栏目 " class="btn" onclick="window.location='?file=<?php echo $file;?>&mid=<?php echo $mid;?>&parentid=<?php echo $CATEGORY[$parentid]['parentid'];?>';"/>
<?php }?>
</div>
</form>
<form method="post" action="?">
<div class="tt">快捷操作</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td width="220" align="center">
<?php echo category_select('cid', '栏目结构', $parentid, $mid, 'size="2" style="width:200px;height:130px;" id="cid"');?>
</td>
<td valign="top">
	<table>
	<tr>
	<td><input type="submit" value=" 管理栏目 " class="btn" onclick="this.form.action='?mid=<?php echo $mid;?>&file=<?php echo $file;?>&parentid='+$('cid').value;"/></td>
	</tr>
	<tr>
	<td><input type="submit" value=" 添加栏目 " class="btn" onclick="this.form.action='?mid=<?php echo $mid;?>&file=<?php echo $file;?>&action=add&parentid='+$('cid').value;"/></td>
	</tr>
	<tr>
	<td><input type="submit" value=" 修改栏目 " class="btn" onclick="this.form.action='?mid=<?php echo $mid;?>&file=<?php echo $file;?>&action=edit&catid='+$('cid').value;"/></td>
	</tr>
	<tr>
	<td><input type="submit" value=" 删除栏目 " class="btn" onclick="if(confirm('确定要删除选中栏目吗？此操作将不可撤销')){this.form.action='?mid=<?php echo $mid;?>&file=<?php echo $file;?>&action=delete&catid='+$('cid').value;}else{return false;}"/></td>
	</tr>
	</table>
</td>
</tr>
</table>
</div>
</form>
<br/>
<br/>
<br/>
<script type="text/javascript">Menuon(1);</script>
</body>
</html>