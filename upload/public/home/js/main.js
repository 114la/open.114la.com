/**
 * ==========================================
 * base.js
 * Copyright (c) 2010 wwww.114la.com
 * Author: cai@115.com
 * ==========================================
 */
/*$("#date").el.innerHTML = Calendar.show();//显示日期*/
Date.prototype.format = function(format){
	var o = {
		"M+" : this.getMonth()+1, //month
		"d+" : this.getDate(),    //day
		"h+" : this.getHours(),   //hour
		"m+" : this.getMinutes(), //minute
		"s+" : this.getSeconds(), //second
		"q+" : Math.floor((this.getMonth()+3)/3),  //quarter
		"S" : this.getMilliseconds() //millisecond
	}
	if(/(y+)/.test(format)){
		format=format.replace(RegExp.$1,(this.getFullYear()+"").substr(4 - RegExp.$1.length));
	}
	for(var k in o){
		if(new RegExp("("+ k +")").test(format)){
			format = format.replace(RegExp.$1,RegExp.$1.length==1 ? o[k] :("00"+ o[k]).substr((""+ o[k]).length));
		}
	}
	return format;
}

$("#jp_today,#jd_fromDate,#jd_toDate").each(function(el){
	el.value = new Date(new Date().getTime()+3600*24*1000).format("yyyy-MM-dd");
});	

$("#skinlist a").on('click',function(el){
	var num = parseInt(el.innerHTML)-1;
	Cookie.set("style",num);
	skinSelector.set("style",num);	
});
var MailLogin = {
    mailCache: [],
    sendMail: function(){
        var username = $("#mail_user_114la").el.value, password = $("#mail_passwd_114la").el.value, servers = $("#mail_server_114la").el, form = document.mail, index = servers.selectedIndex, H = Config.Mail[index], F = {
            u: username,
            p: password
        };
        if (H.val == 0) {
            alert("您没有选择邮箱！");
            return
        }
        if (Yl.trim(F.u) == "") {
            alert("用户名不能为空！");
			$("#mail_user_114la").el.focus();
            return
        }
        if (Yl.trim(F.p) == "") {
            alert("密码不能为空！");
			$("#mail_passwd_114la").el.focus();
            return
        }
        
        if (this.mailCache.index != index) {
            //this.mailCache.index = index;
            this.mailCache.forEach(function(el){
                form.removeChild(el)
            });
            this.mailCache = [];
        }
        
        form.action = H.action;
        for (I in H.params) {
            $(form).create("input", {
                type: "hidden",
                name: I,
                value: format(H.params[I], F)
            }, function(el){
                MailLogin.mailCache.push(el);
                this.append(el);
            })
        }
        form.submit();
        $("#mail_passwd_114la").el.value = ""
    },
    change: function(_){
        var I = Config.Mail[_.selectedIndex];
        if (I.type == "link") {
            window.open(I.action);
            _.selectedIndex = 17
        }
        else {
            //$("#mail_passwd_114la").el.focus();
            cache.set("SE_ONFOCUS", true)
        }
    }
	
}//邮箱登录结束


document.onclick = function(e){
    var e = e || window.event, obj = e.srcElement || e.target, tid = obj.id;

	if(tid!=="showSetting"){
		if($("#settingBox").el){
			$("#settingBox").hide();
		}
	}

    if (
		(obj.tagName && obj.tagName.toUpperCase()== "A") || 
		(obj.parentNode.tagName && obj.parentNode.tagName.toUpperCase() == "A") || 
		(obj.parentNode.parentNode.tagName && obj.parentNode.parentNode.tagName.toUpperCase() == "A")){
		
		
		if(obj.rel && obj.rel=='nr'){ return;}
		
		var L,T;
		if(obj.parentNode.tagName.toUpperCase() == "A" && obj.tagName.toUpperCase() =="IMG"){
			L = obj.parentNode.href,T = obj.alt;
		}else if(obj.parentNode.parentNode.tagName.toUpperCase() == "A"){
			L = obj.parentNode.parentNode.href,
			T = obj.innerHTML;
		}else{
			L = obj.href , T = obj.innerHTML;
			if(Yl.trim(L)=="javascript:void(0);" || Yl.trim(L)=="javascript:void(0)"){
				L = T;
			}
			if(obj.getAttribute("rel")){
				L=T = obj.innerHTML;
			}
		}
		KeywordCount({
			u: L,
			n: T,
			q: 0
		});
		UserTrack.add(obj);
    }
	Config.Track.forEach(function(element){
		if(tid==element[0]){
			KeywordCount(element[1]);
		}
	});
};

$("#showSetting").on('click',function(el){
	el.blur();
	if($('#settingBox').el){
		$('#settingBox').show();
		return;
	}
	$("#wrap").create('div',{id:'settingBox'},function(el){
		var html = Yl.createFrame({
			src: '/public/widget/setting/index.html',
			width: "260",
			height: "230"
		});
		var h2 = '<span class="h2">个性设置</span>';
		el.innerHTML = h2 + '<div id="LSIMG" class="loading"></div><div id="loadSettingBox" style="display:none;">'+html+'</div>';
		this.append(el);
		var iframe = el.getElementsByTagName("iframe")[0];
		Yl.loadFrame(iframe, function(){
			$("#LSIMG").hide();
			el.innerHTML = h2+html;
			$("#settingBox .h2").on('click',function(el){
				$('#settingBox').hide();
			});
		});
	});
});

(function(){  
	if(!$("#topsite em").el) return;	  
	var timer = 200; //下拉菜单延时
	var activeContent;
	var hideState = true;
	var delayInterval;
	var hide = function(){
		if(hideState && activeContent){
			activeContent.style.display = "none";
			
		}
	}
	$("#topsite em").each(function(el){
		el.onmouseover = function(){
			hide();
			var box = el.parentNode.getElementsByTagName("div")[0];
			delayInterval = window.setTimeout(function(){$(box).show()},timer);
			activeContent = box;
			hideState = false;
			if(!box.onmouseover){
				box.onmouseover = function(){
					hideState = false;
				}
				box.onmouseout = function(){
					hideState = true;
					window.setTimeout(hide,timer);
				}
			}
		}
		el.onmouseout = function(){
			hideState = true;
			window.setTimeout(hide,timer);
			if(delayInterval!=undefined){
				window.clearTimeout(delayInterval);
			}

		}
	});
})();//结束名站子站点菜单

var qucikSearch = (function(){
    var Q = $("#q_int");
    var I = $("#q_int input");
    var R = $("#qs-result");
    var Btn = false;
    var defaultValue = I.el.value = "请输入网站名或拼音";
    var inputState = 0; //0 普通  1 focus
    var sendDelay, countDelay,timer = 200;
    var lastValue;
    
    I.on("focus", function(el){
        Q.el.className = "f";
        if (el.value == defaultValue) {
            el.value = "";
        }
        inputState = 1;
    });
    
    I.on("keyup", function(el){
        if (el.value == "") {
            closeSearch();
            return;
        }
        if (lastValue && el.value == lastValue) {
            return; //无改变
        }
        if (!Btn) {
            Q.create("a", {
                id: "qs-btn",
				rel:'nr',
                href: "javascript:void(0);",
                target: "_parent",
                title: "关闭"
            }, function(el){
                el.onclick = function(){
                    inputState = 0;
                    closeSearch();
                }
                this.append(el);
            });
            Btn = true;
        }
        if (el.value!="") {
            if (sendDelay) {
                window.clearTimeout(sendDelay);
            }
			if (countDelay) {
                window.clearTimeout(countDelay);
            }
            send(el.value);
        }
        
    })
    
    I.on("blur", function(el){
        Q.el.className = "n";
        if (el.value == "") {
            el.value = defaultValue;
        }
        
    });
    
    function closeSearch(clear){
        R.hide();
        if (Btn) {
            Q.el.removeChild($("#qs-btn").el);
            Btn = false;
        }
        if (inputState == 0 || clear == true) {
            I.el.value = defaultValue;
            //K.el.blur();
        }
        cache.remove("HAS_SHOW_QS");
    }
    function send(query){
		if(query==""){return}
        lastValue = query;
        sendDelay = window.setTimeout(function(){
			R.show();
            cache.set("HAS_SHOW_QS", true);
            R.el.innerHTML = '<ul><li>正在搜索中...</li></ul>';
            var api = './search.php?keyword=' + encodeURIComponent(query) ;
			//var api = 'search.txt?k=1';
			Ajax(api+ '&rd=' + new Date().getTime(), callback);
        }, timer);
		
        countDelay = window.setTimeout(function(){
			KeywordCount({
			type: "qs",
			word: query,
			url: window.location.href
			}, "http://www.tjj.com/click.php");
		},1000);
        
        function callback(xhr){
            if (xhr.responseText == '') {
                R.el.innerHTML = '<ul><li>没有搜索到相关站点!</li></ul>';
            }
            else {
                R.el.innerHTML = '<ul class="clearfix">' + xhr.responseText + '</ul>';
            }
        }
        
    }
    return {
        close: closeSearch
    }
})();//网址快速搜索


var HoverTab = function(el,fn){
 var evt = ["click", "mouseover"], 
	MouseDelayTime = 300, //鼠标延停时间
 	waitInterval;
	var rel = el.getAttribute("rel");
	evt.forEach(function(element){
		switch (element) {
			case "click":
				if(waitInterval){
					window.clearTimeout(waitInterval);
				}
				el["on" + element] = function(){
					fn();
					if(rel){
						KeywordCount({
							u: rel,
							n: rel,
							q: 0
						});
					}
				}
				break;
			case "mouseover":
				el["on" + element] = function(){
					if(waitInterval){
						window.clearTimeout(waitInterval);
					}
					waitInterval = window.setTimeout(function(){
						fn();
						if(rel){
							KeywordCount({
								u: rel,
								n: rel,
								q: 0
							});
						}
					}, MouseDelayTime);
					
					
				}
				el["onmouseout"] = function(){
					if (waitInterval != undefined) {
						window.clearTimeout(waitInterval);
					}
				}
				break;
		}
	});	
}


//名站TAB菜单开始

$("#bm_tab li").each(function(el){
		HoverTab(el,run);
        function run(){
			if(cache.get("HAS_SHOW_QS")){
				qucikSearch.close(true);
				$("#q_int input").el.blur();
			}//hock_hide_qs
			
            $("#bm_tab li").removeClass("active");
            el.className = "active";
            show(el);
        }
        function show(el){
			var stm;
            var boxid = el.getAttribute("rel"), url = el.getAttribute("url"), noCache = el.getAttribute("nocache");
            if (!boxid) {
                return;
            }
            var Tabs = cache.get("BOARD_BOX_TAB");
            if(('#'+boxid)==cache.get("LAST_BOXTAB")){
				return;
			}
            if (cache.is("LAST_BOXTAB")) {
                var box = $(cache.get("LAST_BOXTAB"));
                if (box.el.className == "nocache") {
					//box.el.innerHTML = "";
					//box.el.parentNode.removeChild(box.el);
					//box.el.getElementsByTagName("iframe")[0].src="";
					box.el.getElementsByTagName("iframe")[0].src="";
					box.hide();
                }else {
                    box.hide();
                }
            }
            else {
                $("#fm").hide();
            }
            if (!url) {
                $("#" + boxid).show();
                cache.set("LAST_BOXTAB", "#" + boxid);
                return;
            }else if (cache.is("BOARD_BOX_TAB") == false) {
                    createTabBox();					
            }else {
				if (Tabs.indexOf(boxid) == -1) {
					createTabBox();
					
				}
            }
            
            function createTabBox(){
				    var newNode = document.createElement("div");
					newNode.id=boxid;
					var newHtml = '<iframe width="100%" height="272" frameborder="0" scrolling="no" allowtransparency="true" src="'+url+'"></iframe>';
					newNode.innerHTML=newHtml;
					$("#bb .box").el.insertBefore(newNode,$("#bb .box").el.firstChild);
					if(noCache) {
                        newNode.className = "nocache";
						cache.set("BOARD_BOX_TAB", boxid, 1);
                    }else {
                        cache.set("BOARD_BOX_TAB", boxid, 1);
                    }
                /*$("#bb .box").create("div", {
                    id: boxid
                }, function(el){
                    var html = Yl.createFrame({
                        src: url,
                        width: "100%",
                        height: "302"
                    });
                    
                    el.innerHTML = '<div class="loading"><div style="display:none;">' + html + '</div></div>';
                    this.append(el);
                    var iframe = el.getElementsByTagName("iframe")[0];

                    Yl.loadFrame(iframe, function(){
                        //setTimeout(function(){el.innerHTML= html},2000);
                        el.innerHTML = html;
                    });
                    if(noCache) {
                        el.className = "nocache";
                    }else {
                        cache.set("BOARD_BOX_TAB", el.id, 1);
                    }
                })*/
            }
            cache.set("LAST_BOXTAB", "#" + boxid);
			if(noCache){
				$("#" + boxid).show();
				$("#"+boxid).el.getElementsByTagName("iframe")[0].src=url;
			}else {$("#" + boxid).show();}
        }//show
    });
//结束名站切换版块Tab菜单



var Suggest = (function(){
    var K , S = $("#suggest"), Query,//输入值
 currentKey = -1, dataScript = null,//数据脚本
 dataResult,//结果数据
 KeywordItems, //li
 mouseSelect = false, stopRequest = false, Hidestate = false, isClose = false;
var KEL;
	$(".sf .int").each(function(el){
		K = $(el);
		
		
		K.el.onkeydown = function(e){
			var e = e || window.event;
			if (isClose) {
				return;
			}
			KEL = this
			switch (e.keyCode) {
				case 38:
					if (Hidestate) {
						if (this.value == "") 
							return;
						S.show();
						Hidestate = false;
					}
					else {
						currentKey--
					}
					selectItem();
					break;
				case 40:
					if (Hidestate) {
						if (this.value == "") 
							return;
						S.show();
						Hidestate = false;
					}
					else {
						currentKey++
					}
					selectItem();
					break;
				case 27:
					this.value = Query;
					hideSuggest();
					break;
				case 13:
					hideSuggest();
					break;
				default:
					//stopRequest = false;
					break;
			}
		}

    K.el.onkeyup = function(e){
        var e = e || window.event;
        if (isClose) {
            return;
        }
        
		var myKey = Number(this.getAttribute("index"));
		for(var j = 0, jlen = inputTxtArr.length; j < jlen; j++){
			var oKey = Number(inputTxtArr[j].getAttribute("index"));
			if(oKey != myKey){
				inputTxtArr[j].value = this.value;
			}
		}
        Query = this.value;
       
        switch (e.keyCode) {
            case 38:
                stopRequest = true;
                
                break;
            case 40:
                stopRequest = true;
                break;
            case 8:
                if (this.value == "") {
                    hideSuggest();
                }
                else {
                    requestData();
                }
                break;
            case 27:
                this.value = Query;
                hideSuggest();
            case 13:
                hideSuggest();
                break;
            default:
                if (Query != "") {
                    requestData();
                }
                
                break;
        }
    }
	
	
	
    K.el.onblur = function(){
        if (!mouseSelect) {
            hideSuggest();
        }
    }
	
    function selectItem(){
        if (!KeywordItems) 
            return;
        var len = KeywordItems.length;
        
        stopRequest = true;
        if (currentKey < 0) {
            currentKey = len - 1;
        }
        else 
            if (currentKey >= len) {
                currentKey = 0;
            }
        for (var i = 0, len = KeywordItems.length; i < len; i++) {
            KeywordItems[i].className = "";
        }
        KeywordItems[currentKey].className = "hover";
        //K.el.value = KeywordItems[currentKey].innerHTML;
		for(var j = 0, jlen = inputTxtArr.length; j < jlen; j++){
			inputTxtArr[j].value = KeywordItems[currentKey].innerHTML;
		}
    }
    
    function showSuggest(){
        if (typeof(dataResult) != "object" || typeof(dataResult) == "undefined") 
            return;
        var html = '<ul>';
        dataResult.forEach(function(el, index, arr){
                html += '<li key="' + index + '">' + el + '</li>';
        });
        html += '</ul><div class="close"><a id="closeSugBtn">关闭</a></div>';
        KeywordItems = S.el.getElementsByTagName("li");
        S.el.innerHTML = html;
        S.show();
        currentKey = -1;
        Hidestate = false;
        mouseHandle();
    }
    function hideSuggest(){
        S.hide();
        Hidestate = true;
        
    }
    
    function closeSuggest(){
        KEL.setAttribute("autocomplete", "on");
        KEL.focus();
        S.hide();
        isClose = true;
    }
    
    function mouseHandle(){
        S.el.onmouseover = function(e){
            var e = e || window.event, target = e.target || e.srcElement;
            
            if (target.tagName.toUpperCase() == "LI") {
                for (var i = 0, len = KeywordItems.length; i < len; i++) {
                    KeywordItems[i].className = "";
                }
                target.className = "hover";
                currentKey = parseInt(target.getAttribute("key"));
                
                $(target).on("mouseout", function(el){
                    el.className = "";
                })
            }
            mouseSelect = true;
        }
        S.el.onmouseout = function(){
            mouseSelect = false;
        }
        
        S.el.onclick = function(e){
            var e = e || window.event, target = e.target || e.srcElement;
            if (target.tagName.toUpperCase() == "LI") {
				for(var j = 0, jlen = inputTxtArr.length; j < jlen; j++){
					inputTxtArr[j].value = target.innerHTML;
				}
                hideSuggest();
               var SF =  KEL.parentNode;
			   //SF.onsubmit();
			   SF.submit();
            }
            if (target.id == "closeSugBtn") {
                closeSuggest();
            }
            
        }
    }

    function requestData(){
        var head = $("head").el;
        if (!Browser.isIE) {
            if (dataScript) {
                head.removeChild(dataScript);
            }
            dataScript = null;
        } // IE不需要重新创建script元素
        if (!dataScript) {
            var script = document.createElement("script");
            script.type = "text/javascript";
			script.charset = "gb2312";
            head.insertBefore(script, head.firstChild);
            dataScript = script;
        }
        var rd = new Date().getTime();
        var key = encodeURIComponent(K.el.value);
        var Url = "http://suggestion.baidu.com/su?wd=" + key + "&sc=114la&rd=" + rd;
       dataScript.src = Url;
    }
	
    //baidu
    window.baidu = {};
    window.baidu.sug = function(O){
        if (typeof(O) == "object" && typeof(O.s) != "undefined" && typeof(O.s[0]) != "undefined") {
            dataResult = O.s;
            showSuggest();
        }
        else {
            hideSuggest();
        }
    };
	
	
	});
})();//搜索自动完成



/*历史记录*/
var UserTrack = (function(){
	function add(o){
		try{
			if(o.tagName.toUpperCase() ==("A") && o.href.indexOf("http://") == 0 && o.href.indexOf("http://" + Yl.getHost())!= 0 ){
				if(o.rel && o.rel=="nr"){
					return;
				}
				var Track ={
					url: o.href,
					content: o.innerHTML
				},
				data = Track.url+"+"+Track.content+"_[YLMF]_",
				oldData = Cookie.get("history");
				if(oldData){
					if(oldData.indexOf(data)>-1){
						oldData = oldData.replace(data,"");
					}				
					data += oldData;
				}
				//Cookie.set("history",data,null,null,'114la.com');
				Cookie.set("history",data);
				var Hbox;
				if( document.getElementById('bb1')){
					Hbox = document.getElementById('bb1').getElementsByTagName("iframe");
				}
				if(Hbox && Hbox.length){
					Hbox[0].contentWindow.History.show();
				}
			}
			
		}catch(e){}
	
	};
	
	return{
		add: add
	}
	
})(); 

//底部搜索
var miniSearch = (function(){
    var I = "s0";
    var Q = $("#f_int input").el;
    $("#f_radio input.radio").each(function(el){
        if (el.checked == true) {
            I = el.id;
        }
        el.onclick = function(){
            I = this.id;
        }
    });
	function count(){
		KeywordCount({
			type: I,
			word: Q.value,
			url: window.location.href,
			key: cache.is("CLICK_BS_BTN")?"B":13
		},"http://www.tjj.com/click.php");
		cache.remove("CLICK_BS_BTN");
	}
	$("#f_btn input").on("click",function(el){
		cache.set("CLICK_BS_BTN",1);
	});
    function gosearch(_this){
		
        if (I == "s0") {
			count();
            _this.submit();
            return;
        }
        else {
            var url;
            switch (I) {
                case "s1":
                    url = "www.google.com.hk/search?client=pub-0194889602661524&channel=3192690043&forid=1&prog=aff&hl=zh-CN&source=sdo_cts_html&q=";
                    break;
                case "s3":
                    $("#taobao-q").el.value = Q.value;
                    if (!cache.get("TAOBAO_PARM")) {
                        var p = {
							pid:'mm_18036115_2311920_9044980',
							commend: "all",
							search_type: "action"
						}
                        for (var i in p) {
                            $("#taobao-form").create("input", {
                                type: "hidden",
                                name: i,
                                value: p[i]
                            }, function(el){
                                this.append(el);
                            })
                        }
                        cache.set("TAOBAO_PARM", true);
                    }
					count();
                    $("#taobao-form").el.submit();
					
                    return;
					break;
                case "s4":
                    url = "115.com/s?q=";
                    break;
				case "s5":
					window.open("http://114la.gouwuke.com/search-" + Q.value+".html?oid=46962&gsid=126762");
					count();
					return;
                    break;
                default:
                    break;
            }
			
            window.open("http://" + url + encodeURIComponent(Q.value));
			count();
        }
    }
    return {
        gosearch: gosearch
    }
})();

//工具轮换tab
$("#tool-tab li").each(function(el){
	HoverTab(el,function(){
		$("#tool-tab li").removeClass("active");
		el.className = "active";
		show(el.getAttribute("rel"));
		
	});
	var show = function(box){
		$(".tbox").hide();
		$("#"+box).show();
	}
});



function KeywordCount(keyword, Counturl){
    if (!keyword || keyword =="") {
        return
    }
    var url = Counturl || "http://www.tjj.com/index";
	
	
    var rd = new Date().getTime()
    var Count = new Image();
    var countVal = "";
	for (var i in keyword) {

			if(i=='u'){
				countVal += ('?'+ i +'=' + encodeURIComponent(keyword[i]));
			}else{
				countVal += ('&' + i +'=' + encodeURIComponent(keyword[i]));
			}
	}
	if(url=="http://www.tjj.com/index"){
		Count.src = url+countVal+'&i='+rd;
	}else{
		Count.src = url + "?i=" + rd + countVal;
	}
}

DOMReady(function(){
	if(Browser.isIE){			  
		
	}
	var setFocus = function(){
		
	}
    $("#f_int input,#q_int input").on("mouseover", function(el){

		if (cache.get(el.id + "GETFOCUS") && el.parentNode.id =="q_int") {
            return;
        }
		if(document.all){
        	Yl.getFocus(el);
		}else{
			el.focus();
		}
    });
/*	$(".tbox .int_b").on('mouseover',function(el){
		el.select();
	});*/
	
    $("#f_int input,#q_int input").on("blur", function(el){
        cache.remove(el.id + "GETFOCUS");
    });

});
var daodao = (function(){
	return {
		searchTravel:function(){
			var _q = document.getElementById("daodao_travel_q").value;
			var _k = document.getElementById("daodao_travel_k").value;
			var _kw = "http://www.daodao.com/Search?m=13078";
			if(_q&&!_k){ _kw += "&q="+encodeURIComponent(_q)}
			else if(!_q&&_k){ _kw += "&q="+ encodeURIComponent(_k)}
			else if(_q&&_k){_kw += "&q="+  encodeURIComponent(_q + "+" +_k)}
			window.open(_kw);
		}
	}
})();

function ResumeError(){
    return true
}
window.onerror = ResumeError;
