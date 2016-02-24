<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form method="post" action="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete">
<div class="tt">DESTOON获取邮件列表</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th>文件</th>
<th>文件大小(Kb)</th>
<th>记录数</th>
<th width="150">获取时间</th>
<th width="50">操作</th>
</tr>
<?php foreach($mails as $k=>$v) {?>
<tr align="center">
<td align="left">&nbsp;&nbsp;<a href="<?php DT_PATH;?>file/email/<?php echo $v['filename'];?>" title="点鼠标右键另存为保存此文件" target="_blank"><?php echo $v['filename'];?></a></td>
<td><?php echo $v['filesize'];?></td>
<td><?php echo $v['count'];?></td>
<td><?php echo $v['mtime'];?></td>
<td>
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=download&filename=<?php echo $v['filename'];?>"><img src="<?php echo IMG_PATH;?>save.png" width="16" height="16" title="下载" alt=""/></a>&nbsp;&nbsp;<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&filenames=<?php echo $v['filename'];?>" onclick="return _delete();"><img src="<?php echo IMG_PATH;?>delete.png" width="16" height="16" title="删除" alt=""/></a></td>
</tr>
<?php }?>
</table>
<table cellpadding="2" cellspacing="1" width="100%" bgcolor="#F1F2F3">
<tr>
<td height="50">
<form method="post" action="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=upload" enctype="multipart/form-data">
<td title="上传成功后文件将自动在文件列表中显示">
<input name="uploadfile" type="file" size="25"/>
<input type="hidden" name="MAX_FILE_SIZE" value="4096000"/>
<input type="submit" name="submit" value=" 上 传 " class="btn"/>&nbsp;
</form>
</td>
</tr>
</table>
<br/>
<br/>
<script type="text/javascript">Menuon(1);</script>
</body>
</html>