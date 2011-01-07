/**
 * ==========================================
 * base.js
 * Copyright (c) 2009 wwww.114la.com
 * Author: cia@115.com
 * ==========================================
 */

var Yl = {
	getHost:function (A) {
    	var _ = A || location.host,
    	$ = _.indexOf(":");
    	return ($ == -1) ? _: _.substring(0, $)
	},
	
	trim: function($) {
		$ = $.replace(/(^\u3000+)|(\u3000+$)/g, "");
		$ = $.replace(/(^ +)|( +$)/g, "");
		return $
	},
	
	encodeText:function($) {
		$ = $.replace(/</g, "&lt;");
		$ = $.replace(/>/g, "&gt;");
		$ = $.replace(/\'/g, "&#39;");
		$ = $.replace(/\"/g, "&#34;");
		$ = $.replace(/\\/g, "&#92;");
		$ = $.replace(/\[/g, "&#91;");
		$ = $.replace(/\]/g, "&#93;");
		return $
	},
	
	decodeHtml:function($) {
		$ = $.replace(/&lt;/g, "<");
		$ = $.replace(/&gt;/g, ">");
		$ = $.replace(/&#39;/g, "'");
		$ = $.replace(/&#34;/g, '"');
		$ = $.replace(/&#92;/g, "\\");
		$ = $.replace(/&#91;/g, "[");
		$ = $.replace(/\&#93;/g, "]");
		return $
	},
	getType:function (o) {
  		var _t; return ((_t = typeof(o)) == "object" ? o==null && "null" || Object.prototype.toString.call(o).slice(8,-1):_t).toLowerCase();
	},
	createFrame:function(o){
		if(!o||!o.src){return}
		var s = o.src,
		w = o.width || "100%",
		h = o.height || "100%",
		Frame = format('<iframe src="#{src}" width="#{width}" height="#{height}" scrolling="no" frameborder="0" allowtransparency="true"></iframe>',{
			src: s,
			width: w,
			height: h
		})
		return Frame;
	},
	loadFrame:function(D){
		if(!D||!D.iframe){return}
		var iframe = D.iframe;
	
		if (D.before && typeof D.before == "function") {
			D.before();
		}
		if (Browser.isIE){ 
			iframe.onreadystatechange = function(){
			
				if (iframe.readyState == "complete"){
					if (D.after && typeof D.after == "function"){
						D.after();
					}
				}
			};
		}else{
			iframe.onload = function(){
				if (D.after && typeof D.after == "function"){
					D.after(this);
				}
			};
		}
	},
	addFav:function (title) {
		var title = title || document.getElementsByTagName("title")[0].innerHTML;
		if( document.all ) {
			window.external.AddFavorite(location.href, title);
		}else if (window.sidebar) {
			window.sidebar.addPanel(title, location.href,"");
		} else if( window.opera && window.print ) {
			return true;
		}
	},
	setHome:function(obj,host){
		if(!host){
			var host = window.location.href;
		}
			obj.style.behavior = 'url(#default#homepage)';
			obj.setHomePage(host);
	}

},
Browser = (function() {
		var H = navigator.userAgent,
		F = 0,
		E = 0,
		I = 0,
		D = 0,
		A = 0,
		_ = 0,
		C = 0,
		B;
		if (H.indexOf("Chrome") > -1 && /Chrome\/(\d+(\.d+)?)/.test(H)) C = RegExp.$1;
		if (H.indexOf("Safari") > -1 && /Version\/(\d+(\.\d+)?)/.test(H)) F = RegExp.$1;
		if (window.opera && /Opera(\s|\/)(\d+(\.\d+)?)/.test(H)) I = RegExp.$2;
		if (H.indexOf("Gecko") > -1 && H.indexOf("KHTML") == -1 && /rv\:(\d+(\.\d+)?)/.test(H)) A = RegExp.$1;
		if (/MSIE (\d+(\.\d+)?)/.test(H)) D = RegExp.$1;
		if (/Firefox(\s|\/)(\d+(\.\d+)?)/.test(H)) _ = RegExp.$2;
		if (H.indexOf("KHTML") > -1 && /AppleWebKit\/([^\s]*)/.test(H)) E = RegExp.$1;
		try {
			B = !!external.max_version
		} catch($) {}
		function G() {
			var _ = false;
			if (navigator.plugins) for (var B = 0; B < navigator.plugins.length; B++) if (navigator.plugins[B].name.toLowerCase().indexOf("shockwave flash") >= 0) _ = true;
			if (!_) {
				try {
					var $ = new ActiveXObject("ShockwaveFlash.ShockwaveFlash");
					if ($) _ = true
				} catch(A) {
					_ = false
				}
			}
			return _
		}
		return ({
			isStrict: document.compatMode == "CSS1Compat",
			isChrome: C,
			isSafari: F,
			isWebkit: E,
			isOpera: I,
			isGecko: A,
			isIE: D,
			isFF: _,
			isMaxthon: B,
			isFlash: G(),
			isCookie: (navigator.cookieEnabled) ? true: false
		})
})(),
userCookie = {
    init: function(domain, path, expdate) {
		
        var d = new Date();
        d.setTime(d.getTime() + (86400 * 1000 * 365));
        this.domain = domain || Yl.getHost();
        this.path = path || "/";
        this.expdate = expdate || d;
        return this
    },
    set: function(name, value, domain) {
		
        var _ = this.expdate,
        domain = domain || this.domain;
        document.cookie = name + "=" + value + ";expires=" + _.toGMTString() + ";path=" + this.path + ";domain=" + domain
    },
    get: function(name) {
        var value = document.cookie.split(";"),
        name = name + "=";
        for (var i = 0, len = value.length; i < len; i++){
			if (value[i].indexOf(name) != "-1"){
				return value[i].replace(name,"");
			}
		}
        return null
    },
    is: function(name) {
        var value = this.get(name);
        return (value != null && value != "") ? true: false;
    },
    remove: function(name, domain) {
        domain = domain || this.domain;
        if (this.is(name)){
			document.cookie = name + "=" + ((this.path) ? "; path=" + this.path: "") + ((this.domain) ? "; domain=" + domain: "") + "; expires=Thu, 01-Jan-70 00:00:01 GMT";
		}
    }
},
XSAjax = (function() {
/*
XSAjax.send({
	url:<string>,
	json:[{p1:value1,p2:value2}],
	before:[fn],
	after:[fn],
	charset:[string]
})					 
*/					 
    function jsontoUrl(_) {
        var $ = [];
        if (!_) return "";
        for (var A in _){ 
			$.push(A + "=" + encodeURIComponent(_[A]));
		}
        return $.join("&")
    }
    function formatUrl(url, p) {
        var ra = "";

        if (!url) return "";
        if (!!p) ra = p + "&";
        //_ += "ra=" + Math.random();
        ra += "ra="+ (new Date()).getTime();
		
		if ( - 1 < url.indexOf("?")) {
			return url + "&" + ra;
		}
		
        return url + "?" + ra
    }
    function createJS(D) {
        if (!D || !D.url){return;}
        if (D.before && typeof D.before == "function") {
			D.before();
		}
        var params = "", JS, URI;
        params = jsontoUrl(D.json);
        URI = formatUrl(D.url, params);
        JS = document.createElement("SCRIPT");
        JS.type = "text/javascript";
        JS.src = URI;
		JS.charset = D.charset||"gb2312";

        if (Browser.isIE){ 
			JS.onreadystatechange = function() {
				if (JS.readyState == "complete" || JS.readyState == "loaded") {
					//document.getElementsByTagName("head")[0].removeChild(JS);
					if (D.after && typeof D.after == "function"){
						
						D.after()
					}
				}
        	};
		}else {
			JS.onload = function() {
            	document.getElementsByTagName("head")[0].removeChild(JS);
            	if (D.after && typeof D.after == "function"){
					D.after()
				}
        	};
		}
        document.getElementsByTagName("head")[0].appendChild(JS)
    }
    function _send(_) {
        window.setTimeout(function() {
            var A = _;
            createJS(A)
        },0)
    }
    return {
        send: _send
    }
})(),
Ajax = function(url, callback) {

		var xhr;
		if(typeof XMLHttpRequest !== 'undefined') xhr = new XMLHttpRequest();
		else {
			var versions = ["Microsoft.XmlHttp", 
			 				"MSXML2.XmlHttp",
			 			    "MSXML2.XmlHttp.3.0", 
			 			    "MSXML2.XmlHttp.4.0",
			 			    "MSXML2.XmlHttp.5.0"];
			 for(var i = 0, len = versions.length; i < len; i++) {
			 	try {
			 		xhr = new ActiveXObject(versions[i]);
			 		break;
			 	}
			 	catch(e){}
			 } // end for
		}
		xhr.onreadystatechange = ensureReadiness;
		function ensureReadiness() {
			if(xhr.readyState < 4) {
				return;
			}
			
			if(xhr.status !== 200) {
				return;
			}
			if(xhr.readyState === 4) {
				callback(xhr);
			}			
		}
		xhr.open('GET', url, true);
		xhr.send('');
	
},
cache = (function() {
    var cacheBox = {};
    function _get(name) {
        if (cacheBox[name]) return cacheBox[name];
        return null
    }
    function _set(name, value, A) {
        if (!A) {cacheBox[name] = value;}
        else {
            if (Yl.getType(cacheBox[name])!="array"){ cacheBox[name] = [];}
            cacheBox[name].push(value)
        }
    }
    function _remove(name) {
        delete cacheBox[name]
    }
    function _is(name) {
        return (_get(name) == null) ? false: true
    }
    return {
        get: _get,
        set: _set,
        is: _is,
        remove: _remove
    }
})(),
format = function(_, B) {
    if (arguments.length > 1) {
        var F = format,
        H = /([.*+?^=!:${}()|[\]\/\\])/g,
        C = (F.left_delimiter || "{").replace(H, "\\$1"),
        A = (F.right_delimiter || "}").replace(H, "\\$1"),
        E = F._r1 || (F._r1 = new RegExp("#" + C + "([^" + C + A + "]+)" + A, "g")),
        G = F._r2 || (F._r2 = new RegExp("#" + C + "(\\d+)" + A, "g"));
        if (typeof(B) == "object") return _.replace(E,
        function(_, A) {
            var $ = B[A];
            if (typeof $ == "function") $ = $(A);
            return typeof($) == "undefined" ? "": $
        });
        else if (typeof(B) != "undefined") {
            var D = Array.prototype.slice.call(arguments, 1),
            $ = D.length;
            return _.replace(G,
            function(A, _) {
                _ = parseInt(_, 10);
                return (_ >= $) ? A: D[_]
            })
        }
    }
    return _
},
SearchEngine =function(searchForm){
	var Box = {
		form:$("#"+searchForm.form).el,
		img:$("#"+searchForm.form+" label a img").el,
		a:$("#"+searchForm.form+" label a").el,
		btn:$("#"+searchForm.smb).el,
		int:$("#"+searchForm.input).el
		
	},
	HiddenParams = [Box.form.tn];
	
	function setForm(searchItem){
		var _ = searchItem.img[0].replace(/\/.*?\.gif$/,"");
		var imgPath = Box.img.src.split(_)[0];

		Box.int.focus();
		Box.form.action = searchItem.action;
		Box.img.src = imgPath+searchItem.img[0];
		Box.img.setAttribute("alt",searchItem.img[1]);
		Box.int.name = searchItem.name;
		Box.btn.value = searchItem.btn; 
		Box.a.href = searchItem.url;		
		
		if (HiddenParams.length != 0){
			HiddenParams = removeParams(HiddenParams);
		}
		for (var item in searchItem.params) {
			$(Box.form).create("input",{
					name:item,
					value:searchItem.params[item],
					type:"hidden"
				},function(el){
					HiddenParams.push(el);
					this.append(el);
			})
		}//创建需要的参数，并保存数组中
		
		function removeParams(inputArr) {
			for (var i = 0, len = inputArr.length; i < len; i++) {
				$(Box.form).remove(inputArr[i]);
			}
        	return []
   		}
	}

	this.Select = function(Item){
		setForm(Item)
	}
	this.input = Box.int;
	
},
/*历史记录*/
UserTrack = (function(){
	var History = userCookie.init();
	function add(o){
		try{
			if(o.tagName.toUpperCase() ==("A") && o.href.indexOf("http://") == 0 && o.href.indexOf("http://" + Yl.getHost())!= 0 ){
				if(o.rel && o.rel=="nr"){
					return false;
				}
				var Track ={
					url: o.href,
					content: o.innerHTML
				},
				data = Track.url+"+"+Track.content+"_114la_",
				oldData = unescape(History.get("history"));
				if(oldData.indexOf(data)>-1){
					oldData = oldData.replace(data,"");
				}
				if(oldData!=="null"){
					data += oldData;
				}
				History.set("history",escape(data));
				
				show();
				
				
			}
			
		}catch(e){}
	
	};
	function show(){
		try {

			var data = unescape(History.get("history")),
			template = '<li><a href="#{url}" title="#{content}" target="_blank">#{content}</a></li>',
			content = "";
			if (data !== "null") {
				var history_arg = data.split("_114la_");
				if(history_arg[1]==""){
					history_arg.splice(1,1);
				
				}

				history_arg.forEach(function(element,index){
					 
					var a = element.split("+");
					if(a!=="" && index<45){
						content += format(template,{
							url:a[0],
							content:a[1]
						
						})
					}
				
				});


				$("#historyBox").el.innerHTML = content;
			} else {
				$("#historyBox").el.innerHTML = '<li class="none">对不起，您没有任何浏览记录</li>';
			}
		} catch(e) {}
	};
	function clear(){
		
		clean = confirm("确定要清除所有的浏览记录？") ;
		if (clean) {
			History.remove("history");
			$("#historyBox").el.innerHTML = '<li class="none">对不起，您没有任何浏览记录</li>';
		}

	}
	return{
		add: add,
		show: show,
		remove: clear
	}
	
})(); 
/*历史记录结束*/

function pngfix(img){
	if(Browser.isIE!=="6.0"){return;}
		var imgStyle = "display:inline-block; " + img.style.cssText;
		var strNewHTML = "<span class=\"" + img.className + "\" title=\"" + img.title + "\" style=\"width:" + img.clientWidth + "px; height:" + img.clientHeight + "px;" + imgStyle + ";" + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + img.src + "', sizingMethod='crop');\"></span>";
		img.outerHTML = strNewHTML;
}//ie6 png

