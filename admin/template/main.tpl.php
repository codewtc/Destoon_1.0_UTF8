<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<?php if($mysql_tip) { ?>
<div class="tt">数据库备份提示</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td height="30">&nbsp;<img src="<?php echo IMG_PATH;?>info.png" width="16" height="16" align="absmiddle"/>&nbsp; <a href="?file=database"><?php echo $mysql_tip;?></a></td>
</tr>
</table>
<?php } ?>
<div class="tt"><span class="f_r px11">IP:<?php echo $user['loginip']; ?>&nbsp;&nbsp;</span>欢迎管理员，<?php echo $_username;?></div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">管理级别</td>
<td width="30%">&nbsp;<?php echo $_level == 1 ? '超级管理员' : '普通管理员'; ?></td>
<td class="tl">登录次数</td>
<td width="30%">&nbsp;<?php echo $user['logintimes']; ?> 次</td>
</tr>
<tr>
<td class="tl">站内信件</td>
<td>&nbsp;<a href="<?php echo $MODULE[2]['linkurl'].'message.php';?>" target="_blank">收件箱[<?php echo $_message ? '<strong class="f_red">'.$_message.'</strong>' : $_message;?>]</a></td>
<td class="tl">登录时间</td>
<td>&nbsp;<?php echo timetodate($user['logintime'], 5); ?> </td>
</tr>
<form method="post" action="?action=<?php echo $action;?>">
<tr>
<td class="tl">工作便笺</td>
<td colspan="2"><input type="text" name="note" style="width:96%;" value="<?php echo $note;?>"/></td>
<td><input type="submit" name="submit" value=" 保 存 " class="btn"/></td>
</tr>
</form>
</table>
<div id="destoon"></div>
<div class="tt">统计信息</div>
<table cellpadding="2" cellspacing="1" class="tb">

<tr>
<td class="tl"><a href="?moduleid=2&file=ask" class="t">待受理客服中心</a></td>
<td>&nbsp;<a href="?moduleid=2&file=ask&status=0"><span id="ask"><img src="<?php echo IMG_PATH;?>count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=2&file=charge" class="t">待受理在线充值</a></td>
<td>&nbsp;<a href="?moduleid=2&file=charge&status=0"><span id="charge"><img src="<?php echo IMG_PATH;?>count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=2&file=cash" class="t">待受理资金提现</a></td>
<td>&nbsp;<a href="?moduleid=2&file=cash&status=0"><span id="cash"><img src="<?php echo IMG_PATH;?>count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=2&file=trade&status=5" class="t">待受理会员交易</a></td>
<td>&nbsp;<a href="?moduleid=2&file=trade"><span id="trade"><img src="<?php echo IMG_PATH;?>count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
</tr>


<tr>
<td class="tl"><a href="?moduleid=2&file=news&action=check" class="t">待审核公司新闻</a></td>
<td>&nbsp;<a href="?moduleid=2&file=news&action=check"><span id="news"><img src="<?php echo IMG_PATH;?>count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=2&file=credit&action=check" class="t">待审核荣誉资质</a></td>
<td>&nbsp;<a href="?moduleid=2&file=credit&action=check"><span id="credit"><img src="<?php echo IMG_PATH;?>count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=2&file=guestbook&action=check" class="t">待审核公司留言</a></td>
<td>&nbsp;<a href="?moduleid=2&file=guestbook&action=check"><span id="guestbook"><img src="<?php echo IMG_PATH;?>count.gif" width="10" height="10" alt="正在统计"/></span></a></td>

<td class="tl"><a href="?moduleid=3&file=link&action=check" class="t">待审核友情链接</a></td>
<td>&nbsp;<a href="?moduleid=3&file=link&action=check"><span id="link"><img src="<?php echo IMG_PATH;?>count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
</tr>


<tr>
<td class="tl"><a href="?moduleid=2" class="t">会员</a></td>

<td width="10%">&nbsp;<a href="?moduleid=2"><span id="member"><img src="<?php echo IMG_PATH;?>count.gif" width="10" height="10" alt="正在统计"/></span></a></td>

<td class="tl"><a href="?moduleid=4&file=vip&action=check" class="t"><?php echo VIP;?>申请</a></td>

<td width="10%">&nbsp;<a href="?moduleid=4&file=vip&action=check"><span id="member_vip"><img src="<?php echo IMG_PATH;?>count.gif" width="10" height="10" alt="正在统计"/></span></a></td>

<td class="tl"><a href="?moduleid=2&action=check" class="t">待审核</a></td>

<td width="10%">&nbsp;<a href="?moduleid=2&action=check"><span id="member_check"><img src="<?php echo IMG_PATH;?>count.gif" width="10" height="10" alt="正在统计"/></span></a></td>


<td class="tl"><a href="?moduleid=2&action=add" class="t">今日新增</a></td>

<td width="10%">&nbsp;<a href="?moduleid=2"><span id="member_new"><img src="<?php echo IMG_PATH;?>count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
</tr>


<?php
foreach ($MODULE as $m) {
	if($m['moduleid'] < 5 || $m['islink']) continue;
?>
<tr>
<td class="tl"><a href="<?php echo $m['linkurl'];?>" class="t" target="_blank"><?php echo $m['name'];?></a></td>

<td>&nbsp;<a href="?moduleid=<?php echo $m['moduleid'];?>"><span id="m_<?php echo $m['moduleid'];?>"><img src="<?php echo IMG_PATH;?>count.gif" width="10" height="10" alt="正在统计"/></span></a></td>

<td class="tl"><a href="?moduleid=<?php echo $m['moduleid'];?>" class="t">已发布</a></td>

<td>&nbsp;<a href="?moduleid=<?php echo $m['moduleid'];?>"><span id="m_<?php echo $m['moduleid'];?>_1"><img src="<?php echo IMG_PATH;?>count.gif" width="10" height="10" alt="正在统计"/></span></a></td>

<td class="tl"><a href="?moduleid=<?php echo $m['moduleid'];?>&action=check" class="t">待审核</a></td>

<td>&nbsp;<a href="?moduleid=<?php echo $m['moduleid'];?>&action=check"><span id="m_<?php echo $m['moduleid'];?>_2"><img src="<?php echo IMG_PATH;?>count.gif" width="10" height="10" alt="正在统计"/></span></a></td>

<td class="tl"><a href="?moduleid=<?php echo $m['moduleid'];?>&action=add" class="t">今日新增</a></td>

<td>&nbsp;<a href="?moduleid=<?php echo $m['moduleid'];?>"><span id="m_<?php echo $m['moduleid'];?>_3"><img src="<?php echo IMG_PATH;?>count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
</tr>
<?php
}
?>
</table>
<div class="tt">系统信息</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">程序信息</td>
<td>&nbsp;<a href="?file=destoon&action=update" class="t">Destoon B2B Version <?php echo DT_VERSION;?> Release <?php echo DT_RELEASE;?> [检查更新]</a></td>
</tr>
<tr>
<td class="tl">安装时间</td>
<td>&nbsp;<?php echo $install;?></td>
</tr>
<tr>
<td class="tl">授权查询</td>
<td>&nbsp;<a href="?file=destoon&action=authorization" target="_blank" title="域名授权查询">点击查询</a></td>
</tr>
<tr>
<td class="tl">官方网站</td>
<td>&nbsp;<a href="http://www.destoon.com" target="_blank">http://www.destoon.com</a></td>
</tr>
<tr>
<td class="tl">支持论坛</td>
<td>&nbsp;<a href="http://bbs.destoon.com" target="_blank">http://bbs.destoon.com</a></td>
</tr>
<tr>
<td class="tl">使用帮助</td>
<td>&nbsp;<a href="http://help.destoon.com" target="_blank">http://help.destoon.com</a></td>
</tr>
<tr>
<td class="tl">服务器时间</td>
<td>&nbsp;<?php echo timetodate($DT_TIME, 'Y-m-d H:i:s l');?></td>
</tr>
<?php if($_level == 1) {?>
<tr>
<td class="tl">服务器信息</td>
<td>&nbsp;<?php echo PHP_OS.'&nbsp;'.$_SERVER["SERVER_SOFTWARE"];?> [<?php echo gethostbyname($_SERVER['SERVER_NAME']);?>:<?php echo $_SERVER["SERVER_PORT"];?>] <a href="?action=phpinfo" target="_blank">[详细信息]</a></td>
</tr>
<tr>
<td class="tl">数据库版本</td>
<td>&nbsp;MySQL <?php echo $db->version();?></td>
</tr>
<?php } ?>
</table>
<script type="text/javascript">Menuon(0);</script>
<script type="text/javascript" src="<?php echo $notice_url;?>"></script>
<script type="text/javascript" src="?action=count"></script>
</body>
</html>