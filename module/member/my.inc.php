<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$MYMODS or message('您所在的会员组无发布信息权限', $MODULE[2]['linkurl']);
$head_title = $action == 'add' ? '发布信息' : '管理信息';
include template('my', $module);
?>