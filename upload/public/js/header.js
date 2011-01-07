var mini=(function(){var b=/(?:[\w\-\\.#]+)+(?:\[\w+?=([\'"])?(?:\\\1|.)+?\1\])?|\*|>/ig,g=/^(?:[\w\-_]+)?\.([\w\-_]+)/,f=/^(?:[\w\-_]+)?#([\w\-_]+)/,j=/^([\w\*\-_]+)/,h=[null,null];function d(o,m){m=m||document;var k=/^[\w\-_#]+$/.test(o);if(!k&&m.querySelectorAll){return c(m.querySelectorAll(o))}if(o.indexOf(",")>-1){var v=o.split(/,/g),t=[],s=0,r=v.length;for(;s<r;++s){t=t.concat(d(v[s],m))}return e(t)}var p=o.match(b),n=p.pop(),l=(n.match(f)||h)[1],u=!l&&(n.match(g)||h)[1],w=!l&&(n.match(j)||h)[1],q;if(u&&!w&&m.getElementsByClassName){q=c(m.getElementsByClassName(u))}else{q=!l&&c(m.getElementsByTagName(w||"*"));if(u){q=i(q,"className",RegExp("(^|\\s)"+u+"(\\s|$)"))}if(l){var x=m.getElementById(l);return x?[x]:[]}}return p[0]&&q[0]?a(p,q):q}function c(o){try{return Array.prototype.slice.call(o)}catch(n){var l=[],m=0,k=o.length;for(;m<k;++m){l[m]=o[m]}return l}}function a(w,p,n){var q=w.pop();if(q===">"){return a(w,p,true)}var s=[],k=-1,l=(q.match(f)||h)[1],t=!l&&(q.match(g)||h)[1],v=!l&&(q.match(j)||h)[1],u=-1,m,x,o;v=v&&v.toLowerCase();while((m=p[++u])){x=m.parentNode;do{o=!v||v==="*"||v===x.nodeName.toLowerCase();o=o&&(!l||x.id===l);o=o&&(!t||RegExp("(^|\\s)"+t+"(\\s|$)").test(x.className));if(n||o){break}}while((x=x.parentNode));if(o){s[++k]=m}}return w[0]&&s[0]?a(w,s):s}var e=(function(){var k=+new Date();var l=(function(){var m=1;return function(p){var o=p[k],n=m++;if(!o){p[k]=n;return true}return false}})();return function(m){var s=m.length,n=[],q=-1,o=0,p;for(;o<s;++o){p=m[o];if(l(p)){n[++q]=p}}k+=1;return n}})();function i(q,k,p){var m=-1,o,n=-1,l=[];while((o=q[++m])){if(p.test(o[k])){l[++n]=o}}return l}return d})();

if ( typeof Ylmf == 'undefined' ) {
    var Ylmf = {};
}

Function.prototype.method = function(name,fn) {
    this.prototype[name]=fn;
    return this;
};
if (!Array.prototype.forEach) {
    Array.method('forEach',
    function(fn, thisObj) {
        var scope = thisObj || window;
        for (var i = 0,
        j = this.length; i < j; ++i) {
            fn.call(scope, this[i], i, this);
        }
    }).method('every',
    function(fn, thisObj) {
        var scope = thisObj || window;
        for (var i = 0,
        j = this.length; i < j; ++i) {
            if (!fn.call(scope, this[i], i, this)) {
                return false;
            }
        }
        return true;
    }).method('some',
    function(fn, thisObj) {
        var scope = thisObj || window;
        for (var i = 0,
        j = this.length; i < j; ++i) {
            if (fn.call(scope, this[i], i, this)) {
                return true;
            }
        }
        return false;
    }).method('map',
    function(fn, thisObj) {
        var scope = thisObj || window;
        var a = [];
        for (var i = 0,
        j = this.length; i < j; ++i) {
            a.push(fn.call(scope, this[i], i, this));
        }
        return a;
    }).method('filter',
    function(fn, thisObj) {
        var scope = thisObj || window;
        var a = [];
        for (var i = 0,
        j = this.length; i < j; ++i) {
            if (!fn.call(scope, this[i], i, this)) {
                continue;
            }
            a.push(this[i]);
        }
        return a;
    }).method('indexOf',
    function(el, start) {
        var start = start || 0;
        for (var i = start,
        j = this.length; i < j; ++i) {
            if (this[i] === el) {
                return i;
            }
        }
        return - 1;
    }).method('lastIndexOf',
    function(el, start) {
        var start = start || this.length;
        if (start >= this.length) {
            start = this.length;
        }
        if (start < 0) {
            start = this.length + start;
        }
        for (var i = start; i >= 0; --i) {
            if (this[i] === el) {
                return i;
            }
        }
        return - 1;
    });
}

(function() {
    Ylmf.register = function(REG) {
		function __$(el){
			
			if(typeof el=="string"){
				var elArr =  mini(el);
				
				if(!elArr||elArr=="" || typeof(elArr) == "undefined"=="undefined"){
					//alert("No $!");
					return false;
				}
				
				
				if(elArr.length==1){
					this.el = elArr[0];
				}else if(elArr.length>1){
					this.el = elArr;
				}
			}else if(el.nodeType ==1){
				this.el = el;
			}
			 
		};
        __$.method(REG.each,function(fn){
			if(!this.el){
			//	fn.call(this,false);
				return
			}						 
			if(!this.el.length){
				fn.call(this,this.el);
			}else{			 
				for(var i= 0,len = this.el.length; i<len; ++i){
					fn.call(this,this.el[i]);
				}
			}
			return this;
		}).method(REG.hasClass, function(c,fn){	
			this.each(function(el){
				var col = el.className.split(/\s+/).toString();
				var result = (col.indexOf(c)>-1)?true:false;
				(function(){
					fn(result);	  
				})();
			});
			return this;
		}).method(REG.addClass, function(classNames){	
			this.each(function(el){
				var col = (classNames || "").split(/\s+/);
				for(var i = 0; i < col.length; i++){
					var item = col[i];
					this.hasClass(el,function(b){
						if(!b){
							el.className += (el.className ? " " : "") + item;
						}
					
					})
				}

			});
			return this;
		}).method(REG.removeClass, function(c){	
			this.each(function(el){
				if(c != undefined){
					var col = el.className.split(/\s+/);
					var hasCol = [];
					for(var i =0,len = col.length;i<len;++i){
						var item = col[i];
						
						if(item!=c){
							hasCol.push(item);
						}					
						
					}
					
					el.className = hasCol.join(" ");
				}else{
					el.className = "";
				}

	
			});
			return this;
		}).method(REG.replaceClass, function(oc,nc){
	
			this.removeClass(oc);
			this.addClass(nc);
			return this;
		}).method(REG.setStyle, function(prop,val){	
			this.each(function(el){
				el.style[prop] = val;
			});
			return this;
		}).method(REG.setCSS, function(styles) {
            for(var prop in styles){
				if(!styles.hasOwnProperty(prop)) continue;
				this.setStyle(prop,styles[prop]);
			}
            return this;
			
        }).method(REG.getStyle,function(prop,fn){
				var currentStyle = null;
			
				if(document.defaultView){// firefox,opera,safari
					currentStyle =  document.defaultView.getComputedStyle(this.el,null).getPropertyValue(prop);
				} else {//ie
					prop=prop.replace(/\-([a-z])([a-z]?)/ig,function(prop,a,b){return a.toUpperCase()+b.toLowerCase();});//转化为驼峰写法
					currentStyle =  this.el["currentStyle"][prop];
				}
				fn.call(this,currentStyle);
			
			return this;
		}).method(REG.show,function(n){
			if(n==0){
				this.setStyle("display","");
			}else if(n==1){
				this.setStyle("display","");
			}else{
				this.setStyle("display","block");
			}
			return this;
		}).method(REG.hide,function(){
			this.setStyle("display","none");
			return this;
		}).method(REG.toggle,function(t){
			this.each(function(el){
				if(el.style.display =="none"){
					if(t){
						t==1?el.style.display= "inline":el.style.display= ""
					}else{
						el.style.display= "block";
					}
					
				}else{
					el.style.display="block";
				}
			});
			return this;
		}).method(REG.on,function(type,fn){

			var add = function(el){
				var f = function(){

					fn(el)
				};
				if(window.addEventListener){
					el.addEventListener(type,f,false);
				}else if(window.attachEvent){
					el.attachEvent('on'+type,f);
				}	
			}
			if(!this.el){
				return;
			}
			
			if(this.el.length==0){
				add(this.el);
			}else{
				this.each(function(el){
					add(el);
				});
			}
			return this;
		}).method(REG.getRect,function(fn){
			var oRect = this.el.getBoundingClientRect();
			
			fn.call(this,oRect)
			
			return this;
		}).method(REG.create,function(el,o,cb){
			var el = document.createElement(el);
            for ( prop in o ) {
                el.setAttribute(prop, o[prop]);
            }
            if (cb) {
                cb.call(this, el);
            }
			
			return this;
		}).method(REG.append,function(element){
			this.el.appendChild(element);
			return this;
		}).method(REG.remove,function(element){
			if(element){
				this.el.removeChild(element);
			}
			return this;
		});
        
        window[REG.namespace] = function(el) {
            return new __$(el);
        };
        // sugar array shortcuts
        window[REG.namespace].forEach = Array.prototype.forEach;
        window[REG.namespace].every = Array.prototype.every;
        window[REG.namespace].some = Array.prototype.some;
        window[REG.namespace].map = Array.prototype.map;
        window[REG.namespace].filter = Array.prototype.filter;
				
        Ylmf.extendChain = function(name, fn) {
            __$.method(name, fn);
        };
		
		
    };
})();

Ylmf.register({
    namespace : '$',
	each:'each',
	addClass:'addClass',
	hasClass:'hasClass',
	removeClass:'removeClass',
	replaceClass:'replaceClass',
	setStyle:'setStyle',
	getStyle:'getStyle',
	setCSS:'setCSS',
	show:'show',
	hide:'hide',
	toggle:'toggle',
	on:'on',
	getRect:'getRect',
	append:'append',
	create:'create',
	remove:'remove'
});
var Yl = {
	getHost:function (A) {
    	var _ = A || location.host,
    	$ = _.indexOf(":");
    	return ($ == -1) ? _: _.substring(0, $)
	},
	getFocus :function(el){
		var txt =el.createTextRange();      
		txt.moveStart('character',el.value.length);      
		txt.collapse(true);      
		txt.select();
	},
	loadFrame:function(iframe,callback){
		if (Browser.isIE){  //ie
			iframe.onreadystatechange = function(){
				callback();
			};
		}else{ //w3c
			iframe.onload = function(){
				callback();
			};
		}
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
	getType:function (o) {
  		var _t; return ((_t = typeof(o)) == "object" ? o==null && "null" || Object.prototype.toString.call(o).slice(8,-1):_t).toLowerCase();
	},
	
	setStyle:function(A, $) {
		var _ = document.styleSheets[0];
		if (_.addRule) {
			A = A.split(",");
			for (var C = 0,
			B = A.length; C < B; C++) _.addRule(A[C], $)
		} else if (_.insertRule) _.insertRule(A + " { " + $ + " }", _.cssRules.length)
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
	setHome:function(obj,hostname){
		if(!Browser.isIE){
			alert("您的浏览器不支持自动设置主页，请使用浏览器菜单手动设置。")
			return;
		}
		var host = hostname;
		if(!host){
			host = window.location.href;
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
Cookie = {
	set:function(name,value,expires,path,domain){
		if(typeof expires=="undefined"){
			expires=new Date(new Date().getTime()+1000*3600*24*365);
		}
		
		document.cookie=name+"="+escape(value)+((expires)?"; expires="+expires.toGMTString():"")+((path)?"; path="+path:"; path=/")+((domain)?";domain="+domain:"");
		
	},
	get:function(name){
		var arr=document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
		if(arr!=null){
			return unescape(arr[2]);
		}
		return null;
	},
	clear:function(name,path,domain){
		if(this.get(name)){
		document.cookie=name+"="+((path)?"; path="+path:"; path=/")+((domain)?"; domain="+domain:"")+";expires=Fri, 02-Jan-1970 00:00:00 GMT";
		}
	}
}
,
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
},ScriptLoader = {
    Loading: false,
    TaskQueue: [],
    CallBack: function(StartTime, CallBackMethod) {
        CallBackMethod && CallBackMethod(new Date().valueOf() - StartTime.valueOf());
        this.Loading = false;
        this.Load();
    },
    Load: function() {
        if (!this.Loading && this.TaskQueue.length) {
            var Head = document.getElementsByTagName("head")[0];
            if (!Head) {
                this.TaskQueue.length = 0;
                this.TaskQueue = null;
                throw new Error('The head does not exist in this page.');
            }
            var DLSQ = this,
            TaskQueue = this.TaskQueue.shift(),
            StartTime = new Date,
            Script = document.createElement('script');
            this.Loading = true;
            Script.onload = Script.onreadystatechange = function() {
                if (Script && Script.readyState && Script.readyState != 'loaded' && Script.readyState != 'complete') return;
                Script.onload = Script.onreadystatechange = Script.onerror = null;
                Script.Src = '';
                Script.parentNode.removeChild(Script);
                Script = null;
                DLSQ.CallBack(StartTime, TaskQueue.CallBackMethod);
                StartTime = TaskQueue = null;
            };
            Script.charset = TaskQueue.Charset || 'gb2312';
            Script.src = TaskQueue.Src;
			//console.log(Script.src);
            //Head.appendChild(Script);
			Head.insertBefore(Script, Head.firstChild);
        }
    },
    Add: function(config) {
        if (!config || !config.src) return;
        this.TaskQueue.push({
            'Src': config.src,
            'Charset': config.charset || "gb2312",
            'CallBackMethod': config.callback
        });
        this.Load();
    }
}

function DOMReady(f){
  if (/(?!.*?compatible|.*?webkit)^mozilla|opera/i.test(navigator.userAgent)){ // Feeling dirty yet?
    document.addEventListener("DOMContentLoaded", f, false);
  }  else {
    window.setTimeout(f,0);
  }
}

var skinSelector = (function(){
	var config = {style:"",	sidebar:"",font:"",bg:""};
	
	
	var _createCss = function (css,cssid){
		if(document.getElementById(cssid)){
			$("#"+cssid).el.href = css;
			return;
		}
		$("head").create("link",{id:cssid,href:css,rel:"stylesheet",type:"text/css"},function(el){
			this.append(el);
		});
	}
	var display = function(){
		for(var i in config){
			if(config[i]){
				_set(i,config[i]);
			}
		}
	}
	function _set(i,val){
		switch(i){
			case 'style':
				var skins = ["blue","green","pink","orange"],
				css = '';
				if(val<1){
					_createCss('',"style");
					Cookie.clear("style");
				}else{
					css = '/public/page/style/'+skins[val]+"/style.css";
					_createCss(css,"style");
				}
				break;
			case 'sidebar':
				var c = ["left","right"];
				var html = document.getElementsByTagName("html")[0];
				if(val>0){
					html.className = c[val];
				}else{
					html.className ='';
					Cookie.clear("sidebar");
				}
			
				break;
			case 'font':
				var css = "/public/css/font/"+Yl.trim(val)+".css";
				if(Yl.trim(val)=="default"){
					Cookie.clear("font");
					_createCss("","font");
				}else{
					_createCss(css,"font");
				}
				break;
			case 'bg':
				var img = "/public/images/bg/"+Yl.trim(val);
				var styleEl = $("#temp-css").el;
				var csscode ='';
				if(Yl.trim(val)!=="default"){
					csscode = 'body {background:url('+img+')}'
				}else{
					csscode = '';
					Cookie.clear("bg");
				}
				if (styleEl.styleSheet) { // IE
				   styleEl.styleSheet.cssText = csscode;
				} else { // W3C
				   styleEl.innerHTML = csscode;
				}
				break;
		}
	}
	
	var init = function(){
		for(var i in config){
			if(Cookie.get(i)){
				config[i] = Cookie.get(i);
			}
		}
		display();
	}

	return{
		set:_set,
		init:init
	}
})();

skinSelector.init();



if(Browser.isIE=='6.0'){
	document.execCommand("BackgroundImageCache", false, true);
}

var Calendar = (function(){
    /*农历日历*/
    var lunarInfo = [0x04bd8,0x04ae0,0x0a570,0x054d5,0x0d260,0x0d950,0x16554,0x056a0,0x09ad0,0x055d2,0x04ae0,0x0a5b6,0x0a4d0,0x0d250,0x1d255,0x0b540,0x0d6a0,0x0ada2,0x095b0,0x14977,0x04970,0x0a4b0,0x0b4b5,0x06a50,0x06d40,0x1ab54,0x02b60,0x09570,0x052f2,0x04970,0x06566,0x0d4a0,0x0ea50,0x06e95,0x05ad0,0x02b60,0x186e3,0x092e0,0x1c8d7,0x0c950,0x0d4a0,0x1d8a6,0x0b550,0x056a0,0x1a5b4,0x025d0,0x092d0,0x0d2b2,0x0a950,0x0b557,0x06ca0,0x0b550,0x15355,0x04da0,0x0a5b0,0x14573,0x052b0,0x0a9a8,0x0e950,0x06aa0,0x0aea6,0x0ab50,0x04b60,0x0aae4,0x0a570,0x05260,0x0f263,0x0d950,0x05b57,0x056a0,0x096d0,0x04dd5,0x04ad0,0x0a4d0,0x0d4d4,0x0d250,0x0d558,0x0b540,0x0b6a0,0x195a6,0x095b0,0x049b0,0x0a974,0x0a4b0,0x0b27a,0x06a50,0x06d40,0x0af46,0x0ab60,0x09570,0x04af5,0x04970,0x064b0,0x074a3,0x0ea50,0x06b58,0x055c0,0x0ab60,0x096d5,0x092e0,0x0c960,0x0d954,0x0d4a0,0x0da50,0x07552,0x056a0,0x0abb7,0x025d0,0x092d0,0x0cab5,0x0a950,0x0b4a0,0x0baa4,0x0ad50,0x055d9,0x04ba0,0x0a5b0,0x15176,0x052b0,0x0a930,0x07954,0x06aa0,0x0ad50,0x05b52,0x04b60,0x0a6e6,0x0a4e0,0x0d260,0x0ea65,0x0d530,0x05aa0,0x076a3,0x096d0,0x04bd7,0x04ad0,0x0a4d0,0x1d0b6,0x0d250,0x0d520,0x0dd45,0x0b5a0,0x056d0,0x055b2,0x049b0,0x0a577,0x0a4b0,0x0aa50,0x1b255,0x06d20,0x0ada0,0x14b63];
    var Gan = new Array("甲", "乙", "丙", "丁", "戊", "己", "庚", "辛", "壬", "癸");
    var Zhi = new Array("子", "丑", "寅", "卯", "辰", "巳", "午", "未", "申", "酉", "戌", "亥");
    var now = new Date();
    var SY = now.getFullYear();
    var SM = now.getMonth();
    var SD = now.getDate();
    function cyclical(num){
        return (Gan[num % 10] + Zhi[num % 12])
    }
    function lYearDays(y){
        var i, sum = 348;
        for (i = 0x8000; i > 0x8; i >>= 1) 
            sum += (lunarInfo[y - 1900] & i) ? 1 : 0;
        return (sum + leapDays(y))
    }
    function leapDays(y){
        if (leapMonth(y)) 
            return ((lunarInfo[y - 1900] & 0x10000) ? 30 : 29);
        else 
            return (0)
    }
    function leapMonth(y){
        return (lunarInfo[y - 1900] & 0xf)
    }
    function monthDays(y, m){
        return (lunarInfo[y - 1900] & (0x10000 >> m)) ? 30 : 29
    }
    function Lunar(objDate){
        var i, leap = 0, temp = 0;
        var baseDate = new Date(1900, 0, 31);
        var offset = (objDate - baseDate) / 86400000;
        this.dayCyl = offset + 40;
        this.monCyl = 14;
        for (i = 1900; i < 2050 && offset > 0; i++) {
            temp = lYearDays(i);
            offset -= temp;
            this.monCyl += 12
        }
        if (offset < 0) {
            offset += temp;
            i--;
            this.monCyl -= 12
        }
        this.year = i;
        this.yearCyl = i - 1864;
        leap = leapMonth(i);
        this.isLeap = false;
        for (i = 1; i < 13 && offset > 0; i++) {
            if (leap > 0 && i == (leap + 1) && this.isLeap == false) {
                --i;
                this.isLeap = true;
                temp = leapDays(this.year)
            }
            else {
                temp = monthDays(this.year, i)
            }
            if (this.isLeap == true && i == (leap + 1)) {
                this.isLeap = false
            }
            offset -= temp;
            if (this.isLeap == false) {
                this.monCyl++
            }
        }
        if (offset == 0 && leap > 0 && i == leap + 1) {
            if (this.isLeap) {
                this.isLeap = false
            }
            else {
                this.isLeap = true;
                --i;
                --this.monCyl
            }
        }
        if (offset < 0) {
            offset += temp;
            --i;
            --this.monCyl
        }
        this.month = i;
        this.day = offset + 1
    }
    
    function cDay(m, d){
        var nStr1 = new Array('日', '一', '二', '三', '四', '五', '六', '七', '八', '九', '十');
        var nStr2 = new Array('初', '十', '廿', '卅', '　');
        var s;
        if (m > 10) {
            s = '十' + nStr1[m - 10]
        }
        else {
            s = nStr1[m]
        }
		if(s=='一'){
			s='正';
		}
        s += '月';
        switch (d) {
            case 10:
                s += '初十';
                break;
            case 20:
                s += '二十';
                break;
            case 30:
                s += '三十';
                break;
            default:
                s += nStr2[Math.floor(d / 10)];
                s += nStr1[d % 10]
        }
        return (s)
    }
    
    function solarDay2(){
        var lDObj = new Lunar(new Date(SY, SM, SD));
        var tt = cDay(lDObj.month, lDObj.day);
        return (tt)
    }
    function showToday(){
        var weekStr = "日一二三四五六";
        var template = '<a href="http://tool.115.com/live/calendar/" rel="nr" title="点击查看万年历">#{YY}年#{MM}月#{DD}日 星期#{week} </a>';
        var day = format(template, {
            YY: SY,
            MM: SM + 1,
            DD: SD,
            week: weekStr.charAt(now.getDay())
        
        });
        return day;
    }
	
	function showdate(){
		SD = SD+1;
		var m = SM<9?('0'+(SM+1)):SM+1;
		var d = SD+1<10?('0'+SD):SD;
		return (SY+'-'+m+'-'+d);
	}
	function cncal(){
		var cacal = '<a href="http://tool.115.com/live/calendar/" rel="nr" title="点击查看万年历">农历 '+ solarDay2() +'</a>';
		return cacal;
	}
    
    return {
        day: showToday,
		cnday :cncal,
		date:showdate
    }
    
})();