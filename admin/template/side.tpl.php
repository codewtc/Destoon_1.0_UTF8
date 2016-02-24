<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
?>
<table cellpadding="0" cellspacing="0" width="100%" height="100%">
<tr>
<td class="side" title="点击关闭/打开侧栏" onclick="dside();">
<div id="side" class="side_on">&nbsp;</div>
</td>
</tr>
</table>
<script type="text/javascript">
function dside() {
	if($('side').className == 'side_on') {
		$('side').className = 'side_off';
		top.document.getElementsByName("fra")[0].cols = '0,7,*';
	} else {
		$('side').className = 'side_on';
		top.document.getElementsByName("fra")[0].cols = '188,7,*';
	}
}
</script>
</body>
</html>