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
  `sort` int(11) NOT NULL default '100' COMMENT '����',
  `is_show` int(1) NOT NULL default '1',
  `is_default` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=gbk COLLATE=gbk_chinese_ci;

DROP TABLE IF EXISTS ylmf_searchclass;
CREATE TABLE ylmf_searchclass (
  `classid` int(15) NOT NULL auto_increment,
  `classname` char(20) default NULL,
  `sort` int(11) NOT NULL default '100' COMMENT '����',
  `is_default` int(1) NOT NULL default '0' COMMENT '�Ƿ�Ĭ��',
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
  `is_show` smallint(1) NOT NULL default '1' COMMENT '�Ƿ���ʾ',
  `sort` int(4) NOT NULL COMMENT '����',
  `site_name` varchar(50) NOT NULL COMMENT 'վ������',
  `site_url` varchar(50) NOT NULL,
  `add_time` int(10) NOT NULL COMMENT '�����������ʱ��',
  `remarks` varchar(200) NOT NULL COMMENT '��ע',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=gbk COLLATE=gbk_chinese_ci;

DROP TABLE IF EXISTS ylmf_template;
CREATE TABLE ylmf_template (
  `id` int(15) NOT NULL auto_increment,
  `tpl_name` varchar(20) default NULL COMMENT 'ģ������',
  `tpl_file` varchar(20) default NULL,
  `add_time` int(10) NOT NULL COMMENT 'ģ�����ʱ��',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=gbk COLLATE=gbk_chinese_ci;

ALTER TABLE `ylmf_class` ADD `template` VARCHAR( 50 ) NOT NULL COMMENT '�Զ���ģ��';

INSERT INTO `ylmf_search` (`id`, `class`, `search_select`, `action`, `name`, `btn`, `img_text`, `img_url`, `url`, `params`, `sort`, `is_show`, `is_default`) VALUES
(14, 8, '�ѹ�', 'http://news.sogou.com/news', 'query', '�ѹ�����', '�ѹ�', 'static/images/s/sogou.gif', 'http://news.sogou.com/?pid=sogou-site-cdf1035c34ec3802', 'sort:''0'',\r\ntime:''0'',\r\nw:''03009900'',\r\n_asf:''news.sogou.com'',\r\n_ast:'''',\r\nmode:''1''', 3, 1, 0),
(4, 2, '�ٶ�', 'http://www.baidu.com/s', 'wd', '�ٶ�һ��', '�ٶ�', 'static/images/s/baidu.gif', 'http://www.114la.com/jingjian.html', '', 3, 1, 0),
(13, 2, '�ȸ�', 'http://www.google.com.hk/search', 'q', '�ȸ�����', '�ȸ�', 'static/images/s/google.gif', 'http://www.google.com.hk/webhp?prog=aff&client=pub-0194889602661524&channel=3192690043', 'client:''pub-0194889602661524'',\r\nchannel :''3192690043'',\r\nforid :''1'',\r\nprog :''aff'',\r\nhl :''zh-CN'',\r\nsource :"sdo_sb_html",\r\nie:''gb2312''', 2, 1, 0),
(15, 2, '115����', 'http://115.com/s', 'q', '115����', '115����', 'static/images/s/115.gif', 'http://115.com', 'ie:"gbk"', 1, 1, 1),
(16, 9, '�ٶ�', 'http://mp3.baidu.com/m', 'word', '�� ��', '�ٶ�mp3', 'static/images/s/mp3.gif', 'http://mp3.baidu.com/m?ie=utf-8&ct=134217728&word=', 'f: "ms",\r\nct: "134217728"', 1, 1, 1),
(17, 10, '�ٶ�', 'http://video.baidu.com/v', 'word', '�ٶ���Ƶ', '�ٶ���Ƶ', 'static/images/s/video.gif', 'http://video.baidu.com/', 'ct:''301989888'',\r\nrn:''20'',\r\npn:''0'',\r\ndb:''0'',\r\ns:''0'',\r\nfbl:''800''', 2, 1, 0),
(18, 11, '�ٶ�', 'http://image.baidu.com/i', 'word', '�� ��', '�ٶ�ͼƬ', 'static/images/s/pic.gif', 'http://image.baidu.com/', 'ct: "201326592",\r\ncl: "2",\r\npv: "",\r\nlm: "-1"', 1, 1, 1),
(19, 13, '�ѹ�', 'http://wenda.sogou.com/search', 'query', '�� ��', '�ѹ�', 'static/images/s/sogou.gif', 'http://wenda.sogou.com/?pid=AQDJZ', '', 2, 1, 0),
(20, 14, '�Ա�', 'http://search8.taobao.com/browse/search_auction.htm', 'q', '�Ա�����', '�Ա�����', 'static/images/s/taobao.gif', 'http://www.taobao.com/go/chn/tbk_channel/onsale.php?pid=mm_18036115_2311920_9044980', 'pid: "mm_18036115_2311920_9044980",\r\ncommend: "all",\r\nsearch_type: "action"', 1, 1, 1),
(36, 2, '�ѹ�', 'http://www.sogou.com/sogou', 'query', '�ѹ�����', '�ѹ�', 'static/images/s/sogou.gif', 'http://www.sogou.com/index.php?pid=sogou-site-cdf1035c34ec3802', 'pid:''sogou-site-cdf1035c34ec3802''', 5, 1, 0),
(21, 12, '�ȸ�', 'http://ditu.google.cn/maps', 'q', '�� ��', '�ȸ��ͼ', 'static/images/s/google.gif', 'http://ditu.google.cn/', '', 2, 1, 0),
(22, 2, 'SOSO', 'http://www.soso.com/q', 'w', '�� ��', 'SOSO', 'static/images/s/soso.gif', 'http://www.soso.com/?unc=s200000_7&cid=union.s.wh', 'unc: "s200000_7",\r\ncid: "union.s.wh",\r\nie:''gb2312''', 5, 1, 0),
(23, 9, 'SOSO', 'http://cgi.music.soso.com/fcgi-bin/m.q', 'w', '�� ��', '����mp3', 'static/images/s/soso.gif', 'http://music.soso.com/?unc=s200000_7&cid=union.s.wh', 'unc: "s200000_7",\r\ncid: "union.s.wh"', 3, 1, 0),
(24, 9, '�ȸ�', 'http://www.google.cn/music/search', 'q', '�� ��', '�ȸ�', 'static/images/s/google.gif', 'http://www.google.cn/music/homepage', 'aq: "f",\r\nie: "gb2312",\r\noe: "utf8",\r\nhl: "zh-CN"', 2, 1, 0),
(25, 10, '�ȸ�', 'http://www.google.com.hk/search', 'q', '�� ��', '�ȸ�', 'static/images/s/google.gif', 'http://www.google.com.hk/videohp', 'tbo: "p",\r\ntbs: "vid:1",\r\nsource: "vgc",\r\nie:''gb2312''', 3, 1, 0),
(26, 11, '�ȸ�', 'http://images.google.com.hk/images', 'q', '�� ��', '�ȸ�', 'static/images/s/google.gif', 'http://images.google.com.hk/imgcat/imghp?hl=zh-CN', 'gbv: "2",\r\nsource: "hp",\r\nhl: "zh-CN"', 2, 1, 0),
(27, 8, 'SOSO', 'http://news.soso.com/n.q', 'w', '�� ��', '��������', 'static/images/s/soso.gif', 'http://news.soso.com/?cid=union.s.wh', 'cid: "union.s.wh",\r\nie:''gb2312''', 4, 1, 0),
(28, 10, '115����', 'http://v.115.com/', 'q', '�� ��', '115Ӱ��', 'static/images/s/115.gif', 'http://v.115.com', 'ie:''gbk''', 1, 1, 1),
(29, 8, '�ٶ�', 'http://news.baidu.com/ns', 'word', '�� ��', '�ٶ�����', 'static/images/s/news.gif', 'http://news.baidu.com/', '', 1, 1, 1),
(30, 14, '����', 'http://search.360buy.com/Search', 'keyword', '����', '����', 'static/images/s/360buy.gif', 'http://www.360buy.com/', '', 4, 1, 0),
(31, 13, '�ٶ�', 'http://zhidao.baidu.com/q', 'word', '�ٶ�һ��', '�ٶ�һ��', 'static/images/s/zhidao.gif', 'http://zhidao.baidu.com/q?pt=ylmf_ik', 'tn: "ikaslist",\r\nct: "17",\r\npt: "ylmf_ik"', 1, 1, 1),
(32, 12, '�ٶ�', 'http://map.baidu.com/m', 'word', '�ٶ�һ��', '�ٶȵ�ͼ', 'static/images/s/baidu.gif', 'http://map.baidu.com/', '', 1, 1, 1),
(33, 8, '�ȸ�', 'http://news.google.com.hk/news/search', 'q', '�� ��', '�ȸ�', 'static/images/s/google.gif', 'http://news.google.com.hk/', 'ie:''gb2312''', 2, 1, 0),
(34, 14, '׿Խ', 'http://www.amazon.cn/search/search.asp', 'searchWord', '�� ��', '׿Խ', 'static/images/s/joyo.gif', 'http://www.amazon.cn/', '', 3, 1, 0),
(35, 14, '����', 'http://search.dangdang.com/search.aspx', 'key', '�� ��', '������', 'static/images/s/dangdang.gif', 'http://www.dangdang.com/', '', 4, 1, 0),
(37, 11, '�ѹ�', 'http://pic.sogou.com/pics', 'query', '�ѹ�ͼƬ', '�ѹ�ͼƬ', 'static/images/s/sogou.gif', 'http://pic.sogou.com/?pid=sogou-site-b2531e7bb29bf22e', 'pid:''sogou-site-b2531e7bb29bf22e''', 3, 1, 0);

INSERT INTO `ylmf_searchclass` (`classid`, `classname`, `sort`, `is_default`) VALUES
(2, '��ҳ', 2, 1),
(8, '����', 1, 0),
(9, 'MP3', 3, 0),
(10, '��Ƶ', 4, 0),
(11, 'ͼƬ', 5, 0),
(12, '��ͼ', 6, 0),
(13, '�ʴ�', 7, 0),
(14, '����', 8, 0);

INSERT INTO `ylmf_search_keyword` (`id`, `class`, `name`, `url`, `namecolor`, `sort`, `day`, `week`, `month`, `total`, `starttime`, `endtime`, `remarks`) VALUES
(33, 8, '��ӹȥ��', 'http://www.baidu.com/s?wd=%BD%F0%D3%B9%C8%A5%CA%C0&tn=ylmf_4_pg&ch=4', '', 1, 0, 0, 0, 0, 0, 0, ''),
(13, 2, '��װ', 'http://search8.taobao.com/browse/search_auction.htm?q=��װ&pid=mm_18036115_2311920_9044980&commend=all&search_type=auction&user_action=initiative&f=D9_5_1&at_topsearch=1&sort=&spercent=0', '', 2, 0, 0, 0, 0, 0, 0, ''),
(11, 2, '�Ա��ʹڵ�', 'http://pindao.huoban.taobao.com/channel/huangguan.htm?pid=mm_18036115_2311920_9044980', '', 3, 0, 0, 0, 0, 0, 0, ''),
(14, 2, '�ǹڳ�ǩֱ��', 'http://115.com/s?q=%E4%BA%9A%E5%86%A0%E6%8A%BD%E7%AD%BE%E7%9B%B4%E6%92%AD', '', 1, 0, 0, 0, 0, 0, 0, ''),
(10, 2, 'ŵ����E72', 'http://search8.taobao.com/browse/search_auction.htm?q=ŵ����E72&pid=mm_18036115_2311920_9044980&commend=all&search_type=auction&user_action=initiative&f=D9_5_1&at_topsearch=1&sort=&spercent=0', '', 4, 0, 0, 0, 0, 0, 0, ''),
(15, 9, '���û�и�����', 'http://mp3.baidu.com/m?word=%C7%E9%B8%E8%C3%BB%D3%D0%B8%E6%CB%DF%C4%E3+%C1%BA.&tn=ylmf_4_pg&ch=4&f=ms&ct=134217728', '', 1, 0, 0, 0, 0, 0, 0, ''),
(16, 9, '�ǵ�', 'http://mp3.baidu.com/m?word=%BC%C7%B5%C3+%C1%D6%BF%A1%BD%DC&tn=ylmf_4_pg&ch=4&f=ms&ct=134217728', '', 2, 0, 0, 0, 0, 0, 0, ''),
(17, 9, '��Զ������', 'http://mp3.baidu.com/m?word=%D3%C0%D4%B6%B0%AE%B2%BB%CD%EA+%B9%F9%B8%BB%B3%C7&tn=ylmf_4_pg&ch=4&f=ms&ct=134217728', '', 3, 0, 0, 0, 0, 0, 0, ''),
(18, 9, '������', 'http://mp3.baidu.com/m?word=%B4%BA%CC%EC%C0%EF+%CD%F4%B7%E5&tn=ylmf_4_pg&ch=4&f=ms&ct=134217728', '', 4, 0, 0, 0, 0, 0, 0, ''),
(19, 10, '���ӵ���', 'http://115.com/?q=%E8%AE%A9%E5%AD%90%E5%BC%B9%E9%A3%9E', '', 1, 0, 0, 0, 0, 0, 0, ''),
(20, 10, '���Ϲ¶�', 'http://115.com/?q=%E8%B5%B5%E6%B0%8F%E5%AD%A4%E5%84%BF', '', 2, 0, 0, 0, 0, 0, 0, ''),
(21, 10, '��Ц����', 'http://115.com/?q=%E5%A4%A7%E7%AC%91%E6%B1%9F%E6%B9%96', '', 3, 0, 0, 0, 0, 0, 0, ''),
(22, 10, '�̾�2010', 'http://115.com/?q=%E5%88%91%E8%AD%A62010', '', 4, 0, 0, 0, 0, 0, 0, ''),
(23, 11, 'justin bie', 'http://image.baidu.com/i?tn=baiduimage&ct=201326592&cl=2&pv=&lm=-1&word=justin bieber', '', 1, 0, 0, 0, 0, 0, 0, ''),
(24, 11, '�ܽ���', 'http://image.baidu.com/i?tn=baiduimage&ct=201326592&cl=2&pv=&lm=-1&word=�ܽ���', '', 2, 0, 0, 0, 0, 0, 0, ''),
(25, 11, '������', 'http://image.baidu.com/i?tn=baiduimage&ct=201326592&cl=2&pv=&lm=-1&word=������', '', 3, 0, 0, 0, 0, 0, 0, ''),
(26, 11, '��ܰ��', 'http://image.baidu.com/i?tn=baiduimage&ct=201326592&cl=2&pv=&lm=-1&word=��ܰ��', '', 4, 0, 0, 0, 0, 0, 0, ''),
(27, 13, '����������ô��?', 'http://zhidao.baidu.com/q?word=%D3%F6%B5%BD%BB%F0%D4%D6%D4%F5%C3%B4%B0%EC&tn=ikaslist&ct=17&pt=ylmf_ik', '', 1, 0, 0, 0, 0, 0, 0, ''),
(28, 13, '�ź�ض������������', 'http://zhidao.baidu.com/q?word=%D5%C5%BA%E2%B5%D8%B6%AF%D2%C7%D5%E6%B5%C4%D3%D0%D3%C3%C2%F0&tn=ikaslist&ct=17&pt=ylmf_ik', '', 2, 0, 0, 0, 0, 0, 0, ''),
(29, 14, '������װ', 'http://pindao.huoban.taobao.com/channel/man.htm?pid=mm_18036115_2311920_9044980', '', 1, 0, 0, 0, 0, 0, 0, ''),
(30, 14, 'ʱ��Ůװ', 'http://pindao.huoban.taobao.com/channel/lady.htm?pid=mm_18036115_2311920_9044980', '', 2, 0, 0, 0, 0, 0, 0, ''),
(31, 14, '���ݻ���', 'http://pindao.huoban.taobao.com/channel/beauty.htm?pid=mm_18036115_2311920_9044980', '', 3, 0, 0, 0, 0, 0, 0, ''),
(32, 14, '��ƷЬ��', 'http://pindao.huoban.taobao.com/channel/jewelry.htm?pid=mm_18036115_2311920_9044980', '', 4, 0, 0, 0, 0, 0, 0, ''),
(34, 8, '�����', 'http://www.baidu.com/s?wd=%C0%EE%C4%EE%B6%A9%BB%E9&tn=ylmf_4_pg&ch=4', '', 2, 0, 0, 0, 0, 0, 0, ''),
(35, 8, '���ӦƸ', 'http://www.baidu.com/s?wd=%B7%EF%BD%E3+%D3%A6%C6%B8&tn=ylmf_4_pg&ch=4', '', 3, 0, 0, 0, 0, 0, 0, ''),
(36, 8, '���վ���', 'http://www.baidu.com/s?wd=%C3%C0%C8%D5%BE%FC%D1%DD&tn=ylmf_4_pg&ch=4', '', 4, 0, 0, 0, 0, 0, 0, ''),
(37, 11, '�Ž�', 'http://image.baidu.com/i?tn=baiduimage&ct=201326592&cl=2&pv=&lm=-1&word=�Ž�', '', 5, 0, 0, 0, 0, 0, 0, ''),
(38, 12, '��ݸ', 'http://ditu.google.cn/maps?q=%B6%AB%DD%B8&search_select=engine_21', '', 1, 0, 0, 0, 0, 0, 0, ''),
(39, 12, '������', 'http://ditu.google.cn/maps?q=%B1%B1%BE%A9%CA%D0&search_select=engine_21', '', 2, 0, 0, 0, 0, 0, 0, ''),
(40, 12, '�Ϻ���', 'http://ditu.google.cn/maps?q=%C9%CF%BA%A3%CA%D0&search_select=engine_21', '', 3, 0, 0, 0, 0, 0, 0, ''),
(41, 12, '������', 'http://ditu.google.cn/maps?q=%B9%E3%D6%DD%CA%D0&search_select=engine_21', '', 4, 0, 0, 0, 0, 0, 0, '');

INSERT INTO `ylmf_links` (`id`, `is_show`, `sort`, `site_name`, `site_url`, `add_time`, `remarks`) VALUES
(24, 1, 1, '114����ַ����', 'http://www.114la.com', 1291003117, '114����ַ����'),
(25, 1, 4, '���ذ�', 'http://www.xiazaiba.com', 1291004852, '���ذ�_�������,��ɫ���,�ֻ�������ؾ�������ľ����ɫ���ذ�'),
(23, 1, 8, '114����վ����', 'http://union.114la.com', 1291003021, '114����վ���˽����ڷ�����������Ӯ����֮�ϣ�ּ�����������Ʒ�ơ���漰Ӳ�����ƣ�Ϊ���վ���ṩһ�����ݹ�Ӯ��ƽ̨������ʵ�ָ�վ��114���Ĺ�ͬ�ɳ���������Աʵ��������󻯡�'),
(21, 1, 7, '115�����', 'http://ie.115.com/', 1290999367, '115������ٷ���վ �C 115ʵ������������١���ȫ���ȶ���������õ��������'),
(26, 1, 3, '915�ֻ���', 'http://www.915.com', 1291015442, '915�ֻ��� - �ֻ�����,���ѳ�ֵ,�ֻ���Ѷ����915'),
(27, 1, 6, 'Ylmf OS', 'http://www.ylmf.org', 1291015484, 'Ylmf OS-����ľ��Linux����ϵͳ'),
(28, 1, 5, '����ľ��ϵͳ�Ż�', 'http://www.ylmf.net', 1291015545, '����ľ��ϵͳ�Ż�[WwW.YlmF.Net] &nbsp; - ����ߵ�ϵͳ����'),
(29, 1, 2, '115�ۺ�����', 'http://115.com', 1291015785, '115�ۺ���������������'),
(30, 1, 9, '115����U��', 'http://u.115.com/', 1291627314, '115����U�̣����̣������115���̣�������ľ�������Ƴ����д洢��������ѡ����١��ȶ������ã���ȫ���ص���������Ӳ�̣����������洢�ռ����'),
(31, 1, 10, '����ľ����̳', 'http://bbs.ylmf.net', 1291627481, '����ľ����̳��һ���Ե������缼��Ϊ���⣬ ��Ӱ����Ϊ���ֽ��������վ�㣻վ���ṩ��������ʵ��������Դ��������أ���ӭ��ҳ����� ,����ľ�罻����̳[BBS.YLMF.NET]-רҵ�ĵ��Լ�����Ӣ�������أ�');

INSERT INTO `ylmf_template` (`id`, `tpl_name`, `tpl_file`, `add_time`) VALUES(1, 'Ĭ��ģ��', 'class.tpl', 1290752670);
