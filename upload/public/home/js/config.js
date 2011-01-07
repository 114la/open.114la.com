/**
 * ==========================================
 * config.js
 * Copyright (c) 2010 wwww.114la.com
 * Author: cai@115.com
 * ==========================================
 */

var Config = {
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
    }, { //∞Ÿ∂»’ ∫≈
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
		[]
	],
	Keywords:[]  

}

function getProId(proName){
    var ProId;
    CityArr.forEach(function(element, index, array){
        if (element[0] == proName) {
            ProId = element[2]
        }
    })
    return ProId
}

function getCityId(ProId, CityName){
    var CityId;
    CityArr.forEach(function(element, index, array){
        if (element[0] == CityName && element[1] == ProId) {
            CityId = element[2]
        }
    })
    return CityId
}