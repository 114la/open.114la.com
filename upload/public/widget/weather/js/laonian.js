function pngfix(img){
	if (window.XMLHttpRequest) {return}
		var imgStyle = "display:inline-block; " + img.style.cssText;
		var strNewHTML = "<span class=\"" + img.className + "\" title=\"" + img.title + "\" style=\"width:" + img.clientWidth + "px; height:" + img.clientHeight + "px;" + imgStyle + ";" + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + img.src + "', sizingMethod='crop');\"></span>";
		img.outerHTML = strNewHTML;
}//ie6 png

var $ = function(id){return document.getElementById(id)}
var Ylmf = { 
	Cookies : {
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
	},
	format : function(_, B) {
	if (arguments.length > 1) {
		var F = Ylmf.format,
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
getProId : function(proName) {
	var ProId;
	for (var i = 0, len = CityArr.length; i < len; ++i) {
		if (CityArr[i][0] == proName && parseInt(CityArr[i][2]) <900) {
			ProId = CityArr[i][2];
		}
	}
	return ProId
},
getCityId:function(ProId, CityName) {
	if(!ProId) return false;
	var CityId;
	for (var i = 0, len = CityArr.length; i < len; ++i) {
		if (CityArr[i][1] == ProId && CityArr[i][0] == CityName) {
			CityId = CityArr[i][2];
		}
	}
	return CityId
},
getCitys : function(ProId){
	if(!ProId) return false;
	var Citys = [];
	for (var i = 0, len = CityArr.length; i < len; ++i) {
		if (CityArr[i][1] == ProId) {
			Citys.push(CityArr[i]);
		}
	}
	return Citys;
},
getSelectValue:function(select) {
	var idx = select.selectedIndex,
	option,
	value;
	if (idx > -1) {
	option = select.options[idx];
	value = option.innerHTML.split(' ')[1];
		return value;
		//return (value && value.specified) ? option.value : option.text;
	}
	return null;
},
	ScriptLoader:{
		Add: function(config) {
			if (!config || !config.src) return;
			var Head = document.getElementsByTagName('head')[0],			
				Script = document.createElement('script');
				Script.onload = Script.onreadystatechange = function() {
					if (Script && Script.readyState && Script.readyState != 'loaded' && Script.readyState != 'complete') return;
					Script.onload = Script.onreadystatechange = Script.onerror = null;
					Script.Src = '';
					if(!document.all){Script.parentNode.removeChild(Script);}
					Script = null;
				};
				Script.src = config.src;
				Script.charset = config.charset || 'gb2312';
				Head.insertBefore(Script,Head.firstChild);
		}
	}
}
var W = document.getElementById('weather');
var Weather = {
	CityCookieName:'citydata',
	WeatherCookieName:'weather',
	DefaultCity:['109','101010100','101010100','北京','北京'],
	StatIPQueue:[],
	StatGetQueue:[],
	ShowStatus:function(num){
		if(!num){return}
		var str;
		switch(num){
			case 100:
				str = '正在判断城市，请稍后...&nbsp; <a href="javascript:void(0);" onclick="Weather.Set();return false;" target="_self">[手动设置]</a> <a href="http://tool.115.com/tianqi/" target="_blank">快速查看</a>';
				break;
			case 101:
				str = '判断城市失败，默认为北京，请手动设置。';
				break;
			case 102:
				str = '正在获取天气数据，请稍候... <a href="http://tool.115.com/tianqi/" target="_blank">快速查看</a>';
				break;
			case 404:
				str = '很抱歉，暂无该城市天气数据。<a href="javascript:void(0);" onclick="Weather.Set();return false;" target="_self">[选择其它城市]</a>';
				break;
			case 500:
				str = '服务器错误或本地网络过慢。<a href="###" onclick="window.location.reload();">[点击重试]</a>';
				break;
			case 200:
				var result = arguments[1];
				var data = {};
				var TPL = '<div id="city" class="fl"><h1>#{city}</h1><span><a href="javascript:void(0);" onclick="Weather.Set();return false;" target="_self">设置</a></span></div>';

				var item_tpl = '';
				var week_obj = {
					'星期日':['星期一','星期二'],
					'星期一':['星期二','星期三'],
					'星期二':['星期三','星期四'],
					'星期三':['星期四','星期五'],
					'星期四':['星期五','星期六'],
					'星期五':['星期六','星期日'],
					'星期六':['星期日','星期一']
				}
				
				for(var i = 1; i< 3; i++){
					(function(key){
						var arr = ['temp','weather'];
						for(var k =0,len = arr.length;k<len;k++){
							data[arr[k]+key] = result[0][arr[k]+key];	
						}		  
					})(i);
					item_tpl += '<div class="item"><div class="img"><img align="absmiddle" src="images/m/#{img'+i+'}.png" class="i" onload="pngfix(this)"></div>'+
					'<div class="w"><a href="http://tool.115.com/tianqi/#{cityid}" target="_blank"><strong>#{week'+i+'}</strong><br />#{temp'+i+'}<br />#{weather'+i+'}</a></div></div>';
				}
				var today_week = result[0]['week'];
				data['week1']= today_week;
				data['week2']= week_obj[today_week][0];
				data['week3']= week_obj[today_week][1];
				data['img1'] = result[0]['img1'];
				data['img2'] = result[0]['img3'];
				data['img3'] = result[0]['img5'];
				data['cityid'] = result[1];
				data['city'] = result[0]['city']
				TPL+=item_tpl;
				str = Ylmf.format(TPL,data);
				break;
		}
		W.innerHTML = str;
	},
	Ip2City :function(callback){
		this.ShowStatus(100);
		Ylmf.ScriptLoader.Add({
			src:'http://api.115.com/ip',
			charset:'gb2312'
		});
		var that = this;
		if(typeof Ip2CityTimeOut!= "undefined"){
			window.clearTimeout(Ip2CityTimeOut);
		}
		var Ip2CityTimeOut = window.setTimeout(function(){
			Ylmf.Cookies.clear(this.CityCookieName);
			callback && callback(that.DefaultCity);
		},3000);
		window.ILData_callback = function(){
			if(typeof(ILData) != "undefined"){
				if(typeof Ip2CityTimeOut!= "undefined"){
					window.clearTimeout(Ip2CityTimeOut);
				}
				if (ILData[2] && ILData[3]) {
					var pid = Ylmf.getProId(ILData[2]);
					var cid = Ylmf.getCityId(pid, ILData[3]);
					var City = [pid, cid, cid,ILData[2],ILData[3]];
					Ylmf.Cookies.set(that.CityCookieName,City);
					callback && callback(City);
				}
			}
		}
	},
	Get:function(cityid){
		if(!cityid) return;
		var AleaId = cityid.slice(3, 7);
		var showStatus = this.ShowStatus;
		var that = this;
		showStatus(102);
		if(typeof TimeOut!= "undefined"){
			window.clearTimeout(TimeOut);
		}
		var TimeOut = window.setTimeout(function(){
			showStatus(500);
			Ylmf.Cookies.clear(this.CityCookieName);
		},5000);
		var api = 'http://weather.api.115.com/' + AleaId + '/' + cityid + '.txt';
		api+='?'+new Date().getTime();
		if(!Ylmf.Cookies.get(this.WeatherCookieName)){
			
		}
		Ylmf.ScriptLoader.Add({
			src: api.toString(),
			charset:"utf-8"
		});
		window.Ylmf.getWeather = function(Data){
			window.clearTimeout(TimeOut);
			if (typeof(Data) == "object" && typeof(Data) != "undefined" && typeof(Data.weatherinfo) != "undefined" && Data.weatherinfo != false) {
				var result = [Data.weatherinfo,cityid];
				if(result){
					Weather.ShowStatus(200,result);
					Ylmf.Cookies.set(that.WeatherCookieName,1);
				}
			} else if (Data.weatherinfo == false) {
				Weather.ShowStatus(404);
			}
		}
	},
	Init:function(){
		var ckname = this.CityCookieName;
		var that = this;
		if(Ylmf.Cookies.get(this.CityCookieName)){
			var City = Ylmf.Cookies.get(this.CityCookieName).split(',');
			if(!City[2]){
				Ylmf.Cookies.clear(this.CityCookieName);
				that.Init();
			}
			this.Get(City[2]);
		}else{
			this.Ip2City(function(City){
				var C = Ylmf.Cookies.get(that.CityCookieName);
				if(C){
					C = C.split(',')
					that.Get(C[2]);
				}else{
					that.Get(City[2]);
				}
			});
		}
	},
	getAreas: function(cid,callback){
		var AreaId = cid.slice(3,7);
		Ylmf.ScriptLoader.Add({
            src: "http://weather.api.115.com/" + AreaId + "/" + AreaId + ".txt?"+new Date().getTime(),
            charset: "utf-8"
        });
		Ylmf.getAreaCity = function(O){
			if (typeof(O) == "object" 
				&& typeof(O.result) != "undefined" 
				&& typeof(O.result[0][0]) != "undefined"){
				callback(O.result);
			}
		}
	},
	initCitys:function(pid){
		if(!pid) return;
		$("w_city").innerHTML = "";
		for(var i = 0, len =CityArr.length; i < len; ++i){
			var I = CityArr[i];
			if(I[1]==pid){
				var option = document.createElement("option");
				option.value = I[2];
				option.innerHTML = I[3] + '&nbsp;' + I[0];
				$("w_city").appendChild(option);
			}
		}
		$("w_city").selectedIndex = 0;
	},
	initAreaCitys:function(cid,callback){
		//$("l_city").innerHTML = "<option>选择地区</option>";
		$("l_city").innerHTML = "";
		this.getAreas(cid,function(AreaCitys){
			for(var i = 0, len =AreaCitys.length; i < len; ++i){
				var I = AreaCitys[i];
				var option = document.createElement("option");
				if(I[0]==cid){
					option.selected = true;
				}
				option.value = I[0];
				option.innerHTML = I[2] + "&nbsp;" + I[1];
				$("l_city").appendChild(option);
			}
			if(callback){
				callback();
			}
		});
	},
	Set:function(){
		W.style.display = "none";
		$("setCityBox").style.display = "";
		var City = Ylmf.Cookies.get(this.CityCookieName);
		if(City){
			City = City.split(",");
		}else{
			City = this.DefaultCity;
		}
		$("w_pro").value = City[0];
		this.initCitys(City[0]);
		$("w_city").value = City[1];
		this.initAreaCitys(City[2]);
	},
	cp:function (val){
		this.initCitys(val);
		$("w_city").selectedIndex = 0;
		this.cc($("w_city").value);
	},
	cc:function(val){
		this.initAreaCitys(val,function(){});	
	},
	custom:function (){
		var City = Ylmf.Cookies.get(this.CityCookieName);
		if(City){
			City = City.split(",")
		}else{
			City = this.DefaultCity;
		}
		var C = [$("w_pro").value,
			  $("w_city").value,
			  $("l_city").value?$("l_city").value:$("w_city").value,
			  Ylmf.getSelectValue($("w_pro")),
			  Ylmf.getSelectValue($("w_city"))
		];
		if(City[2]!=C[2]){
			this.Get(C[2]);
			Ylmf.Cookies.set(this.CityCookieName,C);
		};
		$("setCityBox").style.display = "none";
		W.style.display = "";
	
	},
	autoLoad:function(){
		Ylmf.Cookies.clear(this.CityCookieName);
		Ylmf.Cookies.clear(this.WeatherCookieName);
		window.location.reload();
		
		//this.Init();
		//$("setCityBox").style.display = "none";
		//W.style.display = "";
	}
	
}
Weather.Init();