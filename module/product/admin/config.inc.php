<?php
defined('IN_DESTOON') or exit('Access Denied');
$MCFG['module'] = 'product';
$MCFG['name'] = '产品';
$MCFG['author'] = 'Destoon.COM';
$MCFG['homepage'] = 'www.destoon.com';
$MCFG['copy'] = false;
$MCFG['uninstall'] = false;

$RT = array();
$RT['file']['index'] = '产品管理';
$RT['file']['html'] = '更新网页';

$RT['action']['index']['add'] = '添加产品';
$RT['action']['index']['edit'] = '修改产品';
$RT['action']['index']['delete'] = '删除产品';
$RT['action']['index']['check'] = '审核产品';
$RT['action']['index']['reject'] = '未通过产品';
$RT['action']['index']['recycle'] = '回收站';
$RT['action']['index']['move'] = '移动产品';
$RT['action']['index']['level'] = '信息级别';

$CT = 1;
?>