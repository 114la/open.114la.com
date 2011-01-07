/**
 * ==========================================
 * skin.js
 * Copyright (c) 2009 wwww.114la.com
 * Author: cia@115.com
 * ==========================================
 */

var Skinselector = (function(){
	var config = {style:"",	layout:"",font:"",bg:""},
	skinPath = skinPath||"themes/default/skins/",
	SkinCookie = userCookie.init();
	
	var display = function(){
		for(var i in config){
			if(config[i]){
				set(i,config[i]);
			}
		}
		function set(i,value){
			switch(i){
				case "style":
					var skins = ["blue","orange","green","purple","blue2"],
					css = skinPath+skins[Number(value)]+"/style.css";
					Ajax(css,function(){
						$("#skin").el.href = css;
					});
					break;
				case "font":
					var css = "themes/default/css/font/"+Yl.trim(value)+".css";
					if(Yl.trim(value)=="default"){
						$("#font").el.href = "";
						SkinCookie.remove("font");
					}else{
						Ajax(css,function(){
							$("#font").el.href = css;
						});
					}
					break;
				case "layout":
					var c = ["","medium","wide"];
					var layout = c[Number(value)];
					$("#home").el.className = layout;
					break;
				case "bg":
					var img = "themes/default/images/bg/"+Yl.trim(value);
					if(Yl.trim(value)!=="default"){
						$("#home").setStyle("background","url("+img+")");
					}else{
						$("#home").setStyle("background","");
					}
					break;
				default:
					return false
					break;
			}
		}
	},
	Set = function(data){
		for(var i in data){
			if(data[i]){
				config[i] = data[i];
				SkinCookie.set(i,data[i]);
			};
		}
		display();
	},
	Reset = function(){
		for(var i in config){
			if(SkinCookie.get(i)){
				SkinCookie.remove(i);
				window.location.reload();
			};
		}
	},
	init = function(){
		for(var i in config){
			if(SkinCookie.get(i)){
				config[i] = SkinCookie.get(i);
			}
		}
		display();
	},
	path = function(p){
		return skinPath = p;
	}
	init();
	return{
		Set:Set,
		Init:init,
		Reset:Reset,
		Path:path
	}
})();