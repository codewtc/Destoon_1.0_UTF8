<?php
defined('IN_DESTOON') or exit('Access Denied');
$MCFG['module'] = 'plugin';
$MCFG['name'] = '插件';
$MCFG['author'] = 'Destoon.COM';
$MCFG['homepage'] = 'www.destoon.com';
$MCFG['copy'] = false;
$MCFG['uninstall'] = false;

$RT = array();
$RT['file']['ad'] = '广告管理';
$RT['file']['announce'] = '公告管理';
$RT['file']['webpage'] = '单页管理';
$RT['file']['link'] = '友情链接';

$RT['action']['ad']['add_place'] = '添加广告位';
$RT['action']['ad']['edit_place'] = '修伽广告位';
$RT['action']['ad']['delete_place'] = '删除广告位';
$RT['action']['ad']['view'] = '预览广告位';
$RT['action']['ad']['add'] = '添加广告';
$RT['action']['ad']['edit'] = '修改广告';
$RT['action']['ad']['delete'] = '删除广告';
$RT['action']['ad']['add'] = '添加广告';
$RT['action']['ad']['list'] = '管理广告';
$RT['action']['ad']['tohtml'] = '生成广告';

$RT['action']['announce']['add'] = '添加公告';
$RT['action']['announce']['edit'] = '修改公告';
$RT['action']['announce']['delete'] = '删除公告';
$RT['action']['announce']['expire'] = '过期公告';
$RT['action']['announce']['order'] = '更新排序';

$RT['action']['webpage']['add'] = '添加单页';
$RT['action']['webpage']['edit'] = '修改单页';
$RT['action']['webpage']['delete'] = '删除单页';
$RT['action']['webpage']['order'] = '更新排序';
$RT['action']['webpage']['tohtml'] = '生成单页';

$RT['action']['link']['add'] = '添加链接';
$RT['action']['link']['edit'] = '修改链接';
$RT['action']['link']['delete'] = '删除链接';
$RT['action']['link']['check'] = '审核链接';
$RT['action']['link']['order'] = '更新排序';

$CT = false;
?>