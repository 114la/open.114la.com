/**
 * ==========================================
 * Ylmf.cai.js
 * Copyright (c) 2009 wwww.114la.com
 * Author: cia@115.com
 * ==========================================
 */
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
				if(!elArr||elArr==""||elArr=="undefined"){
					//alert("No $!");
					return false;
				}
				if(elArr.length==1){
					this.el = elArr[0];
				}else{
					this.el = elArr;
				}
			}else if(el.nodeType||typeof el == "object"){
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
			}else{
				this.setStyle("display","block");
			}
			return this;
		}).method(REG.hide,function(){
			this.setStyle("display","none");
			return this;
		}).method(REG.toggle,function(){
			this.each(function(el){
				if(el.style.display =="none"){
					el.style.display="block";
				}else{
					el.style.display="none";
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


