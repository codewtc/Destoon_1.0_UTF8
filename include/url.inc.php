<?php
/*
	[Destoon B2B System] Copyright (c) 2009 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
# Destoon B2B System 自定义URL规则 添加规则请访问 http://help.destoon.com 参考相关说明
$urls = array();

$urls['htm']['list'][0] = array('example'=>'disk/25.html','index'=>'{$catdir}/{$index}.{$file_ext}', 'page'=>'{$catdir}/{$prefix}{$page}.{$file_ext}');
$urls['htm']['list'][1] = array('example'=>'pc/disk/25.html','index'=>'{$parentdir}{$catdir}/{$index}.{$file_ext}', 'page'=>'{$parentdir}{$catdir}/{$prefix}{$page}.{$file_ext}');
$urls['htm']['list'][2] = array('example'=>'10_25.html','index'=>'{$prefix}{$catid}.{$file_ext}', 'page'=>'{$prefix}{$catid}_{$page}.{$file_ext}');

$urls['htm']['item'][0] = array('example'=>'1/125.html','index'=>'{$alloc}/{$prefix}{$itemid}.{$file_ext}', 'page'=>'{$alloc}/{$prefix}{$itemid}_{$page}.{$file_ext}');
$urls['htm']['item'][1] = array('example'=>'200810/25/125.html','index'=>'{$year}{$month}/{$day}/{$prefix}{$itemid}.{$file_ext}', 'page'=>'{$year}{$month}/{$day}/{$prefix}{$itemid}_{$page}.{$file_ext}');
$urls['htm']['item'][2] = array('example'=>'disk/1/125.html','index'=>'{$catdir}/{$alloc}/{$prefix}{$itemid}.{$file_ext}', 'page'=>'{$catdir}/{$alloc}/{$prefix}{$itemid}_{$page}.{$file_ext}');

$urls['php']['list'][0] = array('example'=>'list.php?catid=1&page=2','index'=>'list.php?catid={$catid}', 'page'=>'list.php?catid={$catid}&page={$page}');
$urls['php']['list'][1] = array('example'=>'list.php/catid-1-page-2/','index'=>'list.php/catid-{$catid}/', 'page'=>'list.php/catid-{$catid}-page-{$page}/');
$urls['php']['list'][2] = array('example'=>'list-htm-catid-1-page-2.html','index'=>'list-htm-catid-{$catid}.html', 'page'=>'list-htm-catid-{$catid}-page-{$page}.html');

$urls['php']['item'][0] = array('example'=>'show.php?itemid=1&page=2','index'=>'show.php?itemid={$itemid}', 'page'=>'show.php?itemid={$itemid}&page={$page}');
$urls['php']['item'][1] = array('example'=>'show.php/itemid-1-page-2/','index'=>'show.php/itemid-{$itemid}/', 'page'=>'show.php/itemid-{$itemid}-page-{$page}/');
$urls['php']['item'][2] = array('example'=>'show-htm-itmeid-1.html','index'=>'show-htm-itemid-{$itemid}.html', 'page'=>'show-htm-itemid-{$itemid}-page-{$page}.html');
?>