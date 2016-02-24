<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form method="post" action="?file=<?php echo $file;?>&moduleid=<?php echo $moduleid;?>&action=<?php echo $action;?>">
<div class="tt">移动<?php echo $MOD['name'];?></div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr class="on">
<td>
<input type="radio" name="fromtype" value="catid" <?php echo $itemid ? '' : 'checked';?> onclick="$('fromcatid').style.display='';$('fromitemid').style.display='none';"/>从指定栏目ID&nbsp;&nbsp;
<input type="radio" name="fromtype" value="itemid" <?php echo $itemid ? 'checked' : '';?> onclick="$('fromcatid').style.display='none';$('fromitemid').style.display='';"/>从指定<?php echo $MOD['name'];?>ID
</td>
<td></td>
<td>&nbsp;目标栏目</td>
</tr>
<tr align="center">
<td width="45%">
<div id="fromcatid" style="display:<?php echo $itemid ? 'none' : '';?>;">
<?php echo category_select('fromcatid[]', '', 0, 1, 'size="2" multiple  style="height:300px;width:96%;"');?>
</div>
<div id="fromitemid" style="display:<?php echo $itemid ? '' : 'none';?>;">
<textarea style="height:300px;width:96%;" name="itemids"><?php echo $itemid;?></textarea>
</div>
</td>
<td width="10%"> <strong>&rarr;</strong> </td>
<td width="45%"><?php echo category_select('tocatid', '', 0, 1, 'size="2" style="height:300px;width:96%;"');?></td>
</tr>
<tr>
<td colspan="3" align="center"><input type="submit" name="submit" value=" 移 动 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></td>
</tr>
</table>
</div>
</form>
<script type="text/javascript">Menuon(6);</script>
</body>
</html>