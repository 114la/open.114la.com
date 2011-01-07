var  Cookie = {
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
},$ = parent.$,Yl = parent.Yl;
var Doc = window.parent.document;
var $$ = function(id){ return document.getElementById(id);}
var Skin = (function(){
	var config = {style:"",	sidebar:"",font:"",bg:"",layout:''};
	function _setClass(str,index){
		var items = $$(str+"-setting").getElementsByTagName("a");
		for(var i =0,len =items.length;i<len; i++){
			items[i].className = items[i].className.replace("2","");
		}
		items[index].className = items[index].className+'2';
	} 
	function setActive(i,val){
		if(!val){
			val = 0;
		}
		switch(i){
			case 'style':
				_setClass(i,val);
				break;
			case 'sidebar':
				var c = ["left","right"];
				$$('sidebar-setting').className = c[val];
				break;
			case 'font':
				var num = {
					'default':0,	
					'blue':1,
					'green':2,
					'pink':3,
					'red':4,
					'gray':5					
				}
				_setClass(i,num[val]);
				break;
			case 'bg':
				var items = $$("bg-item").getElementsByTagName("a");
				for(var i =0,len =items.length;i<len; i++){
					items[i].style.borderColor = "#ccc";
				}
				items[val=='default'?0:val.split(".")[0]].style.borderColor = "#f00";
				break;
			case 'layout':
				_setClass(i,val);
				break;
		}
	}
	var display = function(){
		for(var i in config){
			if(config[i]){
				set(i,config[i]);
				setActive(i,config[i]);
			}
		}
		function set(i,value){
			
			switch(i){
				case "style":
					if(Number(value) ==0){
						_createCss("",i);
						Cookie.clear(i);
						return;
					}
					var skins = ["blue","green","pink","orange"],
					css = '/public/page/style/'+skins[Number(value)]+"/style.css";
					_createCss(css,i);
					break;
				case "font":
					var css = "/public/css/font/"+Yl.trim(value)+".css";
					if(Yl.trim(value)=="default"){
						Cookie.clear("font");
						_createCss("","font");
					}else{
						_createCss(css,"font");
					}
					break;
				case "sidebar":
					var c = ["left","right"];
					var html = Doc.getElementsByTagName("html")[0];
					if(value>0){
						html.className = c[value];
					}else{
						html.className ='';
						Cookie.clear("sidebar");
					}
					break;
				case "bg":
					var img = "/public/images/bg/"+Yl.trim(value);
					var styleEl =$("#temp-css").el;
					var csscode ='';
					if(Yl.trim(value)!=="default"){
						csscode = 'body {background:url('+img+')}'
					}else{
						csscode = '';
					}
					if (styleEl.styleSheet) { // IE
					   styleEl.styleSheet.cssText = csscode;
					} else { // W3C
					   styleEl.innerHTML = csscode;
					}
					break;
				case "layout":
					if(value>0){
						Cookie.set(i,value);
						$$('nor_item').style.fontWeight = "normal";
						$$('kp_item').style.fontWeight = "bold";				
					}else{
						Cookie.clear(i);
							
					}
					break;
				default:
					return false
					break;
			}
			
			
		}
		function _createCss(css,cssid){
			if(Doc.getElementById(cssid)){
				$("#"+cssid).el.href = css;
				return;
			}
			$("head").create("link",{id:cssid,href:css,rel:"stylesheet",type:"text/css"},function(el){
				this.append(el);
			});
		}
	},
	Set = function(data){
		for(var i in data){
			if(data[i]){
				config[i] = data[i];
				Cookie.set(i,data[i]);
			};
		}
		display();
	},
	Reset = function(){
		for(var i in config){
			Cookie.clear(i);
		}
		function isFF(){
			var H = navigator.userAgent,_ = 0;
			if (/Firefox(\s|\/)(\d+(\.\d+)?)/.test(H)) _ = RegExp.$2;
			return _;
		}
		if(isFF()){
			parent.window.location.href = "/?rd="+new Date().getTime();
			parent.window.location.search = "";
		}else{
			parent.window.location.reload();
		}
	},
	init = function(){
		for(var i in config){
			if(Cookie.get(i)){
				config[i] = Cookie.get(i);
				setActive(i,config[i]);				
			}
		}
	}
	init();
	return{
		set:Set,
		Init:init,
		Reset:Reset
	}
})();
var items = document.getElementById("setBox").getElementsByTagName('a');
for(var i= 0,len = items.length;i<len; i++){
	(function(el){
		el.onclick = function(){
		var type = el.parentNode.id.split("-")[0],value = el.rel;															  
			switch(type){
				case "sidebar":
					Skin.set({sidebar:value});
					break;
				case "style":
					Skin.set({style:value});
					break;
				case "font":
					Skin.set({font:value});
					break;
				case "bg":
					var bgitems = el.parentNode.getElementsByTagName("a");
					Skin.set({bg:value});
					break;
				case 'layout':
					Skin.set({layout:value});	
					break;
				case 'ctrl':
					if(value =='reset'){
						Skin.Reset();	
					}else{
						$('#settingBox').hide();
					}
					break;
			}
		}
	})(items[i]);
}