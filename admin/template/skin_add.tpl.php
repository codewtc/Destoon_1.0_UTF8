<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form method="post" action="?file=<?php echo $file;?>&action=<?php echo $action;?>">
<div class="tt">风格添加</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td width="80">&nbsp;风格目录</td>
<td><?php echo $skin_path;?></td>
</tr>
<tr>
<td>&nbsp;文件名</td>
<td><input type="text" size="20" name="fileid" value=""/>.css 不支持中文</td>
</tr>
<tr>
<td colspan="2">
<textarea name="content" style="width:98%;height:300px;font-family:Fixedsys,verdana;overflow:visible;"></textarea>
</td>
</tr>
<tr>
<td colspan="2"><input type="checkbox" name="nowrite" value="1" checked/> 如果风格已经存在,请不要覆盖&nbsp;&nbsp;<input type="submit" name="submit" value=" 保 存 " class="btn"/>&nbsp;&nbsp;<input type="button" value=" 返 回 " class="btn" onclick="history.back(-1);"/></td>
</tr>
</table>
</form>
<br/>
<script type="text/javascript">Menuon(0);</script>
</body>
</html>