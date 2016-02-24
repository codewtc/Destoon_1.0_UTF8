<?php
defined('IN_DESTOON') or exit('Access Denied');
/*
	[Destoon B2B System] Copyright (c) 2009 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/

#以下变量请根据空间商提供的账号参数修改,如有疑问,请联系服务器提供商

$CFG['db_host'] = 'localhost';	// 数据库服务器,可以包括端口号
$CFG['db_user'] = 'root';		// 数据库用户名
$CFG['db_pass'] = '';		// 数据库密码
$CFG['db_name'] = 'destoon';	// 数据库名称
$CFG['db_charset'] = 'utf8';		// 数据库连接字符集
$CFG['database'] = 'mysql';		// 数据库类型
$CFG['pconnect'] = '0';			// 是否使用持久连接
$CFG['tb_pre'] = 'destoon_';	// 数据表前缀

#以下变量请谨慎设置,如无必要,请保持默认

$CFG['charset'] = 'utf-8';		// 网站字符集
$CFG['path'] = '/';		// 系统安装路径(相对于网站根路径的)
$CFG['url'] = '';		// 网站访问地址
$CFG['absurl'] = '1';	// 是否启用绝对地址1=启用[如有任一模块绑定二级域名时必须启用] 0=不启用

$CFG['com_domain'] = '';		// 公司库绑定域名
$CFG['com_vip'] = 'VIP';		// VIP名称

#以下变量建议在不生成html并且访问量过大时设置

$CFG['db_expires'] = '3600';		// 数据库查询结果缓存过期时间(秒)
$CFG['tag_expires'] = '1200';		// 数据调用标签缓存过期时间(秒)
$CFG['cache_page'] = '0';			// 是否开启PHP缓存功能(0=关闭,1=打开)
$CFG['page_expires'] = '600';		// 缓存过期时间(秒)
$CFG['template_refresh'] = '1';		// 模板自动刷新(0=关闭,1=打开,如不再修改模板,请关闭)
$CFG['template_trim'] = '0';		// 去除模板换行等多余标记,可以压缩一定网页体积(0=关闭,1=打开)

$CFG['cookie_domain'] = '';		// cookie 作用域
$CFG['cookie_path'] = '/';		// cookie 作用路径
$CFG['cookie_pre'] = 'destoon_';// cookie 前缀
$CFG['timezone'] = 'Etc/GMT-8';	// 时区设置(>PHP 5.1),Etc/GMT-8 实际表示的是 GMT+8  GMT+8 
$CFG['timediff'] = '0';			// 服务器时间校正 单位(秒) 可以为负数

$CFG['template'] = 'default';	// 默认模板
$CFG['skin'] = 'default';		// 默认风格

#网站安全设置
$CFG['errlog'] = '0';	//记录错误日志(PHP&MySQL) (0=关闭,1=打开)
$CFG['authkey'] = 'lZYwUDy45HdI6Y8s2';	    // 网站安全密钥，请勿频繁改动
$CFG['founderid'] = '1';	// 创始人ID
#创始人相对于其他超级管理员独具以下系统权限
# 全站设置 管理员管理 模块管理/设置 数据库管理 模板管理 栏目管理 地区管理 在线升级
?>