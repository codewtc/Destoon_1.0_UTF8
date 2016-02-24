<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
$menus = array (
    array('基本设置'),
    array('SEO设置'),
);
show_menu($menus);
?>
<form method="post" action="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>">
<div id="Tabs0" style="display:">
<div class="tt">基本设置</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">模块首页模板</td>
<td><?php echo tpl_select('index', $module, 'setting[template]', '默认模板', $template);?></td>
</tr>
<tr>
<td class="tl">默认缩略图[宽X高]</td>
<td>
<input type="text" size="3" name="setting[thumb_width]" value="<?php echo $thumb_width;?>"/>
X
<input type="text" size="3" name="setting[thumb_height]" value="<?php echo $thumb_height;?>"/> px
</td>
</tr>
<tr>
<td class="tl">内容页图片最大宽度</td>
<td><input type="text" size="3" name="setting[max_width]" value="<?php echo $max_width;?>"/> px</td>
</tr>
<tr>
<td class="tl">列表每页默认信息条数</td>
<td><input type="text" size="3" name="setting[pagesize]" value="<?php echo $pagesize;?>"/> 条</td>
</tr>
<tr>
<td class="tl">信息排序方式</td>
<td>
<select name="setting[order]">
<option value="addtime desc"<?php if($order == 'addtime desc') echo ' selected';?>>添加时间</option>
<option value="edittime desc"<?php if($order == 'edittime desc') echo ' selected';?>>更新时间</option>
<option value="itemid desc"<?php if($order == 'itemid desc') echo ' selected';?>>信息ID</option>
</select>
</td>
</tr>
<tr>
<td class="tl">下载内容远程图片</td>
<td>
<input type="radio" name="setting[save_remotepic]" value="1"  <?php if($save_remotepic) echo 'checked';?>> 开启&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="setting[save_remotepic]" value="0"  <?php if(!$save_remotepic) echo 'checked';?>> 关闭
</td>
</tr>
<tr>
<td class="tl">截取内容至<?php echo $MOD['name'];?>简介</td>
<td>
<input type="radio" name="setting[get_introduce]" value="1"  <?php if($get_introduce) echo 'checked';?>> 开启&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="setting[get_introduce]" value="0"  <?php if(!$get_introduce) echo 'checked';?>> 关闭
&nbsp;&nbsp;&nbsp;&nbsp;默认截取 <input type="text" size="3" name="setting[introduce_length]" value="<?php echo $introduce_length;?>"/> 字符
</td>
</tr>
<tr>
<td class="tl">清除内容链接</td>
<td>
<input type="radio" name="setting[clear_link]" value="1"  <?php if($clear_link) echo 'checked';?>> 开启&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="setting[clear_link]" value="0"  <?php if(!$clear_link) echo 'checked';?>> 关闭
</td>
</tr>
<tr>
<td class="tl">内容关联链接</td>
<td>
<input type="radio" name="setting[keylink]" value="1"  <?php if($keylink) echo 'checked';?>> 开启&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="setting[keylink]" value="0"  <?php if(!$keylink) echo 'checked';?>> 关闭
</td>
</tr>
<tr>
<td class="tl">内容文本存储</td>
<td>
<input type="radio" name="setting[text_data]" value="1"  <?php if($text_data) echo 'checked';?>> 开启&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="setting[text_data]" value="0"  <?php if(!$text_data) echo 'checked';?>> 关闭
</td>
</tr>
<tr>
<td class="tl">允许会员发布<?php echo $MOD['name'];?></td>
<td>
 <input type="radio" name="setting[member_add]" value="1"  <?php if($member_add) echo 'checked';?>> 是&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="setting[member_add]" value="0"  <?php if(!$member_add) echo 'checked';?>> 否
</td>
</tr>
<tr>
<td class="tl">会员发布<?php echo $MOD['name'];?>需审核</td>
<td>
<input type="radio" name="setting[member_check]" value="1"  <?php if($member_check) echo 'checked';?>> 是&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="setting[member_check]" value="0"  <?php if(!$member_check) echo 'checked';?>> 否
</td>
</tr>
<tr>
<td class="tl">会员发布<?php echo $MOD['name'];?>启用验证码</td>
<td>
<input type="radio" name="setting[captcha_add]" value="1"  <?php if($captcha_add) echo 'checked';?>> 是&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="setting[captcha_add]" value="0"  <?php if(!$captcha_add) echo 'checked';?>> 否
</td>
</tr>
<tr>
<td class="tl">RSS输出模式</td>
<td>
<input type="radio" name="setting[rss_mode]" value="0"  <?php if(!$rss_mode) echo 'checked';?>> 全文&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="setting[rss_mode]" value="1"  <?php if($rss_mode) echo 'checked';?>> 摘要
&nbsp;&nbsp;&nbsp;&nbsp;默认截取 <input type="text" size="3" name="setting[rss_length]" value="<?php echo $rss_length;?>"/> 字符
</td>
</tr>
<tr>
<td class="tl">RSS输出数量</td>
<td><input type="text" size="3" name="setting[rss_num]" value="<?php echo $rss_num;?>"/> 条</td>
</tr>
<tr>
<td class="tl">RSS更新频率</td>
<td><input type="text" size="3" name="setting[rss_time]" value="<?php echo $rss_time;?>"/> 秒</td>
</tr>
</table>
</div>

<div id="Tabs1" style="display:none">
<div class="tt">SEO优化</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">Title(网页标题)</td>
<td><input name="setting[seo_title]" type="text" id="seo_title" value="<?php echo $seo_title;?>" size="61"></td>
</tr>
<tr>
<td class="tl">Meta Keywords<br/>(网页关键词)</td>
<td><textarea name="setting[seo_keywords]" cols="60" rows="3" id="seo_keywords"><?php echo $seo_keywords;?></textarea></td>
</tr>
<tr>
<td class="tl">Meta Description<br/>(网页描述)</td>
<td><textarea name="setting[seo_description]" cols="60" rows="3" id="seo_description"><?php echo $seo_description;?></textarea></td>
</tr>
<tr>
<td class="tl">首页是否生成html</td>
<td>
<input type="radio" name="setting[index_html]" value="1"  <?php if($index_html){ ?>checked <?php } ?>/> 是&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="setting[index_html]" value="0"  <?php if(!$index_html){ ?>checked <?php } ?>/> 否
</td>
</tr>
<tr>
<td class="tl">列表页是否生成html</td>
<td>
<input type="radio" name="setting[list_html]" value="1"  <?php if($list_html){ ?>checked <?php } ?> onclick="$('list_html').style.display='';$('list_php').style.display='none';"/> 是&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="setting[list_html]" value="0"  <?php if(!$list_html){ ?>checked <?php } ?> onclick="$('list_html').style.display='none';$('list_php').style.display='';"/> 否
</td>
</tr>
<tbody id="list_html" style="display:<?php echo $list_html ? '' : 'none'; ?>">
<tr>
<td class="tl">HTML列表页文件名前缀</td>
<td><input name="setting[htm_list_prefix]" type="text" id="htm_list_prefix" value="<?php echo $htm_list_prefix;?>" size="10"></td>
</tr>
<tr>
<td class="tl">HTML列表页地址规则</td>
<td><?php echo url_select('setting[htm_list_urlid]', 'htm', 'list', $htm_list_urlid);?><?php tips('提示:规则列表可在./include/url.inc.php文件里自定义');?></td>
</tr>
</tbody>
<tr id="list_php" style="display:<?php echo $list_html ? 'none' : ''; ?>">
<td class="tl">PHP列表页地址规则</td>
<td><?php echo url_select('setting[php_list_urlid]', 'php', 'list', $php_list_urlid);?></td>
</tr>
<tr>
<td class="tl">内容页是否生成html</td>
<td>
<input type="radio" name="setting[show_html]" value="1"  <?php if($show_html){ ?>checked <?php } ?> onclick="$('show_html').style.display='';$('show_php').style.display='none';"/> 是&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="setting[show_html]" value="0"  <?php if(!$show_html){ ?>checked <?php } ?> onclick="$('show_html').style.display='none';$('show_php').style.display='';"/> 否
</td>
</tr>
<tbody id="show_html" style="display:<?php echo $show_html ? '' : 'none'; ?>">
<tr>
<td class="tl">HTML内容页文件名前缀</td>
<td><input name="setting[htm_item_prefix]" type="text" id="htm_item_prefix" value="<?php echo $htm_item_prefix;?>" size="10"></td>
</tr>
<tr>
<td class="tl">HTML内容页地址规则</td>
<td><?php echo url_select('setting[htm_item_urlid]', 'htm', 'item', $htm_item_urlid);?></td>
</tr>
</tbody>
<tr id="show_php" style="display:<?php echo $show_html ? 'none' : ''; ?>">
<td class="tl">PHP内容页地址规则</td>
<td><?php echo url_select('setting[php_item_urlid]', 'php', 'item', $php_item_urlid);?></td>
</tr>
<tr>
<td class="tl">系统提示</td>
<td>如果更改了地址规则或生成方式，则可能需要重新更新内容页地址和重新生成模块相关网页</td>
</tr>
</table>
</div>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
</body>
</html>