DROP TABLE IF EXISTS ylmf_search;
CREATE TABLE ylmf_search (
  `id` int(11) NOT NULL auto_increment,
  `class` int(11) NOT NULL,
  `search_select` char(20) default NULL,
  `action` text,
  `name` char(50) default NULL,
  `btn` char(50) default NULL,
  `img_text` varchar(200) default NULL,
  `img_url` varchar(200) default NULL,
  `url` text,
  `params` text,
  `sort` int(11) NOT NULL default '100' COMMENT '排序',
  `is_show` int(1) NOT NULL default '1',
  `is_default` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=gbk COLLATE=gbk_chinese_ci;

DROP TABLE IF EXISTS ylmf_searchclass;
CREATE TABLE ylmf_searchclass (
  `classid` int(15) NOT NULL auto_increment,
  `classname` char(20) default NULL,
  `sort` int(11) NOT NULL default '100' COMMENT '排序',
  `is_default` int(1) NOT NULL default '0' COMMENT '是否默认',
  PRIMARY KEY  (`classid`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=gbk COLLATE=gbk_chinese_ci;

DROP TABLE IF EXISTS ylmf_search_keyword;
CREATE TABLE ylmf_search_keyword (
  `id` int(11) NOT NULL auto_increment,
  `class` int(11) default '0',
  `name` varchar(10) NOT NULL default '',
  `url` text NOT NULL,
  `namecolor` char(7) default NULL,
  `sort` int(11) NOT NULL default '0',
  `day` int(11) default '0',
  `week` int(11) default '0',
  `month` int(11) default '0',
  `total` int(11) default '0',
  `starttime` int(11) NOT NULL default '0',
  `endtime` int(11) NOT NULL default '0',
  `remarks` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `classid` (`class`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=gbk COLLATE=gbk_chinese_ci;

DROP TABLE IF EXISTS ylmf_links;
CREATE TABLE ylmf_links (
  `id` int(4) unsigned NOT NULL auto_increment,
  `is_show` smallint(1) NOT NULL default '1' COMMENT '是否显示',
  `sort` int(4) NOT NULL COMMENT '排序',
  `site_name` varchar(50) NOT NULL COMMENT '站点名称',
  `site_url` varchar(50) NOT NULL,
  `add_time` int(10) NOT NULL COMMENT '友情链接添加时间',
  `remarks` varchar(200) NOT NULL COMMENT '备注',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=gbk COLLATE=gbk_chinese_ci;

DROP TABLE IF EXISTS ylmf_template;
CREATE TABLE ylmf_template (
  `id` int(15) NOT NULL auto_increment,
  `tpl_name` varchar(20) default NULL COMMENT '模版名称',
  `tpl_file` varchar(20) default NULL,
  `add_time` int(10) NOT NULL COMMENT '模板添加时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=gbk COLLATE=gbk_chinese_ci;

ALTER TABLE `ylmf_class` ADD `template` VARCHAR( 50 ) NOT NULL COMMENT '自定义模板';

INSERT INTO `ylmf_search` (`id`, `class`, `search_select`, `action`, `name`, `btn`, `img_text`, `img_url`, `url`, `params`, `sort`, `is_show`, `is_default`) VALUES
(14, 8, '搜狗', 'http://news.sogou.com/news', 'query', '搜狗新闻', '搜狗', 'static/images/s/sogou.gif', 'http://news.sogou.com/?pid=sogou-site-cdf1035c34ec3802', 'sort:''0'',\r\ntime:''0'',\r\nw:''03009900'',\r\n_asf:''news.sogou.com'',\r\n_ast:'''',\r\nmode:''1''', 3, 1, 0),
(4, 2, '百度', 'http://www.baidu.com/s', 'wd', '百度一下', '百度', 'static/images/s/baidu.gif', 'http://www.114la.com/jingjian.html', '', 3, 1, 0),
(13, 2, '谷歌', 'http://www.google.com.hk/search', 'q', '谷歌搜索', '谷歌', 'static/images/s/google.gif', 'http://www.google.com.hk/webhp?prog=aff&client=pub-0194889602661524&channel=3192690043', 'client:''pub-0194889602661524'',\r\nchannel :''3192690043'',\r\nforid :''1'',\r\nprog :''aff'',\r\nhl :''zh-CN'',\r\nsource :"sdo_sb_html",\r\nie:''gb2312''', 2, 1, 0),
(15, 2, '115搜索', 'http://115.com/s', 'q', '115搜索', '115搜索', 'static/images/s/115.gif', 'http://115.com', 'ie:"gbk"', 1, 1, 1),
(16, 9, '百度', 'http://mp3.baidu.com/m', 'word', '搜 索', '百度mp3', 'static/images/s/mp3.gif', 'http://mp3.baidu.com/m?ie=utf-8&ct=134217728&word=', 'f: "ms",\r\nct: "134217728"', 1, 1, 1),
(17, 10, '百度', 'http://video.baidu.com/v', 'word', '百度视频', '百度视频', 'static/images/s/video.gif', 'http://video.baidu.com/', 'ct:''301989888'',\r\nrn:''20'',\r\npn:''0'',\r\ndb:''0'',\r\ns:''0'',\r\nfbl:''800''', 2, 1, 0),
(18, 11, '百度', 'http://image.baidu.com/i', 'word', '搜 索', '百度图片', 'static/images/s/pic.gif', 'http://image.baidu.com/', 'ct: "201326592",\r\ncl: "2",\r\npv: "",\r\nlm: "-1"', 1, 1, 1),
(19, 13, '搜狗', 'http://wenda.sogou.com/search', 'query', '搜 索', '搜狗', 'static/images/s/sogou.gif', 'http://wenda.sogou.com/?pid=AQDJZ', '', 2, 1, 0),
(20, 14, '淘宝', 'http://search8.taobao.com/browse/search_auction.htm', 'q', '淘宝搜索', '淘宝搜索', 'static/images/s/taobao.gif', 'http://www.taobao.com/go/chn/tbk_channel/onsale.php?pid=mm_18036115_2311920_9044980', 'pid: "mm_18036115_2311920_9044980",\r\ncommend: "all",\r\nsearch_type: "action"', 1, 1, 1),
(36, 2, '搜狗', 'http://www.sogou.com/sogou', 'query', '搜狗搜索', '搜狗', 'static/images/s/sogou.gif', 'http://www.sogou.com/index.php?pid=sogou-site-cdf1035c34ec3802', 'pid:''sogou-site-cdf1035c34ec3802''', 5, 1, 0),
(21, 12, '谷歌', 'http://ditu.google.cn/maps', 'q', '搜 索', '谷歌地图', 'static/images/s/google.gif', 'http://ditu.google.cn/', '', 2, 1, 0),
(22, 2, 'SOSO', 'http://www.soso.com/q', 'w', '搜 索', 'SOSO', 'static/images/s/soso.gif', 'http://www.soso.com/?unc=s200000_7&cid=union.s.wh', 'unc: "s200000_7",\r\ncid: "union.s.wh",\r\nie:''gb2312''', 5, 1, 0),
(23, 9, 'SOSO', 'http://cgi.music.soso.com/fcgi-bin/m.q', 'w', '搜 索', '搜搜mp3', 'static/images/s/soso.gif', 'http://music.soso.com/?unc=s200000_7&cid=union.s.wh', 'unc: "s200000_7",\r\ncid: "union.s.wh"', 3, 1, 0),
(24, 9, '谷歌', 'http://www.google.cn/music/search', 'q', '搜 索', '谷歌', 'static/images/s/google.gif', 'http://www.google.cn/music/homepage', 'aq: "f",\r\nie: "gb2312",\r\noe: "utf8",\r\nhl: "zh-CN"', 2, 1, 0),
(25, 10, '谷歌', 'http://www.google.com.hk/search', 'q', '搜 索', '谷歌', 'static/images/s/google.gif', 'http://www.google.com.hk/videohp', 'tbo: "p",\r\ntbs: "vid:1",\r\nsource: "vgc",\r\nie:''gb2312''', 3, 1, 0),
(26, 11, '谷歌', 'http://images.google.com.hk/images', 'q', '搜 索', '谷歌', 'static/images/s/google.gif', 'http://images.google.com.hk/imgcat/imghp?hl=zh-CN', 'gbv: "2",\r\nsource: "hp",\r\nhl: "zh-CN"', 2, 1, 0),
(27, 8, 'SOSO', 'http://news.soso.com/n.q', 'w', '搜 索', '搜搜新闻', 'static/images/s/soso.gif', 'http://news.soso.com/?cid=union.s.wh', 'cid: "union.s.wh",\r\nie:''gb2312''', 4, 1, 0),
(28, 10, '115搜索', 'http://v.115.com/', 'q', '搜 索', '115影视', 'static/images/s/115.gif', 'http://v.115.com', 'ie:''gbk''', 1, 1, 1),
(29, 8, '百度', 'http://news.baidu.com/ns', 'word', '搜 索', '百度新闻', 'static/images/s/news.gif', 'http://news.baidu.com/', '', 1, 1, 1),
(30, 14, '京东', 'http://search.360buy.com/Search', 'keyword', '京东', '京东', 'static/images/s/360buy.gif', 'http://www.360buy.com/', '', 4, 1, 0),
(31, 13, '百度', 'http://zhidao.baidu.com/q', 'word', '百度一下', '百度一下', 'static/images/s/zhidao.gif', 'http://zhidao.baidu.com/q?pt=ylmf_ik', 'tn: "ikaslist",\r\nct: "17",\r\npt: "ylmf_ik"', 1, 1, 1),
(32, 12, '百度', 'http://map.baidu.com/m', 'word', '百度一下', '百度地图', 'static/images/s/baidu.gif', 'http://map.baidu.com/', '', 1, 1, 1),
(33, 8, '谷歌', 'http://news.google.com.hk/news/search', 'q', '搜 索', '谷歌', 'static/images/s/google.gif', 'http://news.google.com.hk/', 'ie:''gb2312''', 2, 1, 0),
(34, 14, '卓越', 'http://www.amazon.cn/search/search.asp', 'searchWord', '搜 索', '卓越', 'static/images/s/joyo.gif', 'http://www.amazon.cn/', '', 3, 1, 0),
(35, 14, '当当', 'http://search.dangdang.com/search.aspx', 'key', '搜 索', '当当网', 'static/images/s/dangdang.gif', 'http://www.dangdang.com/', '', 4, 1, 0),
(37, 11, '搜狗', 'http://pic.sogou.com/pics', 'query', '搜狗图片', '搜狗图片', 'static/images/s/sogou.gif', 'http://pic.sogou.com/?pid=sogou-site-b2531e7bb29bf22e', 'pid:''sogou-site-b2531e7bb29bf22e''', 3, 1, 0);

INSERT INTO `ylmf_searchclass` (`classid`, `classname`, `sort`, `is_default`) VALUES
(2, '网页', 2, 1),
(8, '新闻', 1, 0),
(9, 'MP3', 3, 0),
(10, '视频', 4, 0),
(11, '图片', 5, 0),
(12, '地图', 6, 0),
(13, '问答', 7, 0),
(14, '购物', 8, 0);

INSERT INTO `ylmf_search_keyword` (`id`, `class`, `name`, `url`, `namecolor`, `sort`, `day`, `week`, `month`, `total`, `starttime`, `endtime`, `remarks`) VALUES
(33, 8, '金庸去世', 'http://www.baidu.com/s?wd=%BD%F0%D3%B9%C8%A5%CA%C0&tn=ylmf_4_pg&ch=4', '', 1, 0, 0, 0, 0, 0, 0, ''),
(13, 2, '冬装', 'http://search8.taobao.com/browse/search_auction.htm?q=冬装&pid=mm_18036115_2311920_9044980&commend=all&search_type=auction&user_action=initiative&f=D9_5_1&at_topsearch=1&sort=&spercent=0', '', 2, 0, 0, 0, 0, 0, 0, ''),
(11, 2, '淘宝皇冠店', 'http://pindao.huoban.taobao.com/channel/huangguan.htm?pid=mm_18036115_2311920_9044980', '', 3, 0, 0, 0, 0, 0, 0, ''),
(14, 2, '亚冠抽签直播', 'http://115.com/s?q=%E4%BA%9A%E5%86%A0%E6%8A%BD%E7%AD%BE%E7%9B%B4%E6%92%AD', '', 1, 0, 0, 0, 0, 0, 0, ''),
(10, 2, '诺基亚E72', 'http://search8.taobao.com/browse/search_auction.htm?q=诺基亚E72&pid=mm_18036115_2311920_9044980&commend=all&search_type=auction&user_action=initiative&f=D9_5_1&at_topsearch=1&sort=&spercent=0', '', 4, 0, 0, 0, 0, 0, 0, ''),
(15, 9, '情歌没有告诉你', 'http://mp3.baidu.com/m?word=%C7%E9%B8%E8%C3%BB%D3%D0%B8%E6%CB%DF%C4%E3+%C1%BA.&tn=ylmf_4_pg&ch=4&f=ms&ct=134217728', '', 1, 0, 0, 0, 0, 0, 0, ''),
(16, 9, '记得', 'http://mp3.baidu.com/m?word=%BC%C7%B5%C3+%C1%D6%BF%A1%BD%DC&tn=ylmf_4_pg&ch=4&f=ms&ct=134217728', '', 2, 0, 0, 0, 0, 0, 0, ''),
(17, 9, '永远爱不完', 'http://mp3.baidu.com/m?word=%D3%C0%D4%B6%B0%AE%B2%BB%CD%EA+%B9%F9%B8%BB%B3%C7&tn=ylmf_4_pg&ch=4&f=ms&ct=134217728', '', 3, 0, 0, 0, 0, 0, 0, ''),
(18, 9, '春天里', 'http://mp3.baidu.com/m?word=%B4%BA%CC%EC%C0%EF+%CD%F4%B7%E5&tn=ylmf_4_pg&ch=4&f=ms&ct=134217728', '', 4, 0, 0, 0, 0, 0, 0, ''),
(19, 10, '让子弹飞', 'http://115.com/?q=%E8%AE%A9%E5%AD%90%E5%BC%B9%E9%A3%9E', '', 1, 0, 0, 0, 0, 0, 0, ''),
(20, 10, '赵氏孤儿', 'http://115.com/?q=%E8%B5%B5%E6%B0%8F%E5%AD%A4%E5%84%BF', '', 2, 0, 0, 0, 0, 0, 0, ''),
(21, 10, '大笑江湖', 'http://115.com/?q=%E5%A4%A7%E7%AC%91%E6%B1%9F%E6%B9%96', '', 3, 0, 0, 0, 0, 0, 0, ''),
(22, 10, '刑警2010', 'http://115.com/?q=%E5%88%91%E8%AD%A62010', '', 4, 0, 0, 0, 0, 0, 0, ''),
(23, 11, 'justin bie', 'http://image.baidu.com/i?tn=baiduimage&ct=201326592&cl=2&pv=&lm=-1&word=justin bieber', '', 1, 0, 0, 0, 0, 0, 0, ''),
(24, 11, '周杰伦', 'http://image.baidu.com/i?tn=baiduimage&ct=201326592&cl=2&pv=&lm=-1&word=周杰伦', '', 2, 0, 0, 0, 0, 0, 0, ''),
(25, 11, '范冰冰', 'http://image.baidu.com/i?tn=baiduimage&ct=201326592&cl=2&pv=&lm=-1&word=范冰冰', '', 3, 0, 0, 0, 0, 0, 0, ''),
(26, 11, '张馨予', 'http://image.baidu.com/i?tn=baiduimage&ct=201326592&cl=2&pv=&lm=-1&word=张馨予', '', 4, 0, 0, 0, 0, 0, 0, ''),
(27, 13, '遇到火灾怎么办?', 'http://zhidao.baidu.com/q?word=%D3%F6%B5%BD%BB%F0%D4%D6%D4%F5%C3%B4%B0%EC&tn=ikaslist&ct=17&pt=ylmf_ik', '', 1, 0, 0, 0, 0, 0, 0, ''),
(28, 13, '张衡地动仪真的有用吗', 'http://zhidao.baidu.com/q?word=%D5%C5%BA%E2%B5%D8%B6%AF%D2%C7%D5%E6%B5%C4%D3%D0%D3%C3%C2%F0&tn=ikaslist&ct=17&pt=ylmf_ik', '', 2, 0, 0, 0, 0, 0, 0, ''),
(29, 14, '潮流男装', 'http://pindao.huoban.taobao.com/channel/man.htm?pid=mm_18036115_2311920_9044980', '', 1, 0, 0, 0, 0, 0, 0, ''),
(30, 14, '时尚女装', 'http://pindao.huoban.taobao.com/channel/lady.htm?pid=mm_18036115_2311920_9044980', '', 2, 0, 0, 0, 0, 0, 0, ''),
(31, 14, '美容护肤', 'http://pindao.huoban.taobao.com/channel/beauty.htm?pid=mm_18036115_2311920_9044980', '', 3, 0, 0, 0, 0, 0, 0, ''),
(32, 14, '饰品鞋包', 'http://pindao.huoban.taobao.com/channel/jewelry.htm?pid=mm_18036115_2311920_9044980', '', 4, 0, 0, 0, 0, 0, 0, ''),
(34, 8, '李念订婚', 'http://www.baidu.com/s?wd=%C0%EE%C4%EE%B6%A9%BB%E9&tn=ylmf_4_pg&ch=4', '', 2, 0, 0, 0, 0, 0, 0, ''),
(35, 8, '凤姐应聘', 'http://www.baidu.com/s?wd=%B7%EF%BD%E3+%D3%A6%C6%B8&tn=ylmf_4_pg&ch=4', '', 3, 0, 0, 0, 0, 0, 0, ''),
(36, 8, '美日军演', 'http://www.baidu.com/s?wd=%C3%C0%C8%D5%BE%FC%D1%DD&tn=ylmf_4_pg&ch=4', '', 4, 0, 0, 0, 0, 0, 0, ''),
(37, 11, '张杰', 'http://image.baidu.com/i?tn=baiduimage&ct=201326592&cl=2&pv=&lm=-1&word=张杰', '', 5, 0, 0, 0, 0, 0, 0, ''),
(38, 12, '东莞', 'http://ditu.google.cn/maps?q=%B6%AB%DD%B8&search_select=engine_21', '', 1, 0, 0, 0, 0, 0, 0, ''),
(39, 12, '北京市', 'http://ditu.google.cn/maps?q=%B1%B1%BE%A9%CA%D0&search_select=engine_21', '', 2, 0, 0, 0, 0, 0, 0, ''),
(40, 12, '上海市', 'http://ditu.google.cn/maps?q=%C9%CF%BA%A3%CA%D0&search_select=engine_21', '', 3, 0, 0, 0, 0, 0, 0, ''),
(41, 12, '广州市', 'http://ditu.google.cn/maps?q=%B9%E3%D6%DD%CA%D0&search_select=engine_21', '', 4, 0, 0, 0, 0, 0, 0, '');

INSERT INTO `ylmf_links` (`id`, `is_show`, `sort`, `site_name`, `site_url`, `add_time`, `remarks`) VALUES
(24, 1, 1, '114啦网址导航', 'http://www.114la.com', 1291003117, '114啦网址导航'),
(25, 1, 4, '下载吧', 'http://www.xiazaiba.com', 1291004852, '下载吧_软件下载,绿色软件,手机软件下载尽在雨林木风绿色下载吧'),
(23, 1, 8, '114啦网站联盟', 'http://union.114la.com', 1291003021, '114啦网站联盟建立于分享、合作、共赢基础之上，旨在利用自身的品牌、广告及硬件优势，为广大站长提供一个互惠共赢的平台，以期实现各站与114啦的共同成长，帮助会员实现收益最大化。'),
(21, 1, 7, '115浏览器', 'http://ie.115.com/', 1290999367, '115浏览器官方网站 – 115实用浏览器，快速、安全、稳定，是最好用的浏览器！'),
(26, 1, 3, '915手机网', 'http://www.915.com', 1291015442, '915手机网 - 手机号码,话费充值,手机资讯尽在915'),
(27, 1, 6, 'Ylmf OS', 'http://www.ylmf.org', 1291015484, 'Ylmf OS-雨林木风Linux操作系统'),
(28, 1, 5, '雨林木风系统门户', 'http://www.ylmf.net', 1291015545, '雨林木风系统门户[WwW.YlmF.Net] &nbsp; - 您身边的系统顾问'),
(29, 1, 2, '115聚合搜索', 'http://115.com', 1291015785, '115聚合搜索，智能搜索'),
(30, 1, 9, '115网络U盘', 'http://u.115.com/', 1291627314, '115网络U盘（网盘），简称115网盘，是雨林木风最新推出具有存储容量大、免费、高速、稳定、易用，安全等特点的免费网络硬盘，即免费网络存储空间服务。'),
(31, 1, 10, '雨林木风论坛', 'http://bbs.ylmf.net', 1291627481, '雨林木风论坛是一个以电脑网络技术为主题， 电影音乐为娱乐焦点的新型站点；站内提供大量常用实用网络资源的免费下载，欢迎大家常来！ ,雨林木风交流论坛[BBS.YLMF.NET]-专业的电脑技术精英培养基地！');

INSERT INTO `ylmf_template` (`id`, `tpl_name`, `tpl_file`, `add_time`) VALUES(1, '默认模板', 'class.tpl', 1290752670);
