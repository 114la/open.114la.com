window.undefined = window.undefined;
Ylmf = {
	version : '1.0'
}
Ylmf.apply = function(o, c, defaults){
    // no "this" reference for friendly out of scope calls
    if(defaults){
        Ylmf.apply(o, defaults);
    }
    if(o && c && typeof c == 'object'){
        for(var p in c){
            o[p] = c[p];
        }
    }
    return o;
};
Ylmf.apply(Function.prototype,{
	method:function(name,fn) {
		this.prototype[name]=fn;
		return this;
	},
	createInterceptor : function(fcn, scope){
        var method = this;
        return !Ylmf.isFunction(fcn) ?
                this :
                function() {
                    var me = this,
                        args = arguments;
                    fcn.target = me;
                    fcn.method = method;
                    return (fcn.apply(scope || me || window, args) !== false) ?
                            method.apply(me || window, args) :
                            null;
                };
    },
	createCallback : function(/*args...*/){
        // make args available, in function below
        var args = arguments,
            method = this;
        return function() {
            return method.apply(window, args);
        };
    },
	createDelegate : function(obj, args, appendArgs){
        var method = this;
        return function() {
            var callArgs = args || arguments;
            if (appendArgs === true){
                callArgs = Array.prototype.slice.call(arguments, 0);
                callArgs = callArgs.concat(args);
            }else if (Ylmf.isNumber(appendArgs)){
                callArgs = Array.prototype.slice.call(arguments, 0); // copy arguments first
                var applyArgs = [appendArgs, 0].concat(args); // create method call params
                Array.prototype.splice.apply(callArgs, applyArgs); // splice them in
            }
            return method.apply(obj || window, callArgs);
        };
    },
	defer : function(millis, obj, args, appendArgs){
        var fn = this.createDelegate(obj, args, appendArgs);
        if(millis > 0){
            return setTimeout(fn, millis);
        }
        fn();
        return 0;
    }
});
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
	
var mini=(function(){var b=/(?:[\w\-\\.#]+)+(?:\[\w+?=([\'"])?(?:\\\1|.)+?\1\])?|\*|>/ig,g=/^(?:[\w\-_]+)?\.([\w\-_]+)/,f=/^(?:[\w\-_]+)?#([\w\-_]+)/,j=/^([\w\*\-_]+)/,h=[null,null];function d(o,m){m=m||document;var k=/^[\w\-_#]+$/.test(o);if(!k&&m.querySelectorAll){return c(m.querySelectorAll(o))}if(o.indexOf(",")>-1){var v=o.split(/,/g),t=[],s=0,r=v.length;for(;s<r;++s){t=t.concat(d(v[s],m))}return e(t)}var p=o.match(b),n=p.pop(),l=(n.match(f)||h)[1],u=!l&&(n.match(g)||h)[1],w=!l&&(n.match(j)||h)[1],q;if(u&&!w&&m.getElementsByClassName){q=c(m.getElementsByClassName(u))}else{q=!l&&c(m.getElementsByTagName(w||"*"));if(u){q=i(q,"className",RegExp("(^|\\s)"+u+"(\\s|$)"))}if(l){var x=m.getElementById(l);return x?[x]:[]}}return p[0]&&q[0]?a(p,q):q}function c(o){try{return Array.prototype.slice.call(o)}catch(n){var l=[],m=0,k=o.length;for(;m<k;++m){l[m]=o[m]}return l}}function a(w,p,n){var q=w.pop();if(q===">"){return a(w,p,true)}var s=[],k=-1,l=(q.match(f)||h)[1],t=!l&&(q.match(g)||h)[1],v=!l&&(q.match(j)||h)[1],u=-1,m,x,o;v=v&&v.toLowerCase();while((m=p[++u])){x=m.parentNode;do{o=!v||v==="*"||v===x.nodeName.toLowerCase();o=o&&(!l||x.id===l);o=o&&(!t||RegExp("(^|\\s)"+t+"(\\s|$)").test(x.className));if(n||o){break}}while((x=x.parentNode));if(o){s[++k]=m}}return w[0]&&s[0]?a(w,s):s}var e=(function(){var k=+new Date();var l=(function(){var m=1;return function(p){var o=p[k],n=m++;if(!o){p[k]=n;return true}return false}})();return function(m){var s=m.length,n=[],q=-1,o=0,p;for(;o<s;++o){p=m[o];if(l(p)){n[++q]=p}}k+=1;return n}})();function i(q,k,p){var m=-1,o,n=-1,l=[];while((o=q[++m])){if(p.test(o[k])){l[++n]=o}}return l}return d})();

(function(){
	var toString = Object.prototype.toString,
        ua = navigator.userAgent.toLowerCase(),
        check = function(r){
            return r.test(ua);
        },
        DOC = document,
        isStrict = DOC.compatMode == "CSS1Compat",
        isOpera = check(/opera/),
        isChrome = check(/\bchrome\b/),
        isWebKit = check(/webkit/),
        isSafari = !isChrome && check(/safari/),
        isSafari2 = isSafari && check(/applewebkit\/4/), // unique to Safari 2
        isSafari3 = isSafari && check(/version\/3/),
        isSafari4 = isSafari && check(/version\/4/),
        isIE = !isOpera && check(/msie/),
        isIE7 = isIE && check(/msie 7/),
        isIE8 = isIE && check(/msie 8/),
        isIE6 = isIE && !isIE7 && !isIE8,
        isGecko = !isWebKit && check(/gecko/),
        isGecko2 = isGecko && check(/rv:1\.8/),
        isGecko3 = isGecko && check(/rv:1\.9/),
        isBorderBox = isIE && !isStrict,
        isWindows = check(/windows|win32/),
        isMac = check(/macintosh|mac os x/),
        isAir = check(/adobeair/),
        isLinux = check(/linux/),
        isSecure = /^https/i.test(window.location.protocol);
    // remove css image flicker
    if(isIE6){
        try{
            DOC.execCommand("BackgroundImageCache", false, true);
        }catch(e){}
    }	  
	Ylmf.apply(Ylmf,{
		isStrict : isStrict,
		isOpera : isOpera,
		isChrome : isChrome,
		isWebKit : isWebKit,
		isSafari : isSafari,
		isSafari2 : isSafari2,
		isSafari3 : isSafari3,
		isSafari4 : isSafari4,
		isIE : isIE,
		isIE7 : isIE7,
		isIE8 : isIE8,
		isIE6 : isIE6,
		isGecko : isGecko,
		isGecko3 : isGecko3,
		isGecko3 : isGecko3,
		isBorderBox : isBorderBox,
		isWindows : isWindows,
		isMac : isMac,
		isLinux : isLinux,
		isSecure : isSecure,
		isCookie: (navigator.cookieEnabled) ? true: false,
		isFlash:function(){
			var flash = false;
			if (navigator.plugins){
				for (var B = 0; B < navigator.plugins.length; B++){
					if (navigator.plugins[B].name.toLowerCase().indexOf("shockwave flash") >= 0){
						flash = true;
					}
				}
			}
			if (!flash) {
				try {
					var $ = new ActiveXObject("ShockwaveFlash.ShockwaveFlash");
					if ($) flash = true
				} catch(A) {
					flash = false
				}
			}
			return flash
		},
		
		isEmpty : function(v, allowBlank){
            return v === null || v === undefined || ((Ylmf.isArray(v) && !v.length)) || (!allowBlank ? v === '' : false);
        },
        isArray : function(v){
            return toString.apply(v) === '[object Array]';
        },
        isDate : function(v){
            return toString.apply(v) === '[object Date]';
        },
        isObject : function(v){
            return !!v && Object.prototype.toString.call(v) === '[object Object]';
        },
        isPrimitive : function(v){
            return Ylmf.isString(v) || Ylmf.isNumber(v) || Ylmf.isBoolean(v);
        },
        isFunction : function(v){
            return toString.apply(v) === '[object Function]';
        },
        isNumber : function(v){
            return typeof v === 'number' && isFinite(v);
        },
        isString : function(v){
            return typeof v === 'string';
        },
        isBoolean : function(v){
            return typeof v === 'boolean';
        },
        isElement : function(v) {
            return !!v && v.tagName;
        },
        isDefined : function(v){
            return typeof v !== 'undefined';
        },
		applyIf : function(o, c){
            if(o){
                for(var p in c){
                    if(!Ylmf.isDefined(o[p])){
                        o[p] = c[p];
                    }
                }
            }
            return o;
        },
		toArray : function(){
             return isIE ?
                 function(a, i, j, res){
                     res = [];
                     for(var x = 0, len = a.length; x < len; x++) {
                         res.push(a[x]);
                     }
                     return res.slice(i || 0, j || res.length);
                 } :
                 function(a, i, j){
                     return Array.prototype.slice.call(a, i || 0, j || a.length);
                 }
         }(),
		namespace : function(){
			if(Ylmf.isEmpty(arguments, true)){
                return;
            }
			var o, d,array=Ylmf.toArray(arguments);
			array.forEach(function(v){
				d = v.split(".");
                o = window[d[0]] = window[d[0]] || {};
				d.slice(1).forEach(function(v2){
					o = o[v2] = o[v2] || {};
				});
				
			});
			return o;
        },
		format:function(_, B) {
			if (arguments.length > 1) {
				var F = this.format,
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
		cache : function() {
			var cacheBox = {};
			function _get(name) {
				if (cacheBox[name]) return cacheBox[name];
				return null
			}
			function _set(name, value, A) {
				if (!A) {cacheBox[name] = value;}
				else {
					if(!Ylmf.isArray(cacheBox[name])){ cacheBox[name] = [];}
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
		}(),
		trim: function($) {
			$ = $.replace(/(^\u3000+)|(\u3000+$)/g, "");
			$ = $.replace(/(^ +)|( +$)/g, "");
			return $
		},
		get:function(scope){
			if(Ylmf.isString(scope)){
				var el = mini(scope);
				if(Ylmf.isEmpty(el)) return;
				if(Ylmf.isArray(el)){
					if(el.length==1){
						return el[0];
					}else if(el.length>1){
						return el;
					}
				}
			}else if(Ylmf.isElement(scope)){
				return scope;
			}
			
		}
	});
	Ylmf.ns = Ylmf.namespace;
	Ylmf.register = function(REG){
		var rclass = /[\n\t]/g,
			rspace = /\s+/;
		function __$(el) {
            if ( !Ylmf.isDefined(el)) {
                // do nothing. 'sall good.
            }else{
            	this.el = Ylmf.get(el);
			}
        };
		__$.method(REG.each,function(fn){
			if(Ylmf.isArray(this.el)){
				for(var i= 0,len = this.el.length; i<len; ++i){
					fn.call(this,this.el[i]);
				}
			}else{		
				fn.call(this,this.el);
				
			}
			return this;
		}).method(REG.setStyle,function(prop,value){
			function set(el){
				if (prop == "opacity" && !+"\v1") { //IE7 bug:filter 滤镜要求 hasLayout=true 方可执行（否则没有效果）
					if (!el.currentStyle || !el.currentStyle.hasLayout) el.style.zoom = 1;
					prop = "filter";
					if ( !! window.XDomainRequest) {
						value = "progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=" + value * 100 + ")";
					} else {
						value = "alpha(opacity=" + value * 100 + ")"
					}
				}
				el.style.cssText += ';' + (prop + ":" + value);	
			}
			this.each(function(el){
				set(el);			   	
			});
			return this;
		}).method(REG.getStyle,function(style){
			var el = this.el;
			if (!+"\v1") {
				style = style.replace(/\-(\w)/g,
				function(all, letter) {
					return letter.toUpperCase();
				});
				return el.currentStyle[style];
			} else {
				return document.defaultView.getComputedStyle(el, null).getPropertyValue(style);
			}
			return this;
		}).method(REG.setCSS,function(styles){
			for(var prop in styles){
				if(!styles.hasOwnProperty(prop)) continue;
				this.setStyle(prop,styles[prop]);
			}
            return this;		
		}).method(REG.toggle, function() {
			if ( this.getStyle('display') == 'none' ) {
				this.setStyle('display', '');
			} else {
				this.setStyle('display', 'none');
			}
            return this;
        }).method(REG.show, function() {
            this.setStyle('display','block');
            return this;
        }).method(REG.hide, function() {
            this.setStyle('display', 'none');
            return this;
        }).method(REG.addClass,function(c){
			this.each(function(el){
				el.className = c;
			});
			return this;
		}).method(REG.hasClass,function(selector,fn){
			this.each(function(el){
				var className = " " + selector + " ";
				if ( (" " + el.className + " ").replace(rclass, " ").indexOf( className ) > -1 ) {
					fn.call(this, true);
				}else{
					fn.call(this, false);
				}
			});
			return this;
		}).method(REG.removeClass,function(value){
			if ( (value && typeof value === "string") || value === undefined ) {
				var classNames = (value || "").split(rspace);
				this.each(function(elem){
					if ( elem.nodeType === 1 && elem.className ) {
						if ( value ) {
							var className = (" " + elem.className + " ").replace(rclass, " ");
							for ( var c = 0, cl = classNames.length; c < cl; c++ ) {
								className = className.replace(" " + classNames[c] + " ", " ");
							}
							elem.className = Ylmf.trim( className );
						} else {
							elem.className = "";
						}
					}
				});
			}
			return this;
		}).method(REG.replaceClass,function(oc,nc){
			var that = this;
			this.hasClass(oc,function(b){
				if(b){
					that.removeClass(oc);
				}
				that.addClass(nc);
			});
			return this;
		}).method(REG.on,function(type,fn){
			function run(el){
				if(!el) return;
				if (document.addEventListener) {
/*					if (el.length) {
						for (var i = 0; i < el.length; i++) {
							addEvent(el[i], type, fn);
						}
					} else {*/
						el.addEventListener(type, fn, false);
					//}
				} else {
/*					if (el.length) {
						for (var i = 0; i < el.length; i++) {
							addEvent(el[i], type, fn);
						}
					} else {*/
						el.attachEvent('on' + type,
						function() {
							return fn.call(el, window.event);
						});
					//}
				}
			}
			this.each(function(el){run(el)});
			return this;
		}).method(REG.setContent, function(html) {
            var method = function(el) {
                el.innerHTML = html;
            };
            this.each(function(el){method(el)});
            return this;
        }).method(REG.create, function(el, o, cb) {
            var el = document.createElement(el);
            for ( prop in o ) {
				el.setAttribute(prop, o[prop]);
				//alert(el.hasOwnProperty(id));
/*                if (el.hasOwnProperty(prop)) {
                    el.setAttribute(prop, o[prop]);
                }*/
            }
            if (cb) {
                cb.call(this, el);
            }
            return this;
        }).method(REG.append, function(element) {
			this.each(function(el){
				el.appendChild(element);
			});
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
		
	}
})();
Ylmf.register({
	namespace : '$',
	each : 'each',
	hide : 'hide',
	show : 'show',
	toggle : 'toggle',
	setStyle : 'setStyle',
	getStyle : 'getStyle',
	setCSS : 'setCSS',
	addClass : 'addClass',
	hasClass : 'hasClass',
	removeClass :'removeClass',
	replaceClass : 'replaceClass',
	on : 'on',
	setContent : 'setContent',
	create : 'create',
	append : 'append',
	remove : 'remove'
});
Ylmf.ns("Ylmf.util","Ylmf.lib");


