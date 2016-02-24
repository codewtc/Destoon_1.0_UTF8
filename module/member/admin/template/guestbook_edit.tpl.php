<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form method="post" action="?file=<?php echo $file;?>&moduleid=<?php echo $moduleid;?>&action=<?php echo $action;?>&itemid=<?php echo $itemid;?>" id="dform">
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<div class="tt">修改留言 </div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">留言人</td>
<td><a href="<?php echo $MODULE[3]['linkurl'];?>redirect.php?username=<?php echo $poster;?>" target="_blank" class="t"><?php echo $poster ? $poster : 'Guest';?></a> IP - <?php echo $ip;?></td>
</tr>
<tr>
<td class="tl">留言标题 <span class="f_red">*</span></td>
<td><input name="post[title]" type="text" id="title" size="50" value="<?php echo $title;?>"/> <input type="checkbox" name="post[hidden]" value="1" <?php if($hidden) echo 'checked';?>/> 隐藏留言</td>
</tr>

<tr>
<td class="tl">留言内容 <span class="f_red">*</span></td>
<td><textarea name="post[content]" id="content"  rows="8" cols="70"><?php echo $content;?></textarea></td>
</tr>

<tr>
<td class="tl">回复留言</td>
<td><textarea name="post[reply]" id="reply" rows="8" cols="70"><?php echo $reply;?></textarea></td>
</tr>

<tr>
<td class="tl">留言状态</td>
<td>
<input type="radio" name="post[status]" value="3" <?php if($status == 3) echo 'checked';?>/> 通过
<input type="radio" name="post[status]" value="2" <?php if($status == 2) echo 'checked';?>/> 待审
</td>
</tr>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
<script type="text/javascript">Menuon(<?php echo $menuon[$status];?>);</script>
</body>
</html>