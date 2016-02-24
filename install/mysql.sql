DROP TABLE IF EXISTS destoon_ad;
CREATE TABLE `destoon_ad` (
  `aid` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `pid` int(10) unsigned NOT NULL default '0',
  `typeid` tinyint(1) unsigned NOT NULL default '0',
  `url` varchar(255) NOT NULL default '',
  `introduce` varchar(255) NOT NULL default '',
  `hits` int(10) unsigned NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  `editor` varchar(30) NOT NULL default '',
  `edittime` int(10) unsigned NOT NULL default '0',
  `fromtime` int(10) unsigned NOT NULL default '0',
  `totime` int(10) unsigned NOT NULL default '0',
  `stat` tinyint(1) unsigned NOT NULL default '0',
  `note` text NOT NULL,
  `code` text NOT NULL,
  `text_name` varchar(100) NOT NULL default '',
  `text_url` varchar(255) NOT NULL default '',
  `text_title` varchar(100) NOT NULL default '',
  `image_src` varchar(255) NOT NULL default '',
  `image_url` varchar(255) NOT NULL default '',
  `image_alt` varchar(100) NOT NULL default '',
  `flash_src` varchar(255) NOT NULL default '',
  `flash_url` varchar(255) NOT NULL default '',
  `key_moduleid` smallint(6) unsigned NOT NULL default '0',
  `key_catid` smallint(6) unsigned NOT NULL default '0',
  `key_word` varchar(100) NOT NULL default '',
  `key_id` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`aid`)
) TYPE=MyISAM COMMENT='广告';

INSERT INTO destoon_ad VALUES('1','全站横幅468x60','13','3','http://idc.destoon.com','Destoon系统创建','2','destoon','0','destoon','1240929363','1230739200','1588348799','1','','','','','','/skin/default/image/banner.gif','http://idc.destoon.com','Destoon专用VPS主机','','','0','0','','');
INSERT INTO destoon_ad VALUES('2','网站首页图片轮播','14','6','','','0','destoon','0','destoon','1238205829','1237651200','1588348799','0','','0|http://www.destoon.com|skin/default/image/player_1.jpg\n0|http://www.destoon.com|skin/default/image/player_2.jpg\n','','','','','','','','','0','0','','');
INSERT INTO destoon_ad VALUES (3, '首页旗帜A1', 20, 3, '', '', 0, 'destoon', 1244643826, 'destoon', 1244644455, 1230739200, 1577894399, 0, '', '', '', '', '', 'skin/default/image/150x60.gif', '', '首页旗帜A1', '', '', 0, 0, '', '');
INSERT INTO destoon_ad VALUES (4, '首页旗帜A2', 21, 3, '', '', 0, 'destoon', 1244643909, 'destoon', 1244644347, 1199116800, 1577894399, 0, '', '', '', '', '', 'skin/default/image/150x60.gif', '', '首页旗帜A2', '', '', 0, 0, '', '');
INSERT INTO destoon_ad VALUES (5, '首页旗帜A3', 22, 3, '', '', 0, 'destoon', 1244643950, 'destoon', 1244644372, 1199116800, 1577894399, 0, '', '', '', '', '', 'skin/default/image/150x60.gif', '', '首页旗帜A3', '', '', 0, 0, '', '');
INSERT INTO destoon_ad VALUES (6, '首页旗帜A4', 23, 3, '', '', 0, 'destoon', 1244643986, 'destoon', 1244644380, 1199116800, 1577894399, 0, '', '', '', '', '', 'skin/default/image/150x60.gif', '', '首页旗帜A4', '', '', 0, 0, '', '');
INSERT INTO destoon_ad VALUES (7, '首页旗帜A5', 24, 3, '', '', 0, 'destoon', 1244644015, 'destoon', 1244644389, 1199116800, 1577894399, 0, '', '', '', '', '', 'skin/default/image/150x60.gif', '', '首页旗帜A5', '', '', 0, 0, '', '');
INSERT INTO destoon_ad VALUES (8, '首页旗帜A6', 25, 3, '', '', 0, 'destoon', 1244644047, 'destoon', 1244644397, 1199116800, 1577894399, 0, '', '', '', '', '', 'skin/default/image/150x60.gif', '', '首页旗帜A6', '', '', 0, 0, '', '');

DROP TABLE IF EXISTS destoon_ad_place;
CREATE TABLE `destoon_ad_place` (
  `pid` int(10) unsigned NOT NULL auto_increment,
  `moduleid` smallint(6) unsigned NOT NULL default '0',
  `typeid` tinyint(1) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `introduce` varchar(255) NOT NULL default '',
  `width` smallint(5) unsigned NOT NULL default '0',
  `height` smallint(5) unsigned NOT NULL default '0',
  `price` float unsigned NOT NULL default '0',
  `ads` smallint(4) unsigned NOT NULL default '0',
  `listorder` smallint(4) unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  `editor` varchar(30) NOT NULL default '',
  `edittime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`pid`)
) TYPE=MyISAM COMMENT='广告位';

INSERT INTO destoon_ad_place VALUES('1','5','5','供应首页排名','','','0','0','0','0','0','1237697240','destoon','1237697240');
INSERT INTO destoon_ad_place VALUES('2','5','5','供应行业排名','','','0','0','0','0','0','1237697260','destoon','1237697260');
INSERT INTO destoon_ad_place VALUES('3','5','5','供应关键字排名','','','0','0','0','0','0','1237697273','destoon','1237697273');
INSERT INTO destoon_ad_place VALUES('4','7','5','产品首页排名','','','0','0','0','0','0','1237697240','destoon','1237697240');
INSERT INTO destoon_ad_place VALUES('5','7','5','产品行业排名','','','0','0','0','0','0','1237697260','destoon','1237697260');
INSERT INTO destoon_ad_place VALUES('6','7','5','产品关键字排名','','','0','0','0','0','0','1237697273','destoon','1237697273');
INSERT INTO destoon_ad_place VALUES('7','4','5','公司首页排名','','','0','0','0','0','0','1237697240','destoon','1237697240');
INSERT INTO destoon_ad_place VALUES('8','4','5','公司行业排名','','','0','0','0','0','0','1237697260','destoon','1237697260');
INSERT INTO destoon_ad_place VALUES('9','4','5','公司关键字排名','','','0','0','0','0','0','1237697273','destoon','1237697273');
INSERT INTO destoon_ad_place VALUES('10','6','5','求购首页排名','','','0','0','0','0','0','1237697240','destoon','1237697537');
INSERT INTO destoon_ad_place VALUES('11','6','5','求购行业排名','','','0','0','0','0','0','1237697260','destoon','1237697551');
INSERT INTO destoon_ad_place VALUES('12','6','5','求购关键字排名','','','0','0','0','0','0','1237697273','destoon','1237697561');
INSERT INTO destoon_ad_place VALUES('13','0','3','横幅广告','','','468','60','0','1','0','1237697698','destoon','1237697698');
INSERT INTO destoon_ad_place VALUES('14','0','6','首页图片轮播','','','400','160','0','1','0','1237697736','destoon','1237697736');
INSERT INTO destoon_ad_place VALUES('15','0','1','供应赞助商链接','','','0','0','0','0','0','1238206486','destoon','1238206486');
INSERT INTO destoon_ad_place VALUES('16','0','1','产品赞助商链接','','','0','0','0','0','0','1238206506','destoon','1238206520');
INSERT INTO destoon_ad_place VALUES('17','0','1','公司赞助商链接','','','0','0','0','0','0','1238206545','destoon','1238206545');
INSERT INTO destoon_ad_place VALUES('18','0','1','求购赞助商链接','','','0','0','0','0','0','1238206564','destoon','1238206564');
INSERT INTO destoon_ad_place VALUES('19','0','1','展会赞助商链接','','','0','0','0','0','0','1238390687','destoon','1238390687');
INSERT INTO destoon_ad_place VALUES (20, 0, 3, '首页旗帜A1', '', '', 150, 60, 0, 1, 0, 1244643128, 'destoon', 1244644303);
INSERT INTO destoon_ad_place VALUES (21, 0, 3, '首页旗帜A2', '', '', 150, 60, 0, 1, 0, 1244643162, 'destoon', 1244644308);
INSERT INTO destoon_ad_place VALUES (22, 0, 3, '首页旗帜A3', '', '', 150, 60, 0, 1, 0, 1244643179, 'destoon', 1244644312);
INSERT INTO destoon_ad_place VALUES (23, 0, 3, '首页旗帜A4', '', '', 150, 60, 0, 1, 0, 1244643191, 'destoon', 1244644317);
INSERT INTO destoon_ad_place VALUES (24, 0, 3, '首页旗帜A5', '', '', 150, 60, 0, 1, 0, 1244643211, 'destoon', 1244644322);
INSERT INTO destoon_ad_place VALUES (25, 0, 3, '首页旗帜A6', '', '', 150, 60, 0, 1, 0, 1244643228, 'destoon', 1244644327);

DROP TABLE IF EXISTS destoon_admin;
CREATE TABLE `destoon_admin` (
  `adminid` smallint(6) unsigned NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL default '0',
  `listorder` smallint(4) unsigned NOT NULL default '0',
  `title` varchar(30) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `moduleid` smallint(6) NOT NULL default '0',
  `file` varchar(20) NOT NULL default '',
  `action` varchar(255) NOT NULL default '',
  `catid` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`adminid`)
) TYPE=MyISAM COMMENT='管理员';

INSERT INTO `destoon_admin` VALUES (1, 1, 0, '生成首页', '?action=html', '', 0, '', '', '');
INSERT INTO `destoon_admin` VALUES (2, 1, 0, '更新缓存', '?action=cache', '', 0, '', '', '');
INSERT INTO `destoon_admin` VALUES (3, 1, 0, '网站设置', '?file=setting', '', 0, '', '', '');
INSERT INTO `destoon_admin` VALUES (4, 1, 0, '模块管理', '?file=module', '', 0, '', '', '');
INSERT INTO `destoon_admin` VALUES (5, 1, 0, '数据库维护', '?file=database', '', 0, '', '', '');
INSERT INTO `destoon_admin` VALUES (6, 1, 0, '模板管理', '?file=template', '', 0, '', '', '');
INSERT INTO `destoon_admin` VALUES (7, 1, 0, '会员管理', '?moduleid=2', '', 0, '', '', '');

DROP TABLE IF EXISTS destoon_announce;
CREATE TABLE `destoon_announce` (
  `itemid` int(10) unsigned NOT NULL auto_increment,
  `typeid` int(10) unsigned NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `content` text NOT NULL,
  `hits` int(10) unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  `fromtime` int(10) unsigned NOT NULL default '0',
  `totime` int(10) unsigned NOT NULL default '0',
  `editor` varchar(30) NOT NULL default '',
  `edittime` int(10) unsigned NOT NULL default '0',
  `islink` tinyint(1) unsigned NOT NULL default '0',
  `linkurl` varchar(255) NOT NULL default '',
  `listorder` smallint(4) unsigned NOT NULL default '0',
  `template` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`itemid`),
  KEY `addtime` (`addtime`)
) TYPE=MyISAM COMMENT='公告';

DROP TABLE IF EXISTS destoon_area;
CREATE TABLE `destoon_area` (
  `areaid` smallint(6) unsigned NOT NULL auto_increment,
  `areaname` varchar(50) NOT NULL default '',
  `parentid` smallint(6) unsigned NOT NULL default '0',
  `arrparentid` varchar(255) NOT NULL default '',
  `child` tinyint(1) NOT NULL default '0',
  `arrchildid` text NOT NULL,
  `listorder` smallint(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (`areaid`)
) TYPE=MyISAM COMMENT='地区';
INSERT INTO destoon_area VALUES('1','默认地区','0','0','0','1','1');

DROP TABLE IF EXISTS destoon_article_9;
CREATE TABLE `destoon_article_9` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `catid` smallint(6) unsigned NOT NULL default '0',
  `level` tinyint(1) unsigned NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `introduce` varchar(255) NOT NULL default '',
  `tag` varchar(100) NOT NULL default '',
  `keyword` varchar(255) NOT NULL default '',
  `author` varchar(50) NOT NULL default '',
  `copyfrom` varchar(30) NOT NULL default '',
  `fromurl` varchar(255) NOT NULL default '',
  `hits` int(10) unsigned NOT NULL default '0',
  `thumb` varchar(255) NOT NULL default '',
  `username` varchar(20) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  `editor` varchar(25) NOT NULL default '',
  `edittime` int(10) unsigned NOT NULL default '0',
  `template` varchar(30) NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '0',
  `islink` tinyint(1) unsigned NOT NULL default '0',
  `linkurl` varchar(255) NOT NULL default '',
  `note` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`itemid`),
  KEY `keyword` (`keyword`),
  KEY `addtime` (`addtime`)
) TYPE=MyISAM COMMENT='资讯';

DROP TABLE IF EXISTS destoon_article_data_9;
CREATE TABLE `destoon_article_data_9` (
  `itemid` bigint(20) unsigned NOT NULL default '0',
  `content` longtext NOT NULL,
  UNIQUE KEY `itemid` (`itemid`)
) TYPE=MyISAM COMMENT='资讯内容';

DROP TABLE IF EXISTS destoon_ask;
CREATE TABLE `destoon_ask` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `typeid` int(10) unsigned NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `content` text NOT NULL,
  `username` varchar(20) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  `admin` varchar(20) NOT NULL default '',
  `admintime` int(10) unsigned NOT NULL default '0',
  `status` tinyint(1) unsigned NOT NULL default '0',
  `reply` text NOT NULL,
  `star` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`itemid`)
) TYPE=MyISAM COMMENT='客服中心';

DROP TABLE IF EXISTS destoon_buy;
CREATE TABLE `destoon_buy` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `catid` smallint(6) unsigned NOT NULL default '0',
  `typeid` smallint(2) unsigned NOT NULL default '0',
  `areaid` smallint(6) unsigned NOT NULL default '0',
  `level` tinyint(1) unsigned NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `introduce` varchar(255) NOT NULL default '',
  `amount` varchar(10) NOT NULL default '',
  `price` varchar(10) NOT NULL default '',
  `standard` varchar(20) NOT NULL default '',
  `pack` varchar(20) NOT NULL default '',
  `days` smallint(3) unsigned NOT NULL default '0',
  `tag` varchar(100) NOT NULL default '',
  `keyword` varchar(255) NOT NULL default '',
  `hits` int(10) unsigned NOT NULL default '0',
  `thumb` varchar(255) NOT NULL default '',
  `thumb1` varchar(255) NOT NULL default '',
  `thumb2` varchar(255) NOT NULL default '',
  `username` varchar(20) NOT NULL default '',
  `company` varchar(100) NOT NULL default '',
  `vip` smallint(2) unsigned NOT NULL default '0',
  `msn` varchar(50) NOT NULL default '',
  `qq` varchar(20) NOT NULL default '',
  `totime` int(10) unsigned NOT NULL default '0',
  `editor` varchar(25) NOT NULL default '',
  `edittime` int(10) unsigned NOT NULL default '0',
  `editdate` date NOT NULL default '0000-00-00',
  `addtime` int(10) unsigned NOT NULL default '0',
  `adddate` date NOT NULL default '0000-00-00',
  `template` varchar(30) NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '0',
  `linkurl` varchar(255) NOT NULL default '',
  `note` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`itemid`),
  KEY `keyword` (`keyword`),
  KEY `username` (`username`),
  KEY `editdate` (`editdate`,`vip`,`edittime`),
  KEY `edittime` (`edittime`)
) TYPE=MyISAM COMMENT='求购';


DROP TABLE IF EXISTS destoon_buy_data;
CREATE TABLE `destoon_buy_data` (
  `itemid` bigint(20) unsigned NOT NULL default '0',
  `content` mediumtext NOT NULL,
  UNIQUE KEY `itemid` (`itemid`)
) TYPE=MyISAM COMMENT='求购内容';

DROP TABLE IF EXISTS destoon_category;
CREATE TABLE `destoon_category` (
  `catid` smallint(6) unsigned NOT NULL auto_increment,
  `moduleid` smallint(6) unsigned NOT NULL default '0',
  `catname` varchar(50) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `catdir` varchar(20) NOT NULL default '',
  `letter` varchar(4) NOT NULL default '',
  `linkurl` varchar(255) NOT NULL default '',
  `parentid` smallint(6) unsigned NOT NULL default '0',
  `arrparentid` varchar(255) NOT NULL default '',
  `parentdir` varchar(255) NOT NULL default '',
  `child` tinyint(1) NOT NULL default '0',
  `arrchildid` text NOT NULL,
  `listorder` smallint(4) unsigned NOT NULL default '0',
  `template` varchar(30) NOT NULL default '',
  `show_template` varchar(30) NOT NULL default '',
  `seo_title` varchar(255) NOT NULL default '',
  `seo_keywords` varchar(255) NOT NULL default '',
  `seo_description` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`catid`)
) TYPE=MyISAM COMMENT='栏目';
INSERT INTO `destoon_category` VALUES (1, 1, '默认分类', '', 'default', 'm', '', 0, '0', '/', 0, '1', 1, '', '', '', '', '');

DROP TABLE IF EXISTS destoon_company;
CREATE TABLE `destoon_company` (
  `userid` bigint(20) unsigned NOT NULL default '0',
  `username` varchar(20) NOT NULL default '',
  `groupid` smallint(4) unsigned NOT NULL default '0',
  `company` varchar(100) NOT NULL default '',
  `validated` tinyint(1) unsigned NOT NULL default '0',
  `validator` varchar(255) NOT NULL default '',
  `validtime` int(10) unsigned NOT NULL default '0',
  `vip` smallint(2) unsigned NOT NULL default '0',
  `vipt` smallint(2) unsigned NOT NULL default '0',
  `vipr` smallint(2) NOT NULL default '0',
  `type` varchar(100) NOT NULL default '',
  `catid` int(10) unsigned NOT NULL default '0',
  `areaid` int(10) unsigned NOT NULL default '0',
  `mode` varchar(100) NOT NULL default '',
  `capital` float unsigned NOT NULL default '0',
  `regunit` varchar(15) NOT NULL default '',
  `size` varchar(100) NOT NULL default '',
  `regyear` varchar(4) NOT NULL default '',
  `regcity` varchar(30) NOT NULL default '',
  `sell` varchar(255) NOT NULL default '',
  `buy` varchar(255) NOT NULL default '',
  `business` varchar(255) NOT NULL default '',
  `telephone` varchar(50) NOT NULL default '',
  `fax` varchar(50) NOT NULL default '',
  `mail` varchar(50) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `postcode` varchar(20) NOT NULL default '',
  `homepage` varchar(255) NOT NULL default '',
  `fromtime` int(10) unsigned NOT NULL default '0',
  `totime` int(10) unsigned NOT NULL default '0',
  `thumb` varchar(255) NOT NULL default '',
  `introduce` varchar(255) NOT NULL default '',
  `hits` int(10) unsigned NOT NULL default '0',
  `keyword` varchar(255) NOT NULL default '',
  `banner` varchar(255) NOT NULL default '',
  `css` text NOT NULL,
  `template` varchar(30) NOT NULL default '',
  `skin` varchar(30) NOT NULL default '',
  `domain` varchar(100) NOT NULL default '',
  `linkurl` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`userid`),
  UNIQUE KEY `name` (`company`),
  KEY `keyword` (`keyword`)
) TYPE=MyISAM COMMENT='公司';

INSERT INTO `destoon_company` VALUES (1, 'destoon', 1, '西安嘉客信息科技有限公司', 0, '', 0, 0, 0, 0, '私营有限责任公司', 1, 1, '', '', '人民币', '', '2009', '陕西/西安', '', '', '', '029-888933679', '029-888933679', 'mail@destoon.com', '西安市高新六路43号', '710075', 'http://www.destoon.com', 0, 0, '', '西安嘉客信息科技有限公司', 2, '西安嘉客信息科技有限公司', '', '', '', '', '', '');

DROP TABLE IF EXISTS destoon_company_data;
CREATE TABLE `destoon_company_data` (
  `userid` bigint(20) unsigned NOT NULL default '0',
  `content` text NOT NULL,
  `mynote` text NOT NULL,
  UNIQUE KEY `userid` (`userid`)
) TYPE=MyISAM COMMENT='公司内容';

INSERT INTO `destoon_company_data` VALUES (1, '西安嘉客信息科技有限公司', '欢迎使用Destoon B2B网站管理系统\r\nwww.destoon.com');

DROP TABLE IF EXISTS destoon_credit;
CREATE TABLE `destoon_credit` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `authority` varchar(100) NOT NULL default '',
  `thumb` varchar(255) NOT NULL default '',
  `username` varchar(20) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  `fromtime` int(10) unsigned NOT NULL default '0',
  `totime` int(10) unsigned NOT NULL default '0',
  `editor` varchar(25) NOT NULL default '',
  `edittime` int(10) unsigned NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '0',
  `note` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`itemid`),
  KEY `username` (`username`),
  KEY `addtime` (`addtime`)
) TYPE=MyISAM COMMENT='荣誉资质';

DROP TABLE IF EXISTS destoon_exhibit;
CREATE TABLE `destoon_exhibit` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `catid` smallint(6) unsigned NOT NULL default '0',
  `level` tinyint(1) unsigned NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `keyword` varchar(255) NOT NULL default '',
  `hits` int(10) unsigned NOT NULL default '0',
  `thumb` varchar(255) NOT NULL default '',
  `username` varchar(20) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  `fromtime` int(10) unsigned NOT NULL default '0',
  `totime` int(10) unsigned NOT NULL default '0',
  `city` varchar(50) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `hallname` varchar(100) NOT NULL default '',
  `sponsor` varchar(100) NOT NULL default '',
  `undertaker` varchar(100) NOT NULL default '',
  `name` varchar(30) NOT NULL default '',
  `addr` varchar(255) NOT NULL default '',
  `telephone` varchar(20) NOT NULL default '',
  `mobile` varchar(20) NOT NULL default '',
  `fax` varchar(20) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `qq` varchar(20) NOT NULL default '',
  `msn` varchar(50) NOT NULL default '',
  `remark` text NOT NULL,
  `editor` varchar(25) NOT NULL default '',
  `edittime` int(10) unsigned NOT NULL default '0',
  `template` varchar(30) NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '0',
  `linkurl` varchar(255) NOT NULL default '',
  `note` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`itemid`),
  KEY `keyword` (`keyword`),
  KEY `addtime` (`addtime`)
) TYPE=MyISAM COMMENT='展会';

DROP TABLE IF EXISTS destoon_exhibit_data;
CREATE TABLE `destoon_exhibit_data` (
  `itemid` bigint(20) unsigned NOT NULL default '0',
  `content` mediumtext NOT NULL,
  UNIQUE KEY `itemid` (`itemid`)
) TYPE=MyISAM COMMENT='展会内容';

DROP TABLE IF EXISTS destoon_favorite;
CREATE TABLE `destoon_favorite` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `listorder` smallint(4) unsigned NOT NULL default '0',
  `userid` bigint(20) unsigned NOT NULL default '0',
  `typeid` bigint(20) unsigned NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `note` varchar(255) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`itemid`),
  KEY `listorder` (`listorder`,`itemid`),
  KEY `userid` (`userid`)
) TYPE=MyISAM COMMENT='商机收藏';

DROP TABLE IF EXISTS destoon_finance_cash;
CREATE TABLE `destoon_finance_cash` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `username` varchar(30) NOT NULL default '',
  `bank` varchar(20) NOT NULL default '',
  `account` varchar(30) NOT NULL default '',
  `truename` varchar(30) NOT NULL default '',
  `amount` float unsigned NOT NULL default '0',
  `fee` float unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  `ip` varchar(20) NOT NULL default '',
  `editor` varchar(30) NOT NULL default '',
  `edittime` int(10) unsigned NOT NULL default '0',
  `note` varchar(255) NOT NULL default '',
  `status` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`itemid`),
  KEY `username` (`username`)
) TYPE=MyISAM COMMENT='申请提现';

DROP TABLE IF EXISTS destoon_finance_charge;
CREATE TABLE `destoon_finance_charge` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `username` varchar(30) NOT NULL default '',
  `bank` varchar(20) NOT NULL default '',
  `amount` float unsigned NOT NULL default '0',
  `fee` float unsigned NOT NULL default '0',
  `money` float unsigned NOT NULL default '0',
  `sendtime` int(10) unsigned NOT NULL default '0',
  `receivetime` int(10) unsigned NOT NULL default '0',
  `editor` varchar(30) NOT NULL default '',
  `status` tinyint(1) unsigned NOT NULL default '0',
  `note` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`itemid`),
  KEY `username` (`username`)
) TYPE=MyISAM COMMENT='在线充值';

DROP TABLE IF EXISTS destoon_finance_record;
CREATE TABLE `destoon_finance_record` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `username` varchar(30) NOT NULL default '',
  `bank` varchar(30) NOT NULL default '',
  `amount` float NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  `reason` varchar(255) NOT NULL default '',
  `note` varchar(255) NOT NULL default '',
  `editor` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`itemid`),
  KEY `username` (`username`)
) TYPE=MyISAM COMMENT='财务流水';

DROP TABLE IF EXISTS destoon_finance_trade;
CREATE TABLE `destoon_finance_trade` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `buyer` varchar(30) NOT NULL default '',
  `seller` varchar(30) NOT NULL default '',
  `title` varchar(100) NOT NULL default '',
  `thumb` varchar(255) NOT NULL default '',
  `linkurl` varchar(255) NOT NULL default '',
  `amount` float unsigned NOT NULL default '0',
  `fee` float NOT NULL default '0',
  `fee_name` varchar(30) NOT NULL default '',
  `buyer_name` varchar(20) NOT NULL default '',
  `buyer_address` varchar(200) NOT NULL default '',
  `buyer_postcode` varchar(10) NOT NULL default '',
  `buyer_phone` varchar(20) NOT NULL default '',
  `send_type` varchar(50) NOT NULL default '',
  `send_no` varchar(50) NOT NULL default '',
  `send_time` varchar(20) NOT NULL default '',
  `add_time` smallint(6) NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  `updatetime` int(10) unsigned NOT NULL default '0',
  `editor` varchar(30) NOT NULL default '',
  `buyer_reason` text NOT NULL,
  `refund_reason` text NOT NULL,
  `note` varchar(255) NOT NULL default '',
  `status` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`itemid`),
  KEY `buyer` (`buyer`),
  KEY `seller` (`seller`)
) TYPE=MyISAM COMMENT='交易记录';

DROP TABLE IF EXISTS destoon_friend;
CREATE TABLE `destoon_friend` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `listorder` smallint(4) unsigned NOT NULL default '0',
  `userid` bigint(20) unsigned NOT NULL default '0',
  `typeid` bigint(20) unsigned NOT NULL default '0',
  `username` varchar(20) NOT NULL default '',
  `name` varchar(20) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `company` varchar(100) NOT NULL default '',
  `career` varchar(20) NOT NULL default '',
  `telephone` varchar(20) NOT NULL default '',
  `mobile` varchar(20) NOT NULL default '',
  `homepage` varchar(255) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `msn` varchar(50) NOT NULL default '',
  `qq` varchar(20) NOT NULL default '',
  `note` varchar(255) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`itemid`),
  KEY `listorder` (`listorder`,`itemid`),
  KEY `userid` (`userid`)
) TYPE=MyISAM COMMENT='我的商友';

DROP TABLE IF EXISTS destoon_group;
CREATE TABLE `destoon_group` (
  `groupid` smallint(4) unsigned NOT NULL auto_increment,
  `groupname` varchar(50) NOT NULL default '',
  `vip` smallint(2) unsigned NOT NULL default '0',
  PRIMARY KEY  (`groupid`)
) TYPE=MyISAM COMMENT='会员组';

INSERT INTO destoon_group VALUES('1','管理员','0');
INSERT INTO destoon_group VALUES('2','禁止访问','0');
INSERT INTO destoon_group VALUES('3','游客','0');
INSERT INTO destoon_group VALUES('4','待审核会员','0');
INSERT INTO destoon_group VALUES('5','注册会员','0');
INSERT INTO destoon_group VALUES('6','VIP会员','1');

DROP TABLE IF EXISTS destoon_guestbook;
CREATE TABLE `destoon_guestbook` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `username` varchar(20) NOT NULL default '',
  `title` varchar(100) NOT NULL default '',
  `content` text NOT NULL,
  `reply` text NOT NULL,
  `poster` varchar(20) NOT NULL default '',
  `hidden` tinyint(1) unsigned NOT NULL default '0',
  `status` tinyint(1) unsigned NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  `replytime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`itemid`),
  KEY `username` (`username`)
) TYPE=MyISAM COMMENT='留言本';

DROP TABLE IF EXISTS destoon_info_10;
CREATE TABLE `destoon_info_10` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `catid` smallint(6) unsigned NOT NULL default '0',
  `level` tinyint(1) unsigned NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `keyword` varchar(255) NOT NULL default '',
  `hits` int(10) unsigned NOT NULL default '0',
  `thumb` varchar(255) NOT NULL default '',
  `username` varchar(20) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  `totime` int(10) unsigned NOT NULL default '0',
  `areaid` smallint(6) unsigned NOT NULL default '0',
  `address` varchar(255) NOT NULL default '',
  `name` varchar(30) NOT NULL default '',
  `telephone` varchar(20) NOT NULL default '',
  `mobile` varchar(20) NOT NULL default '',
  `fax` varchar(20) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `qq` varchar(20) NOT NULL default '',
  `msn` varchar(50) NOT NULL default '',
  `introduce` varchar(255) NOT NULL default '',
  `editor` varchar(25) NOT NULL default '',
  `edittime` int(10) unsigned NOT NULL default '0',
  `template` varchar(30) NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '0',
  `listorder` smallint(4) unsigned NOT NULL default '0',
  `islink` tinyint(1) unsigned NOT NULL default '0',
  `linkurl` varchar(255) NOT NULL default '',
  `note` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`itemid`),
  KEY `keyword` (`keyword`),
  KEY `username` (`username`),
  KEY `edittime` (`edittime`)
) TYPE=MyISAM COMMENT='招商';

DROP TABLE IF EXISTS destoon_info_data_10;
CREATE TABLE `destoon_info_data_10` (
  `itemid` bigint(20) unsigned NOT NULL default '0',
  `content` mediumtext NOT NULL,
  UNIQUE KEY `itemid` (`itemid`)
) TYPE=MyISAM COMMENT='招商内容';

DROP TABLE IF EXISTS destoon_keylink;
CREATE TABLE `destoon_keylink` (
  `itemid` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(20) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `item` varchar(20) NOT NULL default '',
  `listorder` smallint(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (`itemid`),
  KEY `item` (`item`)
) TYPE=MyISAM COMMENT='关联链接';

DROP TABLE IF EXISTS destoon_link;
CREATE TABLE `destoon_link` (
  `itemid` int(10) unsigned NOT NULL auto_increment,
  `typeid` bigint(20) unsigned NOT NULL default '0',
  `level` tinyint(1) unsigned NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `thumb` varchar(255) NOT NULL default '',
  `introduce` varchar(255) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  `editor` varchar(30) NOT NULL default '',
  `edittime` int(10) unsigned NOT NULL default '0',
  `listorder` smallint(4) NOT NULL default '0',
  `status` tinyint(1) unsigned NOT NULL default '0',
  `linkurl` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`itemid`)
) TYPE=MyISAM COMMENT='友情链接';

INSERT INTO `destoon_link` VALUES 
(1, 1, 1, 'Destoon B2B', '', '', 'Destoon B2B网站管理系统',1241015771, 'destoon', 1241015771, 10, 3, 'http://www.destoon.com');

DROP TABLE IF EXISTS destoon_log;
CREATE TABLE `destoon_log` (
  `logid` int(10) unsigned NOT NULL auto_increment,
  `qstring` varchar(255) NOT NULL default '',
  `username` varchar(20) NOT NULL default '',
  `ip` varchar(15) NOT NULL default '',
  `logtime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`logid`)
) TYPE=MyISAM COMMENT='管理日志';


DROP TABLE IF EXISTS destoon_mail;
CREATE TABLE `destoon_mail` (
  `itemid` int(10) unsigned NOT NULL auto_increment,
  `typeid` bigint(20) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  `addtime` int(10) unsigned NOT NULL default '0',
  `editor` varchar(30) NOT NULL default '',
  `edittime` int(10) unsigned NOT NULL default '0',
  `sendtime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`itemid`)
) TYPE=MyISAM COMMENT='邮件订阅';

DROP TABLE IF EXISTS destoon_mail_list;
CREATE TABLE `destoon_mail_list` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `username` varchar(30) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `typeids` varchar(255) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  `edittime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`itemid`),
  UNIQUE KEY `username` (`username`)
) TYPE=MyISAM COMMENT='订阅列表';

DROP TABLE IF EXISTS destoon_member;
CREATE TABLE `destoon_member` (
  `userid` bigint(20) unsigned NOT NULL auto_increment,
  `username` varchar(20) NOT NULL default '',
  `company` varchar(100) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `message` smallint(6) unsigned NOT NULL default '0',
  `gender` tinyint(1) unsigned NOT NULL default '1',
  `truename` varchar(20) NOT NULL default '',
  `mobile` varchar(50) NOT NULL default '',
  `msn` varchar(50) NOT NULL default '',
  `qq` varchar(20) NOT NULL default '',
  `department` varchar(30) NOT NULL default '',
  `career` varchar(30) NOT NULL default '',
  `level` tinyint(1) unsigned NOT NULL default '0',
  `groupid` smallint(4) unsigned NOT NULL default '4',
  `money` float unsigned NOT NULL default '0',
  `money_lock` float unsigned NOT NULL default '0',
  `bank` varchar(30) NOT NULL default '',
  `account` varchar(30) NOT NULL default '',
  `regip` varchar(15) NOT NULL default '',
  `regtime` int(10) unsigned NOT NULL default '0',
  `loginip` varchar(15) NOT NULL default '',
  `logintime` int(10) unsigned NOT NULL default '0',
  `logintimes` int(10) unsigned NOT NULL default '1',
  `black` varchar(255) NOT NULL default '',
  `auth` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`userid`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `groupid` (`groupid`)
) TYPE=MyISAM COMMENT='会员';

INSERT INTO `destoon_member` VALUES (1, 'destoon', '西安嘉客信息科技有限公司', '78032e3f14617dccf7c4df2895f77059', 'mail@destoon.com', 0, 1, '嘉客', '', '', '', '', '', 1, 1, 0, 0, '', '', '', 0, '', 0, 0, '', '');

DROP TABLE IF EXISTS destoon_message;
CREATE TABLE `destoon_message` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `typeid` tinyint(1) unsigned NOT NULL default '0',
  `content` text NOT NULL,
  `fromuser` varchar(20) NOT NULL default '',
  `touser` varchar(20) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  `isread` tinyint(1) unsigned NOT NULL default '0',
  `issend` tinyint(1) unsigned NOT NULL default '0',
  `feedback` tinyint(1) unsigned NOT NULL default '0',
  `status` tinyint(1) unsigned NOT NULL default '0',
  `groupids` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`itemid`),
  KEY `touser` (`touser`)
) TYPE=MyISAM COMMENT='站内信件';

DROP TABLE IF EXISTS destoon_module;
CREATE TABLE `destoon_module` (
  `moduleid` smallint(6) unsigned NOT NULL auto_increment,
  `module` varchar(20) NOT NULL default '',
  `name` varchar(20) NOT NULL default '',
  `moduledir` varchar(20) NOT NULL default '',
  `domain` varchar(50) NOT NULL default '',
  `linkurl` varchar(50) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `listorder` tinyint(3) unsigned NOT NULL default '0',
  `islink` tinyint(1) unsigned NOT NULL default '0',
  `ismenu` tinyint(1) unsigned NOT NULL default '0',
  `disabled` tinyint(1) NOT NULL default '0',
  `installtime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`moduleid`)
) TYPE=MyISAM COMMENT='模型';

INSERT INTO destoon_module VALUES('1','destoon','核心','','','http://www.destoon.com/','','1','0','0','0','0');
INSERT INTO destoon_module VALUES('2','member','会员','member','','http://www.destoon.com/member/','','2','0','0','0','0');
INSERT INTO destoon_module VALUES('3','plugin','插件','plugin','','http://www.destoon.com/plugin/','','3','0','0','0','0');
INSERT INTO destoon_module VALUES('4','company','公司','company','','http://www.destoon.com/company/','','7','0','1','0','0');
INSERT INTO destoon_module VALUES('5','sell','供应','sell','','http://www.destoon.com/sell/','','5','0','1','0','0');
INSERT INTO destoon_module VALUES('6','buy','求购','buy','','http://www.destoon.com/buy/','','6','0','1','0','0');
INSERT INTO destoon_module VALUES('7','product','产品','product','','http://www.destoon.com/product/','','7','0','1','0','0');
INSERT INTO destoon_module VALUES('8','exhibit','展会','exhibit','','http://www.destoon.com/exhibit/','','8','0','1','0','0');
INSERT INTO destoon_module VALUES('9','article','资讯','news','','http://www.destoon.com/news/','','9','0','1','0','0');
INSERT INTO destoon_module VALUES('10','info','招商','invest','','http://www.destoon.com/invest/','','10','0','1','0','0');

DROP TABLE IF EXISTS destoon_news;
CREATE TABLE `destoon_news` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `hits` int(10) unsigned NOT NULL default '0',
  `username` varchar(20) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  `editor` varchar(25) NOT NULL default '',
  `edittime` int(10) unsigned NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '0',
  `listorder` smallint(4) unsigned NOT NULL default '0',
  `linkurl` varchar(255) NOT NULL default '',
  `note` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`itemid`),
  KEY `username` (`username`)
) TYPE=MyISAM COMMENT='公司新闻';

DROP TABLE IF EXISTS destoon_news_data;
CREATE TABLE `destoon_news_data` (
  `itemid` bigint(20) unsigned NOT NULL default '0',
  `content` mediumtext NOT NULL,
  UNIQUE KEY `itemid` (`itemid`)
) TYPE=MyISAM COMMENT='公司新闻内容';

DROP TABLE IF EXISTS destoon_product;
CREATE TABLE `destoon_product` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `catid` smallint(6) unsigned NOT NULL default '0',
  `typeid` bigint(20) unsigned NOT NULL default '0',
  `areaid` smallint(6) unsigned NOT NULL default '0',
  `level` tinyint(1) unsigned NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `introduce` varchar(255) NOT NULL default '',
  `model` varchar(20) NOT NULL default '',
  `standard` varchar(20) NOT NULL default '',
  `brand` varchar(20) NOT NULL default '',
  `unit` varchar(10) NOT NULL default '',
  `price` float unsigned NOT NULL default '0',
  `minamount` float unsigned NOT NULL default '0',
  `amount` float unsigned NOT NULL default '0',
  `days` smallint(3) unsigned NOT NULL default '0',
  `tag` varchar(100) NOT NULL default '',
  `keyword` varchar(255) NOT NULL default '',
  `hits` int(10) unsigned NOT NULL default '0',
  `thumb` varchar(255) NOT NULL default '',
  `thumb1` varchar(255) NOT NULL default '',
  `thumb2` varchar(255) NOT NULL default '',
  `username` varchar(20) NOT NULL default '',
  `company` varchar(100) NOT NULL default '',
  `vip` smallint(2) unsigned NOT NULL default '0',
  `msn` varchar(50) NOT NULL default '',
  `qq` varchar(20) NOT NULL default '',
  `editor` varchar(25) NOT NULL default '',
  `edittime` int(10) unsigned NOT NULL default '0',
  `editdate` date NOT NULL default '0000-00-00',
  `addtime` int(10) unsigned NOT NULL default '0',
  `adddate` date NOT NULL default '0000-00-00',
  `template` varchar(30) NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '0',
  `listorder` smallint(4) unsigned NOT NULL default '0',
  `linkurl` varchar(255) NOT NULL default '',
  `note` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`itemid`),
  KEY `keyword` (`keyword`),
  KEY `username` (`username`),
  KEY `editdate` (`editdate`,`vip`,`edittime`),
  KEY `edittime` (`edittime`)
) TYPE=MyISAM COMMENT='产品';

DROP TABLE IF EXISTS destoon_product_data;
CREATE TABLE `destoon_product_data` (
  `itemid` bigint(20) unsigned NOT NULL default '0',
  `content` mediumtext NOT NULL,
  UNIQUE KEY `itemid` (`itemid`)
) TYPE=MyISAM COMMENT='产品内容';

DROP TABLE IF EXISTS destoon_sell;
CREATE TABLE `destoon_sell` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `catid` smallint(6) unsigned NOT NULL default '0',
  `typeid` smallint(2) unsigned NOT NULL default '0',
  `areaid` smallint(6) unsigned NOT NULL default '0',
  `level` tinyint(1) unsigned NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `introduce` varchar(255) NOT NULL default '',
  `unit` varchar(10) NOT NULL default '',
  `price` float unsigned NOT NULL default '0',
  `minamount` float unsigned NOT NULL default '0',
  `amount` float unsigned NOT NULL default '0',
  `days` smallint(3) unsigned NOT NULL default '0',
  `tag` varchar(100) NOT NULL default '',
  `keyword` varchar(255) NOT NULL default '',
  `hits` int(10) unsigned NOT NULL default '0',
  `thumb` varchar(255) NOT NULL default '',
  `thumb1` varchar(255) NOT NULL default '',
  `thumb2` varchar(255) NOT NULL default '',
  `username` varchar(20) NOT NULL default '',
  `company` varchar(100) NOT NULL default '',
  `vip` smallint(2) unsigned NOT NULL default '0',
  `msn` varchar(50) NOT NULL default '',
  `qq` varchar(20) NOT NULL default '',
  `totime` int(10) unsigned NOT NULL default '0',
  `editor` varchar(25) NOT NULL default '',
  `edittime` int(10) unsigned NOT NULL default '0',
  `editdate` date NOT NULL default '0000-00-00',
  `addtime` int(10) unsigned NOT NULL default '0',
  `adddate` date NOT NULL default '0000-00-00',
  `template` varchar(30) NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '0',
  `linkurl` varchar(255) NOT NULL default '',
  `note` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`itemid`),
  KEY `keyword` (`keyword`),
  KEY `username` (`username`),
  KEY `editdate` (`editdate`,`vip`,`edittime`),
  KEY `edittime` (`edittime`)
) TYPE=MyISAM COMMENT='供应';

DROP TABLE IF EXISTS destoon_sell_data;
CREATE TABLE `destoon_sell_data` (
  `itemid` bigint(20) unsigned NOT NULL default '0',
  `content` mediumtext NOT NULL,
  UNIQUE KEY `itemid` (`itemid`)
) TYPE=MyISAM COMMENT='供应内容';

DROP TABLE IF EXISTS destoon_session;
CREATE TABLE `destoon_session` (
  `sessionid` varchar(32) NOT NULL default '',
  `data` mediumtext NOT NULL,
  `lastvisit` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`sessionid`)
) TYPE=MyISAM COMMENT='SESSION';

DROP TABLE IF EXISTS destoon_setting;
CREATE TABLE `destoon_setting` (
  `item` varchar(30) NOT NULL default '',
  `item_key` varchar(30) NOT NULL default '',
  `item_value` text NOT NULL,
  KEY `item` (`item`)
) TYPE=MyISAM COMMENT='网站设置';
INSERT INTO `destoon_setting` VALUES ('group-5', 'homepage', '0');
INSERT INTO `destoon_setting` VALUES ('group-5', 'buyerinfo', '0');
INSERT INTO `destoon_setting` VALUES ('group-5', 'fee', '0');
INSERT INTO `destoon_setting` VALUES ('group-5', 'moduleids', '5,6');
INSERT INTO `destoon_setting` VALUES ('group-6', 'homepage', '1');
INSERT INTO `destoon_setting` VALUES ('group-6', 'buyerinfo', '1');
INSERT INTO `destoon_setting` VALUES ('group-6', 'fee', '2000');
INSERT INTO `destoon_setting` VALUES ('group-6', 'moduleids', '5,6,7,8,9,10');

DROP TABLE IF EXISTS destoon_style;
CREATE TABLE `destoon_style` (
  `itemid` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `skin` varchar(50) NOT NULL default '',
  `template` varchar(50) NOT NULL default '',
  `author` varchar(30) NOT NULL default '',
  `groupid` varchar(20) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  `editor` varchar(25) NOT NULL default '',
  `edittime` int(10) unsigned NOT NULL default '0',
  `listorder` smallint(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (`itemid`)
) TYPE=MyISAM COMMENT='公司主页模板';

INSERT INTO destoon_style VALUES('1','默认模板','default','homepage','Destoon.COM','6,5','0','','0','1');
INSERT INTO destoon_style VALUES('2','深蓝模板','blue','homepage','Destoon.COM','6,5','0','','0','0');
INSERT INTO destoon_style VALUES('3','绿色模板','green','homepage','Destoon.COM','6,5','0','','0','0');
INSERT INTO destoon_style VALUES('4','紫色模板','purple','homepage','Destoon.COM','6,5','0','','0','0');
INSERT INTO destoon_style VALUES('5','橙色模板','orange','homepage','Destoon.COM','6,5','0','','0','0');

DROP TABLE IF EXISTS destoon_type;
CREATE TABLE `destoon_type` (
  `typeid` bigint(20) unsigned NOT NULL auto_increment,
  `listorder` smallint(4) NOT NULL default '0',
  `typename` varchar(20) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `item` varchar(20) NOT NULL default '',
  `cache` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`typeid`),
  KEY `listorder` (`listorder`),
  KEY `item` (`item`)
) TYPE=MyISAM COMMENT='分类';

DROP TABLE IF EXISTS destoon_vip;
CREATE TABLE `destoon_vip` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `content` text NOT NULL,
  `userid` bigint(20) unsigned NOT NULL default '0',
  `username` varchar(20) NOT NULL default '',
  `company` varchar(100) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  `editor` varchar(25) NOT NULL default '',
  `edittime` int(10) unsigned NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '0',
  `note` text NOT NULL,
  PRIMARY KEY  (`itemid`)
) TYPE=MyISAM COMMENT='VIP会员';

DROP TABLE IF EXISTS destoon_webpage;
CREATE TABLE `destoon_webpage` (
  `itemid` int(10) unsigned NOT NULL auto_increment,
  `item` varchar(30) NOT NULL default '',
  `title` varchar(100) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `content` mediumtext NOT NULL,
  `seo_title` varchar(255) NOT NULL default '',
  `seo_keywords` varchar(255) NOT NULL default '',
  `seo_description` varchar(255) NOT NULL default '',
  `editor` varchar(30) NOT NULL default '',
  `edittime` int(10) unsigned NOT NULL default '0',
  `listorder` smallint(4) NOT NULL default '0',
  `islink` tinyint(1) unsigned NOT NULL default '0',
  `linkurl` varchar(255) NOT NULL default '',
  `template` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`itemid`)
) TYPE=MyISAM COMMENT='单网页';

INSERT INTO destoon_webpage VALUES('1','1','关于我们','','关于我们','','','','destoon','1231494654','5','0','plugin/about.html','0');
INSERT INTO destoon_webpage VALUES('3','1','联系方式','','联系方式','','','','destoon','1231494664','4','0','plugin/contact.html','0');
INSERT INTO destoon_webpage VALUES('6','1','网站地图','','网站地图','','','','destoon','1231494690','1','0','plugin/sitemap.html','0');
INSERT INTO destoon_webpage VALUES('4','1','使用协议','','使用协议','','','','destoon','1231494671','3','0','plugin/agreement.html','0');
INSERT INTO destoon_webpage VALUES('5','1','版权隐私','','版权隐私','','','','destoon','1231494679','2','0','plugin/copyright.html','0');