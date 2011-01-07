(function(){
	var url = 'http://www.114la.com/static/js/keyword.js?'+new Date().getTime();
	ScriptLoader.Add({src:url,callback:function(){
			$("#sw_web").show();
		}
	});
})();

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


var SE = (function(){
    var HiddenParams = [$("#searchForm").el.tn, $("#searchForm").el.ch];
    $("#sf .int").el.focus();
    function setForm(searchItem){
        $("#searchForm").el.action = searchItem.action;
        $("#sf_label img").el.src = searchItem.img[0];
        $("#sf_label img").el.setAttribute("alt", searchItem.img[1]);
        $("#sf .int").el.name = searchItem.name;
        $("#sf .searchint").el.value = searchItem.btn;
        $("#sf_label").el.href = searchItem.url;
		
		if (HiddenParams.length > 0) {
            HiddenParams = removeParams(HiddenParams);
        }
		function removeParams(inputArr){
            for (var i = 0, len = inputArr.length; i < len; i++) {
                $("#searchForm").remove(inputArr[i]);
            }
            return [];
        }
		for (var item in searchItem.params) {
            $("#searchForm").create("input", {
                name: item,
                value: searchItem.params[item],
                type: "hidden"
            }, function(el){
                HiddenParams.push(el);
                this.append(el);
            })
        }//创建需要的参数，并保存数组中
        
    }
    
    $("#sf .int").on("mouseover", function(el){
        if (cache.get("SE_ONFOCUS")) {
            return;
        }
        el.value = el.value;
        el.focus();
    });
    $("#mail_passwd_114la,#sf .int").on("blur", function(el){
        cache.remove("SE_ONFOCUS");
    })
    
    $("#sf .int").on("focus", function(el){
        cache.set("SE_ONFOCUS", true);
        if(Browser.isIE){
			Yl.getFocus(el);
		}else{
			el.focus();
		}
		
    });
    
    return {
        set: setForm
    };
})();//搜索切换

//搜索TAB菜单开始
$("#sm_tab li").on("click", function(el){
       $("#sf .int").el.focus();
        $("#sm_tab li").removeClass("active");
        $(el).addClass("active");
        
		var rel = el.getAttribute("rel");
/*		if(rel=='s115' || rel=='v115'){
			document.charset='utf-8';
			$("#searchForm").el.setAttribute('accept-charset','utf-8');
		}else{
			document.charset='gb2312';
			$("#searchForm").el.setAttribute('accept-charset','');
		}*/
		KeywordCount({
			u: rel,
			n: rel,
			q: 0
		});
        cache.set("CURRENT_SE_TAB", rel);
        SE.set(Config.Search[rel]);
        if (Browser.isIE) {
            $("#sf .int").el.value = $("#sf .int").el.value;
        }
		
        $("#sw p").hide();
		
        $("p#sw_" + rel).show();
    return false;
});//搜索TAB菜单结束


var Suggest = (function(){
    var K = $("#sf .int"), S = $("#suggest"), Query,//输入值
 currentKey = -1, dataScript = null,//数据脚本
 dataResult,//结果数据
 KeywordItems, //li
 mouseSelect = false, stopRequest = false, Hidestate = false, isClose = false;
 
 
	
    K.el.onkeydown = function(e){
        var e = e || window.event;
        if (isClose) {
            return;
        }
        
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
				cache.set("Handdle_Key","13");
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
				cache.set("Handdle_Key","13");
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
        K.el.value = KeywordItems[currentKey].innerHTML;
    }
    
    function showSuggest(){
        if (typeof(dataResult) != "object" || typeof(dataResult) == "undefined") 
            return;
        var html = '<ul>';
        dataResult.forEach(function(el, index, arr){
            if (cache.get("CURRENT_SE_TAB") == "taobao") {
                html += '<li key="' + index + '">' + el[0] + '</li>';
            }
            else {
                html += '<li key="' + index + '">' + el + '</li>';
            }
        });
       html += '</ul><div class="close"><a id="closeSugBtn">关闭</a></div>';
	    //html += '</ul>';
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
        K.el.setAttribute("autocomplete", "on");
        K.el.focus();
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
                K.el.value = target.innerHTML;
                K.el.focus();
                hideSuggest();
               var SF =  document.getElementById("searchForm");
			   cache.set("Handdle_Key","S");
			   //SF.onsubmit();
			   SF.submit();
            }
            if (target.id == "closeSugBtn") {
                closeSuggest();
            }
            
        }
    }
	
	$("#searchForm").el.onsubmit = function(){
/*		if(K.el.value==""){
			return false;
		}*/
		KeywordCount({
			type: cache.get("CURRENT_SE_TAB") ? cache.get("CURRENT_SE_TAB") : "web",
			word: K.el.value,
			url: window.location.href,
			key: cache.get("Handdle_Key")
		}, "http://www.tjj.com/click.php");
		var Keys = Config.Keywords;
		var isMatch = false;
		Keys.forEach(function(el){
			if(K.el.value==el[0]){
				window.open(el[1]);
				isMatch = true;
			}
		});
		if(isMatch){return false;}
	};
	$("#search_btn").on("click",function(){
		cache.set("Handdle_Key","B");		
	});
    
    function requestData(){
        var head = $("head").el;
        var TAB = cache.get("CURRENT_SE_TAB");
        if (dataScript) {
            if (TAB == "taobao") {
                dataScript.charset = "utf-8";
            }
            else {
                dataScript.charset = "gb2312";
            }
        }
        if (!Browser.isIE) {
            if (dataScript) {
                head.removeChild(dataScript);
            }
            dataScript = null;
        } // IE不需要重新创建script元素
        if (!dataScript) {
            var script = document.createElement("script");
            script.type = "text/javascript";
            if (TAB == "taobao") {
                script.charset = "utf-8";
            }
            else {
                script.charset = "gb2312";
            }
            head.insertBefore(script, head.firstChild);
            dataScript = script;
        }
        var rd = new Date().getTime();
        var key = encodeURIComponent(K.el.value);
        
        var Url = "http://suggestion.baidu.com/su?wd=" + key + "&sc=114la&rd=" + rd;
        switch (TAB) {
            case "mp3":
                Url = "http://nssug.baidu.com/su?wd=" + key + "&prod=mp3&sc=114la&rd=" + rd;
                break;
            case "image":
                Url = "http://nssug.baidu.com/su?wd=" + key + "&prod=image&fm=114la&rd=" + rd;
                break;
            case "v115":
                Url = "http://nssug.baidu.com/su?wd=" + key + "&prod=video&sc=114la&rd=" + rd;
                break;
            case "zhidao":
                Url = "http://nssug.baidu.com/su?wd=" + key + "&prod=zhidao&sc=114la&rd=" + rd;
                break;
            case "web":
                Url = "http://suggestion.baidu.com/su?wd=" + key + "&sc=114la&rd=" + rd;
                break;
            case "taobao":
                Url = "http://suggest.taobao.com/sug?code=utf-8&callback=TB.Suggest.callback&q=" + key + "&rd=" + rd
                break;
        }
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
    window.TB = {};
    window.TB.Suggest = {};
    window.TB.Suggest.callback = function(O){
        if (typeof(O) == "object" && typeof(O.result) != "undefined" && typeof(O.result[0][0]) != "undefined") {
            dataResult = O.result;
            showSuggest();
        }
        else {
            hideSuggest();
        }
    }
})();//搜索自动完成

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
					var newHtml = '<iframe width="100%" height="216" frameborder="0" scrolling="no" allowtransparency="true" src="'+url+'"></iframe>';
					newNode.innerHTML=newHtml;
					$("#bb").el.insertBefore(newNode,$("#bb").el.firstChild);
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


DOMReady(function(){
	if(Browser.isIE){			  
		$("#sf .int").el.value = '';			  
	}
});
$("#skinlist a").on('click',function(el){
	var num = parseInt(el.innerHTML)-1;
	Cookie.set("style",num);
	skinSelector.set("style",num);	
});//皮肤设置

$(".tg-ms").on('click',function(el){
	if($("#ms").el.style.display == 'none'){
		$("#ms").show();
	}else{
		$("#ms").hide();	
	}
});//更多菜单

$("#showSetting").on('click',function(el){
	el.blur();
	if($('#settingBox').el){
		$('#settingBox').show();
		return;
	}
	$("#wrap").create('div',{id:'settingBox'},function(el){
		var html = Yl.createFrame({
			src: '/public/widget/setting/page.html',
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
});//个性设置

document.onclick = function(e){
    var e = e || window.event, obj = e.srcElement || e.target, tid = obj.id;
	
	if (tid != "ms-button") {
        $("#ms").hide();
    }
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
				Cookie.set("history",data,null,null,'114la.com');
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

function ResumeError(){
    return true
}
window.onerror = ResumeError;
