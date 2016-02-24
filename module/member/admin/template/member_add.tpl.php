<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<div class="tt">会员添加</div>
<form method="post" action="?moduleid=<?php echo $moduleid;?>&action=<?php echo $action;?>" onsubmit="return Dcheck();">
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">会员组 <span class="f_red">*</span></td>
<td>
<?php echo group_select('member[groupid]', '会员组', 5, 'id="groupid"');?>&nbsp;<span id="dgroupid" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">会员登录名 <span class="f_red">*</span></td>
<td><input type="text" size="20" name="member[username]" id="username" onblur="validator('username');"/>&nbsp;<span id="dusername" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">登录密码 <span class="f_red">*</span></td>
<td><input type="password" size="20" name="member[password]" id="password" onblur="validator('password');"/>&nbsp;<span id="dpassword" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">重复输入密码 <span class="f_red">*</span></td>
<td><input type="password" size="20" name="member[cpassword]" id="cpassword"/>&nbsp;<span id="dcpassword" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">Email <span class="f_red">*</span></td>
<td><input type="text" size="20" name="member[email]" id="email" onblur="validator('email');"/>&nbsp;<span id="demail" class="f_red"></span> <span class="f_gray">[不公开]</span></td>
</tr>
<tr>
<td class="tl">真实姓名 <span class="f_red">*</span></td>
<td><input type="text" size="20" name="member[truename]" id="truename"/>&nbsp;<span id="dtruename" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">性别 <span class="f_red">*</span></td>
<td>
<input type="radio" name="member[gender]" value="1" checked="checked"/> 先生
<input type="radio" name="member[gender]" value="2"/> 女士
</td>
</tr>
<tr>
<td class="tl">部门</td>
<td><input type="text" size="20" name="member[department]" id="department"/></td>
</tr>
<tr>
<td class="tl">职位</td>
<td><input type="text" size="20" name="member[career]" id="career"/></td>
</tr><tr>
<td class="tl">手机号码</td>
<td><input type="text" size="20" name="member[mobile]" id="mobile"/></td>
</tr>
<tr>
<td class="tl">MSN</td>
<td><input type="text" size="20" name="member[msn]" id="msn"/></td>
</tr>
<tr>
<td class="tl">QQ</td>
<td><input type="text" size="20" name="member[qq]" id="qq"/></td>
</tr>
</table>
<div class="tt">公司资料</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">公司名称 <span class="f_red">*</span></td>
<td><input type="text" size="30" name="member[company]" id="company" onblur="validator('company');"/>&nbsp;<span id="dcompany" class="f_red"></span> <span class="f_gray">个人请填写姓名</span></td>
</tr>
<tr>
<td class="tl">公司类型 <span class="f_red">*</span></td>
<td><?php echo dselect($COM_TYPE, 'member[type]', '请选择', '', 'id="type"', 0);?>&nbsp;<span id="dtype" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">形象图片</td>
<td><input name="member[thumb]" type="text" size="60" id="thumb"/>&nbsp;&nbsp;<span onclick="Dthumb(<?php echo $moduleid;?>,<?php echo $MOD['thumb_width'];?>,<?php echo $MOD['thumb_height'];?>, $('thumb').value);" class="jt">[上传]</span>&nbsp;&nbsp;<span onclick="_preview($('thumb').value);" class="jt">[预览]</span>&nbsp;&nbsp;<span onclick="$('thumb').value='';" class="jt">[删除]</span><br/>
<span class="f_gray">建议使用总经理照片、办公环境、LOGO等标志性图片，最佳大小为<?php echo $MOD['thumb_width'];?>px*<?php echo $MOD['thumb_height'];?>px，最佳格式为JPG</span></td>
</tr>
<tr>
<td class="tl">公司所在地 <span class="f_red">*</span></td>
<td><?php echo ajax_area_select('member[areaid]', '所在地区', 0, '', 2);?>&nbsp;<span id="dareaid" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">所属行业 <span class="f_red">*</span></td>
<td><?php echo ajax_category_select('member[catid]', '所属行业');?>&nbsp;<span id="dcatid" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">主营行业</td>
<td><input type="text" size="60" name="member[business]" id="business"/> <?php echo category_select('', '选择行业', '', '1', 'onchange="stoinp(this.options[this.selectedIndex].innerHTML, \'business\', \'|\', 1);"');?><br/>
<span class="f_gray">多个主营行业请用'|'号隔开</span></td>
</tr>
<tr>
<td class="tl">经营模式</td>
<td>
<span id="com_mode"><?php echo dcheckbox($COM_MODE, 'member[mode]', '', 'onclick="check_mode(this);"', 0);?></span> <span class="f_gray">(最多可选两种)</span></td>
</tr>
<tr>
<td class="tl">公司规模</td>
<td><?php echo dselect($COM_SIZE, 'member[size]', '请选择规模', '', '', 0);?></td>
</tr>
<tr>
<td class="tl">注册资本</td>
<td><?php echo dselect($MONEY_UNIT, 'member[regunit]', '', '', '', 0);?> <input type="text" size="6" name="member[capital]" id="capital"/> 万</td>
</tr>
<tr>
<td class="tl">公司成立年份 <span class="f_red">*</span></td>
<td><input type="text" size="15" name="member[regyear]" id="regyear"/>&nbsp;<span id="dregyear" class="f_red"></span> <span class="f_gray">(年份，如：2004)</span></td>
</tr>
<tr>
<td class="tl">公司注册地 <span class="f_red">*</span></td>
<td><input type="text" size="20" name="member[regcity]" id="regcity"/>&nbsp;<span id="dregcity" class="f_red"></span> <span class="f_gray">(省份/城市 例如 陕西/西安)</span> </td>
</tr>
<tr>
<td class="tl">主要经营地点 <span class="f_red">*</span></td>
<td><input type="text" size="40" name="member[address]" id="address"/>&nbsp;<span id="daddress" class="f_red"></span> <span class="f_gray">(请填写业务部门工作地点)</span></td>
</tr>

<tr>
<td class="tl">邮政编码</td>
<td><input type="text" size="8" name="member[postalcode]" id="postalcode"/></td>
</tr>

<tr>
<td class="tl">公司电话 <span class="f_red">*</span></td>
<td><input type="text" size="20" name="member[telephone]" id="telephone"/>&nbsp;<span id="dtelephone" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">公司传真</td>
<td><input type="text" size="20" name="member[fax]" id="fax"/></td>
</tr>
<tr>
<td class="tl">公司Email</td>
<td><input type="text" size="20" name="member[mail]" id="mail"/> <span class="f_gray">[公开]</span></td>
</tr>
<tr>
<td class="tl">公司网址</td>
<td><input type="text" size="30" name="member[homepage]" id="homepage"/></td>
</tr>
<tr>
<td class="tl">销售的产品（提供的服务）</td>
<td><input type="text" size="50" name="member[sell]" id="sell"/> <span class="f_gray">多个产品或服务请用'|'号隔开</span></td>
</tr>
<tr>
<td class="tl">采购的产品（需要的服务）</td>
<td><input type="text" size="50" name="member[buy]" id="buy"/> <span class="f_gray">多个产品或服务请用'|'号隔开</span></td>
</tr>
<tr>
<td class="tl">公司介绍 <span class="f_red">*</span></td>
<td><textarea name="member[introduce]" id="introduce" class="dsn"></textarea>
<?php echo deditor($moduleid, 'introduce', 'Default', '92%', 300);?></td>
</tr>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
<script type="text/javascript">
var vid = '';
function validator(id) {
	if(!$(id).value) return false;
	vid = id;
	makeRequest('action='+id+'&value='+$(id).value, '<?php echo $MOD['linkurl'];?>ajax.php', 'dvalidator')
}
function dvalidator() {    
	if(xmlHttp.readyState==4 && xmlHttp.status==200) {
		$('d'+vid).innerHTML = xmlHttp.responseText ? xmlHttp.responseText : '';
	}
}
function check_mode(c) {
	var mode_num = 0;
	var e = $('com_mode').getElementsByTagName('input');	
	for(var i=0; i<e.length; i++) {
		if(e[i].checked) mode_num++;
	}
	if(mode_num > 2) {
		confirm('最多可选两种经营模式');
		c.checked = false;
	}
}
function Dcheck() {
	if($('groupid').value == 0) {
		Dmsg('请选择会员组。', 'groupid');
		return false;
	}
	if($('username').value == '') {
		Dmsg('请填写会员登录名。', 'username');
		return false;
	}
	if($('password').value == '') {
		Dmsg('请填写会员登录密码。', 'password');
		return false;
	}
	if($('cpassword').value == '') {
		Dmsg('请重复输入密码。', 'cpassword');
		return false;
	}
	if($('password').value != $('cpassword').value) {
		Dmsg('两次输入的密码不一致。', 'password');
		return false;
	}
	if($('email').value == '') {
		Dmsg('请填写电子邮箱。', 'email');
		return false;
	}
	if($('truename').value == '') {
		Dmsg('请填写真实姓名。', 'truename');
		return false;
	}
	if($('company').value == '') {
		Dmsg('请填写公司名称。', 'company');
		return false;
	}
	if($('type').value == '') {
		Dmsg('请选择公司类型。', 'type');
		return false;
	}
	if($('areaid').value == 0) {
		Dmsg('请选择公司所在地。', 'areaid');
		return false;
	}
	if($('catid').value == 0) {
		Dmsg('请选择公司所属行业。', 'catid');
		return false;
	}
	if($('regyear').value == '') {
		Dmsg('请填写公司成立年份。', 'regyear');
		return false;
	}
	if($('regcity').value == '') {
		Dmsg('请填写公司注册地。', 'regcity');
		return false;
	}
	if($('address').value == '') {
		Dmsg('请填写业务部门工作地点。', 'address');
		return false;
	}
	if($('telephone').value == '') {
		Dmsg('请填写公司电话。', 'telephone');
		return false;
	}
	return true;
}
</script>
<script type="text/javascript">Menuon(0);</script>
</body>
</html>