var Config = {
    Search: {
        s115: {
            action: "http://115.com/s",
            name: "q",
            btn: "聚 搜",
            img: ["/static/images/s/115.gif", "115.com"],
            url: "http://115.com/",
            params: {
				ie:'gbk'
			}
        },
        web: {
            action: "http://www.baidu.com/s",
            name: "wd",
            btn: "百度一下",
            img: ["/static/images/s/baidu.gif", "百度首页"],
            url: "http://www.baidu.com/index.php?tn="+BaiduTn.tn+"&ch="+BaiduTn.ch,
            params: {
                tn: BaiduTn.tn,
                ch: BaiduTn.ch
            }
        },
        mp3: {
            action: "http://mp3.baidu.com/m",
            name: "word",
            btn: "百度一下",
            img: ["/static/images/s/mp3.gif", "百度MP3"],
            url: "http://mp3.baidu.com/m?ie=utf-8&ct=134217728&word=&tn=ylmf_4_pg&ch=7",
            params: {
                tn: BaiduTn.tn,
                ch: BaiduTn.ch,
                f: "ms",
                ct: "134217728"
            
            }
        },
        v115: {
            action: "http://video.baidu.com/v",
            name: "word",
            btn: "百度视频",
            img: ["/static/images/s/video.gif", "影视聚搜"],
            url: "http://video.baidu.com/",
            params: {
				ct:'301989888',
				rn:'20',
				pn:'0',
				db:'0',
				s:'0',
				fbl:'800'
			}
        },
        image: {
            action: "http://image.baidu.com/i",
            name: "word",
            btn: "百度一下",
            img: ["/static/images/s/pic.gif", "百度图片"],
            url: "http://www.baidu.com/index.php?tn="+BaiduTn.tn+"&ch="+BaiduTn.ch,
            params: {
            
                tn: BaiduTn.tn,
                ch: BaiduTn.ch,
                ct: "201326592",
                cl: "2",
                pv: "",
                lm: "-1"
            }
        },
        zhidao: {
            action: "http://zhidao.baidu.com/q",
            name: "word",
            btn: "百度一下",
            img: ["/static/images/s/zhidao.gif", "百度知道"],
            url: "http://zhidao.baidu.com/q?pt=ylmf_ik",
            params: {
                tn: "ikaslist",
                ct: "17",
                pt: "ylmf_ik"
            }
        },
        taobao: {
            action: "http://search8.taobao.com/browse/search_auction.htm",
            name: "q",
            btn: "淘宝搜索",
            img: ["/static/images/s/taobao.gif?v2.0", "淘宝网"],
            url: "http://pindao.huoban.taobao.com/channel/onSale.htm?pid=mm_11836333_2239687_8764474&unid=148314",
            params: {
                pid: "mm_11836333_2239687_8764474",
                unid: "148314",
                commend: "all",
                search_type: "action",
                user_action: "initiative",
                f: "D9_5_1",
                at_topsearch: "1",
                sid: "(05ba391dbdcada4634d4077c189eeef7)",
                sort: "",
                spercent: "0"
            }
        }
    
    },
    Mail: [{
        val: 0
    }, { //163.com
        action: "http://reg.163.com/CheckUser.jsp",
        params: {
            url: "http://fm163.163.com/coremail/fcg/ntesdoor2?lightweight=1&verifycookie=1&language=-1&style=15",
            username: "#{u}",
            password: "#{p}"
        }
    }, { //126.com
        action: "https://reg.163.com/logins.jsp",
        params: {
            domain: "126.com",
            username: "#{u}@126.com",
            password: "#{p}",
            url: "http://entry.mail.126.com/cgi/ntesdoor?lightweight%3D1%26verifycookie%3D1%26language%3D0%26style%3D-1"
        }
    }, { //vip.163.com
        action: "https://ssl1.vip.163.com/logon.m",
        params: {
            username: "#{u}",
            password: "#{p}",
            enterVip: true
        }
    }, { //sina.com
        action: "http://mail.sina.com.cn/cgi-bin/login.cgi",
        params: {
            u: "#{u}",
            psw: "#{p}"
        }
    }, { //vip.sina.com
        action: "http://vip.sina.com.cn/cgi-bin/login.cgi",
        params: {

            user: "#{u}",
            pass: "#{p}"
        }
    }, { //yahoo.com.cn
        action: "https://edit.bjs.yahoo.com/config/login",
        params: {
            login: "#{u}@yahoo.com.cn",
            passwd: "#{p}",
            domainss: "yahoo",
            ".intl": "cn",
            ".src": "ym"
        }
    }, { //yahoo.cn
        action: "https://edit.bjs.yahoo.com/config/login",
        params: {
            login: "#{u}@yahoo.cn",
            passwd: "#{p}",
            domainss: "yahoocn",
            ".intl": "cn",
            ".done": "http://mail.cn.yahoo.com/inset.html"
        }
    }, { //sohu.com
        action: "http://passport.sohu.com/login.jsp",
        params: {
            loginid: "#{u}@sohu.com",
            passwd: "#{p}",
            fl: "1",
            vr: "1|1",
            appid: "1000",
            ru: "http://login.mail.sohu.com/servlet/LoginServlet",
            ct: "1173080990",
            sg: "5082635c77272088ae7241ccdf7cf062"
        }
    }, { //tom.com
        action: "http://login.mail.tom.com/cgi/login",
        params: {
            user: "#{u}",
            pass: "#{p}"
        }
    }, { //21cn.com
        action: "http://passport.21cn.com/maillogin.jsp",
        params: {
            UserName: "#{u}@21cn.com",
            passwd: "#{p}",
            domainname: "21cn.com"
        }
    }, { //yeah.net
        action: "https://reg.163.com/logins.jsp",
        params: {
            domain: "yeah.net",
            username: "#{u}@yeah.net",
            password: "#{p}",
            url: "http://entry.mail.yeah.net/cgi/ntesdoor?lightweight%3D1%26verifycookie%3D1%26style%3D-1"
        }
    }, { //tianya
        action: "http://www.tianya.cn/user/loginsubmit.asp",
        params: {
            vwriter: "#{u}",
            vpassword: "#{p}"
        }
    }, { //百度帐号
        action: "http://passport.baidu.com/?login",
        params: {
            u: "http://passport.baidu.com/center",
            username: "#{u}",
            password: "#{p}"
        }
    }, { //renren
        action: "http://passport.renren.com/PLogin.do",
        params: {
            email: "#{u}",
            password: "#{p}",
            origURL: "http://www.renren.com/Home.do",
            domain: "renren.com"
        }
    }, { //51.com
        action: "http://passport.51.com/login.5p",
        params: {
            passport_51_user: "#{u}",
            passport_51_password: "#{p}",
            gourl: "http%3A%2F%2Fmy.51.com%2Fwebim%2Findex.php"
        }
    }, { //chinaren
        action: "http://passport.sohu.com/login.jsp",
        params: {
            loginid: "#{u}@chinaren.com",
            passwd: "#{p}",
            fl: "1",
            vr: "1|1",
            appid: "1005",
            ru: "http://profile.chinaren.com/urs/setcookie.jsp?burl=http://alumni.chinaren.com/",
            ct: "1174378209",
            sg: "84ff7b2e1d8f3dc46c6d17bb83fe72bd"
        }
    
    }, {
        val: 0
    }, {
        action: "http://www.kaixin001.com/",
        type: "link"
    }, {
        action: "http://qzone.qq.com/",
        type: "link"
    }, {
        action: "http://mail.qq.com/cgi-bin/loginpage",
        type: "link"
    }, {
    
        action: "http://mail.139.com/",
        type: "link"
    }, {
        action: "http://gmail.google.com/",
        type: "link"
    }, {
        action: "http://www.hotmail.com/",
        type: "link"
    }, {
    
        action: "http://www.188.com/",
        type: "link"
    }],
	banner:{
		b4:{
			img:"static/images/banner/taoke12060.jpg",
			url:"http://pindao.huoban.taobao.com/channel/channelMall.htm?pid=mm_11140156_0_0"
		}
	},
	Track:[
		["mail_submit_114la",{n:"邮箱登录", u:"邮箱登录",q:0}]
	]
}