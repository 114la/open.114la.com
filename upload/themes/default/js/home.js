/**
 * ==========================================
 * home.js
 * Copyright (c) 2009 wwww.114la.com
 * Author: cai@115.com
 * ==========================================
 */




var Notice = (function(){
 	var o = 0,
	stopscroll = false;
	stop_time = 200;
	var preTop = 0;
	var currentTop = 20;
	var stoptime = 0,
	s = 1,
	upobj;
	function init_news() {
		upobj = $("#notice").el;
		
		if (!upobj) return;
		upobj.innerHTML += upobj.innerHTML;
		upobj.scrollTop = 0;
		setInterval("Notice.scrollUp()", 15);
		
		with(upobj) {
			onmouseover = function() {
				stopscroll = true;
			};
			onmouseout = function() {
				stopscroll = false;
			};
		}
	}
	function scrollUp() {
		if (stopscroll == true) return;
		currentTop += s;
		if (currentTop == 21) {
			stoptime += s;
			currentTop -= s;
			if (stoptime == stop_time) {
				currentTop = 0;
				stoptime = 0;
			}
		} else {
			preTop = upobj.scrollTop;
			upobj.scrollTop = preTop + s;
			if (preTop == upobj.scrollTop) {
				upobj.scrollTop = 20;
				upobj.scrollTop += s;
				
			}
		}
	}
	return{
		init:init_news,
		scrollUp:scrollUp
	}
})();//��������

 Notice.init();

/*���ر���ͼƬ��ʼ*/
function initBgitem(){
	var skinCookie = userCookie.init(),
	curBg = skinCookie.is("bg")? Yl.trim(skinCookie.get("bg")) :"default";
	

	if(cache.is("BGITEM_LOADSTATE")==false){

		var p = "themes/default/images/bg/";
	
		
		$("#bg-item a").el.forEach(function(element){
			var src = p+element.rel;
			
			if(element.rel!=="default"){
				Ajax(src,function(){});
				element.style.background = "url("+src+") -10px -15px repeat";	
			}

			if(element.rel==curBg){
				element.style.borderColor = "red";
			}
			
		});
		cache.set("BGITEM_LOADSTATE",1)
	}
}/*���ر���ͼƬ����*/

window.onload=function(){
	var Cookie = userCookie.init();
	if(Cookie.is("Ylclock")){
		Ylclock.Load();
		Ylclock.Ring();
	}
	UserTrack.show();
	
	
	
	if(Browser.isIE=="6.0"){
		$("#coolsite dl").each(function(el){
										
			el.onmouseover = function(){
					this.tmpClass = this.className;
					this.className ="iehover";
				
			}
			el.onmouseout=function(){
				this.className = this.tmpClass;
			}
		
		})
	}//ie6 coolsite dl:hover

}


document.onclick = function(e){
	var e = e|| window.event,
	obj = e.srcElement || e.target,
	tid = obj.id;

	if(tid!="smore"){
		$("#smp").hide();
	}
	if(tid=="delHistory"){
		UserTrack.remove();
	}
	if(tid=="setting"){
		$("#setting-box").show();
		if(document.getElementById("clockBox").style.display!="none"){
			$("#clockBox").hide();
		}
		initBgitem();
		
		

	}else if(cache.get("SETTINGBOX_HIDESTATE") || tid=="setting2"||tid=="setting-close"||tid=="setting-reset"){
		$("#setting-box").hide();
	}
	
	if(tid=="closeWTBOX" || cache.get("WTBOX_HIDESTATE")&& tid!=="wet" ){
		$("#weatherBox").hide();
		if(Browser.isIE=="6.0"){
			$("#mailBox ul").show()
		}
	}
	$("#suggest").hide();
	
	UserTrack.add(obj);
	
};


//�����¼��ʼ
var MailLogin  = {
    mailCache: [],
    sendMail: function() {
		var username = $("#mail_username").el.value,
        password = $("#mail_passwd").el.value,
        servers = $("#mail_options").el,
        form = document.mail,
        index = servers.selectedIndex,
        H = Config.Mail[index],
        F = {
            u: username,
            p: password
        };

        if (H.val == 0) {
            alert("��û��ѡ�����䣡");
            return
        }
        if (Yl.trim(F.u) == "") {
            alert("�û�������Ϊ�գ�");
            return
        }
        if (Yl.trim(F.p) == "") {
            alert("���벻��Ϊ�գ�");
            return
        }
		
		if (this.mailCache.index != index) {
			//this.mailCache.index = index;
			this.mailCache.forEach(function(el){
				form.removeChild(el)
			})
			this.mailCache = [];
        }	
		
        form.action = H.action;
        for (I in H.params) {
			$(form).create("input",{
					type:"hidden",
					name:I,
					value:format(H.params[I], F)				
				},
				function(el){
					MailLogin.mailCache.push(el);
					this.append(el)
				}
			)
        }
       	form.submit();
        $("#mail_passwd").el.value = ""
    }
}//�����¼����


//ʵ������ģ���࿪ʼ
var SE = new SearchEngine({
	form:"searchForm",
	input:"searchInput",
	smb:"searchBtn"
});//ʵ������ģ�������

SE.input.focus(); //����������

//����TAB�˵���ʼ
$("#search-menu ul li a").on("click",function(el){
	var t = el.parentNode.tagName.toUpperCase();									

		
		if(el.id =="smore"){
			$("#smp").toggle();
			return;
		}
		
		if(t=="LI"){
			$("#lsBox").hide();
			$("#search-menu ul li").removeClass("current");
			$(el.parentNode).addClass("current");
			if(el.id == "localsearch"){
				$("#sengine").hide();
				$("#lsBox").show();
				return;
			}else{
				$("#sengine").show();
			}
			var tab = Config.Search[el.rel];
			SE.Select(tab);
			SE.input.value =SE.input.value;
			$("#search-word p").hide();
			$("#search-word p#sw_"+el.rel).show();
		}
});//����TAB�˵�����

//��վ��վ��˵���ʼ
(function(){  
		  
	var timer = 300; //�����˵���ʱ
	var activeContent;
	var hideState = true;
	var hide = function(){
		if(hideState && activeContent){
			activeContent.style.display = "none";
			
		}
	}

	
	$("#fmsite ul.top em").each(function(el){
		
		el.onmouseover = function(){
			hide();
			var box = el.parentNode.getElementsByTagName("div")[0];
			var showbox = function(){box.style.display = "block"}
			waitInterval = window.setTimeout(showbox,timer-100)
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
			if(waitInterval!=undefined){
				window.clearTimeout(waitInterval);
			}

		}

	})
})();//������վ��վ��˵�

//��վ�л����Tab�˵���ʼ
(function(){
	var evt = ["click","mouseover"],
	MouseDelayTime = 400, //�����ͣʱ��
	waitInterval;
		  
	$("#board-menu li a").each(function(el){
		evt.forEach(function(element){
			switch(element){
				case "click":
					el["on"+element] = run;
					break;
				case "mouseover":
					el["on"+element] = function(){
						waitInterval = window.setTimeout(run,MouseDelayTime);
					}
					el["onmouseout"] = function(){
						if(waitInterval!=undefined){
							window.clearTimeout(waitInterval);
						}
					}
					break;
			}				 
		});
		function run(){
			$("#board-menu li").removeClass("current");
			el.parentNode.className = "current";
			
			show(el);
		}
		function show(el){
			var boxid = el.getAttribute("rel"),
			url = el.getAttribute("url"),
			noCache = el.getAttribute("nocache");
			if(!boxid){ return ;}

			var Tabs = cache.get("BOARD_BOX_TAB");
			
			if(cache.is("LAST_BOXTAB")){
				var box = $(cache.get("LAST_BOXTAB")).el;
				if(box.className=="nocache"){
					box.parentNode.removeChild(box);
				}else{
					$(cache.get("LAST_BOXTAB")).hide();
				}
			}else{
				$("#fmsite").hide();
			}
			

			if(!url){
				$("#"+boxid).show();
				cache.set("LAST_BOXTAB","#"+boxid);
				return;
			}else if(cache.is("BOARD_BOX_TAB")==false){
				createTabBox();
			}else{
				if(Tabs.indexOf(boxid)==-1){
					createTabBox();
				}
			}			
			
			function createTabBox(){
				$("#board-box").create("div",
					{id:boxid},
					function(el){
						var html = Yl.createFrame({src: url,width: "100%",height: "310"});
						el.innerHTML = html;
						this.append(el);
						if(noCache){
							el.className = "nocache";
						}else{
							cache.set("BOARD_BOX_TAB",el.id,1);
						}
					}
				)
			}
			cache.set("LAST_BOXTAB","#"+boxid);
			$("#"+boxid).show();

			
		}//show
		
		
	});
})();//������վ�л����Tab�˵�


/*�Զ����ղؿ�ʼ*/
function favoFuninput(o, n) {
    if (n == 1) {
        o.className = "int n";
        if (o.value == "վ��" || o.value == "��ַ") {
            if (o.value == "��ַ") o.value = "http://";
            else o.value = ""
        }
    } else {
        if (!o.value || o.value == "http://") {
            o.className = "int u";
            if (o.name == "urlName") o.value = "վ��";
            if (o.name == "Url") o.value = "��ַ";
        }
    }
}


var MyFav = (function(){
	
	function addColl(o){
		favoname = o.urlName;
    	favourl = o.Url;
    	err = 0;
    if (favoname.value == "" || favoname.value == "վ��") {
        favoname.className = "int e";
        favoname.value = "վ��";
        err = 1
    }
    if (favourl.value == "" || favourl.value == "http://" || favourl.value == "��ַ") {
        favourl.className = "int e";
        favourl.value = "��ַ";
        return false;
        err = 1
    }
	if(favourl.value.indexOf("http://") !== 0 && favourl.value.indexOf("https://")!==0 ){

		alert('��ַ��ʽ����ȷ�������� "http://" �� "https://"��ͷ��');
		err = 1;

	}
	
    if (err == 1){ return false }
	
	saveColl(favoname.value,favourl.value);
	
	$("#addColl").hide();
	$("#addCollmsg").show();
	$("#addCollmsg").el.innerHTML = "�ɹ���� [<a onclick=\"$('#addCollmsg').hide();$('#addColl').show();\">���ؼ������</a>]";
	
	o.reset();
	
    return false;
	
	}
	var Collstore = userCookie.init();
	
	

	function saveColl(name,url){
		url = url.replace(/^(.*?)(\/)?$/,'$1');
		var coll =name+"+"+url+"_MyFav_";
	
		if(coll){
			if(Collstore.get("cl")!==null&&unescape(Collstore.get("cl")).indexOf(coll)!==0){
				coll+=unescape(Collstore.get("cl"));
			}
			
			coll=escape(coll);
			Collstore.set("cl",coll);
			showColl();
		}
		
	}								

	function showColl(){
	
		try {
			var customsite = Collstore.get("cl");
			 customsite = unescape(customsite);
			var content = '';
			var img = '<img src="static/images/del.gif" title="ɾ������ַ" onclick="MyFav.remove(this.parentNode)" />';
			if (customsite !== "null") {
				customsite_arg = customsite.split("_MyFav_");
				i = 0;
				linknum = 0;
				len = customsite_arg.length;
				for (i = 0; i < len; i++) {
					var slink = customsite_arg[len - i-1].split("+");
					if (customsite[i] !== "null" && content.indexOf(slink[0]) == -1 && linknum < 35) {
						content += '<li>'+img+' <a href="' + slink[1] + '" title="' + slink[0] + '" target="_blank">' + slink[0] + '</a></li>';
						linknum += 1;
					}
				}
				$("#Collbox").el.innerHTML = content;
			} else {
				$("#Collbox").el.innerHTML  = '<li class="none">����û���κ�����ӵ���ַ�ղء�</li>';
			}
		} catch(e) {
			
		}
	}
	function delColl(o) {
		var obj = o.getElementsByTagName("a")[0],
		name = obj.innerHTML,
		url=obj.href;
		url=url.replace(/^(.*?)(\/)?$/,'$1');
		
		var coll = Yl.trim(name+"+"+url+"_MyFav_"),
		sitename = Yl.trim(Collstore.get("cl"));
		
		sitename = unescape(sitename);

		var newColl = sitename.replace(coll,"");
		if(newColl==""){
			Collstore.remove("cl");
		}else{
			newColl = escape(newColl);
			Collstore.set("cl",newColl);	
		}
		showColl();
	}
	
	showColl();
	return{
		add: addColl,
		show: showColl,
		remove: delColl,
		save: saveColl
	}
})();/*�Զ����ղؽ���*/




/*���ÿ�վ���뷽ʽ��ʼ*/
var CoolsiteAlign = (function(){
	var AlignCookie = userCookie.init(),
		al = AlignCookie.get("coolsite");
	if(AlignCookie.is("coolsite") && al==1){
		set("left");
	}else{
		set("center");
	}
	
	$("#clalign").on("click",function(el){
		
		if(el.className ==""){
			set("left");
			AlignCookie.set("coolsite",1)
		}else{
			set("center");
			AlignCookie.set("coolsite",0)
		}
		el.blur();
	});
	
	function set(align){
		var el = $("#clalign").el;
		if(align=="left"){
			el.className="l";
			$("#list").el.className = "left";
			
		}else{
			el.className="";
			$("#list").el.className =  "";
		}
	
	}
	function config(align){
		if(!AlignCookie.is("coolsite")){
			set(align);
		}else{
			return false;
		}
	}
	
	return{
		set:config	
	}


})();/*���ÿ�վ���뷽ʽ����*/



/*Ƥ�����ÿ�ʼ*/
(function(){
	$("#setting-box li a,#style-quick a").on("click",function(el){
															  
															  
		var type = el.parentNode.id.split("-")[0],
		value = el.rel;															  
								  
		switch(type){
			case "layout":
				Skinselector.Set({layout:value});
				break;
			case "style":
				Skinselector.Set({style:value});
				break;
			case "font":
				Skinselector.Set({font:value});
				break;
			case "bg":
				$("#bg-item a").setStyle("borderColor","#ccc");
				el.style.borderColor = "red";
				Skinselector.Set({bg:value});
				
				break;
		
		}		
	})
	
	$("#setting-box").el.onmouseover = function(){
		cache.set("SETTINGBOX_HIDESTATE",0)
	}
	$("#setting-box").el.onmouseout = function(){
		cache.set("SETTINGBOX_HIDESTATE",1)
	}
	
})(); /*Ƥ�����ý���*/




/*���������࿪ʼ*/
var Weather = (function(){
						
	var CityCookie = userCookie.init(Yl.getHost(),"/",new Date(new Date().getTime()+1000*3600*2));
	function getCityId(city){
		var id = [];
		var city = city || this.City;
		CityArr.forEach(function(element,index,array){
			if(element[0]==city){
				id[0] = element[1];
				id[1] = element[2];
			}
		})
		return id;
	}
	
	
	function getWeather(cityid){
		
		var api = "http://tool.115.com/static/weather/"+cityid+".txt?rd="+(new Date()).getTime();
		var Timeout;
		var weatherHTML = "";
		if(cache.is("WEATHER_TEMP_TITLE") == false && cache.is("WEATHER_TEMP") == false){
			cache.set("WEATHER_TEMP_TITLE", $("#weather p").el.innerHTML);
			cache.set("WEATHER_TEMP", $("#weatherBox").el.innerHTML);
		}
				
		XSAjax.send({
			url:api,
			before:function(){
			$("#weather").el.innerHTML = "����Ԥ�����ڼ����С�";
				Timeout = setTimeout(				
				function(){
					if($("#weather").el.innerHTML == "����Ԥ�����ڼ����С�"){
						$("#weather").el.innerHTML='�������س�ʱ��<a onclick="Weather.init(1);window.clearTimeout(Timeout)" class="red">[���¼���]</a> <a onclick="Weather.set()" class="red">[�ֶ�����]</a>'
					}else{
						return;
					}
				},
				5000
				)
				
			},
			after:function(){
				var data = weatherJSON;
				if(!data){
					$("#weather").el.innerHTML = '�ܱ�Ǹ����û�иó��е��������ݣ� <a onclick="Weather.set()" class="red">[�� ��]</a>';
					return;
				}	
				var w = data.weather,
				imgPath = "static/images/weather/",
				iconPath = imgPath+'24x20/'+data.weather.today.icon[0].replace(".gif",".png");
				icon = '<img align="absmiddle" onload="pngfix(this)" src="'+iconPath+'" />';
			
						
				$("#weather").el.innerHTML = format(cache.get("WEATHER_TEMP_TITLE"),{
					city:data.city[1],
					title:data.title,
					img:icon
				})

				for(var i in w){
					var datatxt = "";
					switch(i){
						case "today":
							datatxt = "����";
							break;
						case "tomorrow":
							datatxt = "����";
							break;
						case "after":
							datatxt = "����";
							break;
					}
				
					weatherHTML+= '<ul><li class="date">'+datatxt+'<br/>'+w[i].temp+'</li>' 
					           +'<li><img src="'+imgPath+"42x30/"+w[i].icon[0]+'"/> <img src="'+imgPath+"42x30/"+w[i].icon[1]+'"/></li>'
							   +'<li class="desc">'+w[i].desc[0]+'</li>'
							   +'<li class="wind">'+w[i].desc[1]+'</li></ul>'
				}
				
				var P = {
					more:'<a href="http://tool.115.com/?ct=live&ac=weather&city='+cityid+'" rel="nr"  title="����鿴��ϸ����Ԥ��">[�鿴��ϸ]</a>',
					city: data.city[0] + "&nbsp;" + data.city[1],
					postTime: data.public_time,
					weather:weatherHTML
				}
				$("#weatherBox").el.innerHTML = format(cache.get("WEATHER_TEMP"),P);			
			}
		})
	}
	

	
	function setCity(){
		$("#weather").hide();
		$("#setCity").show();
		CT = cache.get("CITY");
		LoadCity(CT[0],CT[1]);		
	}
	
	function LoadCity(key,cityid){
		$("#w_city").el.innerHTML="";
		CityArr.forEach(function(element,index,array){
			if(element[1]==key){
				$("#w_city").create("option",
					{
						value:element[2]
					},
					function(el){
						el.innerHTML = element[0];
						this.append(el);
					}
				)
			}
		});
		
		
		if(key){
			$("#w_pro").el.value = Number(key);
		}
		
		setTimeout(function(){
			if(cityid){
				$("#w_city").el.value = Number(cityid);
			}else{
				$("#w_city").el.childNodes[0].selected = true
			}
		},0)
		
	}//���س���select ��������
		
	function tick(){
		$("#setCity").hide();
		$("#weather").show();
		var p = $("#w_pro").el.value;
			c = $("#w_city").el.value;
		getWeather(c)			
		cache.set("CITY",[p,c]);
		CityCookie.set("cityId",p+"|"+c);
		

	}//ȷ��
	
	function showMore(){
		$("#weatherBox").toggle();
		if(Browser.isIE=="6.0"){
			$("#mailBox ul").toggle()
		}
		
		$("#weatherBox").on("mouseover",function(){
			cache.set("WTBOX_HIDESTATE",0)
		})
		$("#weatherBox").on("mouseout",function(){
			cache.set("WTBOX_HIDESTATE",1)
		})
	}
	function init(n){
		
		if(CityCookie.is("cityId") && !n){			
			var id = Yl.trim(CityCookie.get("cityId")).split("|"); 
			cache.set("CITY",id);
			getWeather(id[1]);
		}else{
			XSAjax.send({
				url:"http://api.115.com/ipaddress",
				after:function(){
					try{
						cityName =ILData[3].replace("��","");
						if(cityName){
							var City = getCityId(cityName);
							LoadCity(City[0],City[1])
							getWeather(City[1]);
							cache.set("CITY",City);
							CityCookie.set("cityId",City[0]+"|"+City[1]);
							
						}
						
					}catch(e){}
				}
			});//ip2city
			
		}
		
	}
	
	init()
	return{
		init:init,
		set:setCity,
		loadCity:LoadCity,
		tick:tick,
		more:showMore
	}


})();
/*�������������*/

/*���ӿ�ʼ*/
var Ylclock = (function(){
	var AlarmCookie = userCookie.init();
	var CookieName = "Ylclock";
	var ClockName = "114������:";
	var Timer = null; //ʱ���
	var RingTimer = null;  //�����
	var AlarmArray = [];
	var F = function(num) {return num < 10 ? "0" + num: num};
	var htmlspecialchar = function(ee){//ɽկ PHP �� htmlspecialchar ����rz
        ee = Yl.trim(ee);
        var zz = document.createElement('div');
        zz.appendChild(document.createTextNode(ee))
        return zz.innerHTML;
    }
	
	
	
	function showTime(){
		var D = new Date();
		var template = '<strong>��ǰʱ�䣺</strong><em>#{year}</em>��<em>#{month}</em>��<em>#{day}</em>��&nbsp;&nbsp;<em>#{hour}:#{minute}:#{second}</em>';
		$('div.todays').el.innerHTML = format(template,{
			year:D.getFullYear(),
			month:F((D.getMonth())+1),
			day:F(D.getDate()),
			hour:F(D.getHours()),
			minute:F(D.getMinutes()),
			second:F(D.getSeconds())	
		});

	}//��ʾʱ��
	

	
	function bindEvent(){
		$("#alarm_music_button").on("click",function(el){
			if(el.innerHTML=="����"){
				$('#alarm_player').el.src = $("#selectMusic").el.value;
				el.innerHTML="ֹͣ";
				el.style.color = "#666"
			}else{
				el.innerHTML="����";
				el.style.color = "#000"
				$('#alarm_player').el.src = "";
				
			}
		})//������

		$("#closeClock,#cancelBtn").on("click",function(el){
			$("#clockBox").hide();		
		})//�ر�

				
	}//���¼�
	
	function initOption(id,n,callback){
        $(id).el.innerHTML ="";
        for(i=0;i<n;i++){
           $(id).create("option",{value:i},function(el){
				el.innerHTML = F(i);
				this.append(el);
			
			})
        }
		if(callback){
			setTimeout(function(){
				callback($(id).el)
			},0)
		}
        return true;
	}//���select
	
	function setAlarm(){
		if(AlarmArray.length>8){
			alert("���ֻ����� 8 ����������");
			return
		}
		
		var D = new Date();
		var time = D.getTime();
        var hour   = parseInt($("#selectHour").el.value);
        var minute = parseInt($("#selectMinute").el.value);
        
        if(hour < D.getHours()){//���СʱС������ʱ,��������
              time += 60*60*24*1000;
        }else if((hour == D.getHours()) && (minute <= D.getMinutes())){//���ʱ���������ʱ�䣬���Ƿ���С������ʱ����������
              time += 60*60*24*1000; 
        }else{//����һ����
        }
        var ee = new Date(time);
        ee.setHours(hour,minute,0);

        time = ee.getTime();

        //�õ�������ַ
       var music = $('#selectMusic').el.value;

        //�õ���ʾ����
        var alarm_prompt = Yl.trim($('#alarm_textarea').el.value);

        if(alarm_prompt == ''){
            alarm_prompt='��Ϣ����Ϣһ�£�';
            return false;
        }
        
        var is_single = 1;
        //�Ƿ��ظ�
        $('#is_single input').each(function(el){
            if(el.checked){
                is_single = parseInt(el.value);
            }
        });
		
		var anAlarm = [time,music,alarm_prompt,is_single ,0];
       	AlarmArray.push(anAlarm);//����Ǹ� 0 ����������ʾ�ٽ粹��
		
		addAlarm();
	}//��������
	
	function addAlarm(){

			if(AlarmArray.length > 8){
           		alert('���ֻ����� 8 ����������');
            	return false;
        	}
			var template = '<li class="bd"><a class="del" href="javascript:void(0)" onclick="Ylclock.Cancal(#{num}-1)" target="_parent">ɾ��</a> <strong>(#{num})</strong> #{repeat} <em>#{hour}:#{minute}</em> <a title="#{msg}">#{message}</a></li>';
			var D = new Date();
			
			
			
			$('ul.listC').el.innerHTML= "";
			AlarmArray.forEach(function(element,index,array){
				//ʱ��  ����    ��ʾ��  �Ƿ񵥴�����
				index++
				
				var hour = F(new Date(parseInt(element[0])).getHours());
				var minute = F(new Date(parseInt(element[0])).getMinutes());
				var is_single = element[3] ? '��������':'ÿ������';
					
				element[2] = decodeURIComponent(element[2]);
				
				$('ul.listC').el.innerHTML += format(template,{
					num:index,
					repeat:is_single,
					hour:hour,
					minute:minute,
					msg:htmlspecialchar(element[2]),
					message:htmlspecialchar(element[2].substr(0,9))
				})
			
			})
			saveAlarm();
			
	}//�������
	
	
	function saveAlarm(){
		var ee = [];
		AlarmArray.forEach(function(element,index,array){
			element[0] = parseInt(element[0]);
            element[2] = encodeURIComponent(element[2]);
            ee[index] = element.join('=');
		})
		ee = ee.join('|');
		if(ee=="" && AlarmCookie.is(CookieName)){
			$("#YlclockBtn").el.innerHTML = "����";
			AlarmCookie.remove(CookieName);
			return false;
		}
		$("#YlclockBtn").el.innerHTML = "����<span class='red'>["+AlarmArray.length+"]</span>";
		AlarmCookie.set(CookieName,ee);
		hockRing();
		return true;

	}
	
	function loadAlarm(){
		var ee = AlarmCookie.get(CookieName);
        if(ee == null)  return false;
        
        //������滻
        //replace(/\r|\n/gi,'[br]')
        var zz;
        zz = ee.split('|');//�ó� N �� alarm
        if(zz == null) {
			$("#YlclockBtn").el.innerHTML = "����";
			return false;//û������
		}
		
		$("#YlclockBtn").el.innerHTML = "����<span class='red'>["+zz.length+"]</span>";
        zz.forEach(function(element,index,array){
			var kk = [];
            kk = element.split('=');
            if(kk.length == 5){
                kk[0] = kk[0].toString();
                kk[2] = decodeURIComponent(kk[2]);
                AlarmArray.push(kk);
            }
		});
		
		addAlarm()
	}
	
	function ring(){
		if(AlarmArray == 0){
            return false;
        }
        var write_back = [];
        AlarmArray.forEach(function(element,index,array){
            element[2] = decodeURIComponent(element[2]);

            if(element[0] <= new Date().getTime()){//�����ʱ��
                if((parseInt(element[0])+5000) > new Date().getTime()){//��� 5 �����ھ���ʾ���� 5 ���Ӿ� pass
                    $('#alarm_player').el.src = element[1];
                    alert(ClockName+element[2]);
                    $('#alarm_player').el.src =  '';
                }
			

				element[0] += 60*60*24+1000;//�������ʱ�����
				if(element[3]){//����ǵ���ִ��
					element = null;//��������ִ��
				}
			}
            if(element != null){
                write_back[index] = element;
			}
        });


        if(AlarmArray.toString() != write_back.toString()){
            AlarmArray = write_back;
			addAlarm();
        }
	}
	
	
	function hockRing(){
		try{
            clearInterval(RingTimer);
        }catch(e){}
        RingTimerr = setInterval(function(){ring()},1000);
	}//���平��
	
	function hockShowTime(){
		try{
            clearInterval(Timer);
        }catch(e){}
		Timer = setInterval(function(){showTime()},1000);
	}//ʱ�乳��
	
	function delAlarm(id){
		id = parseInt(id);
        var ee = [];
        AlarmArray.forEach(function(element,index,array){
            if(index != id){
                ee.push(element);
            }
        });
        AlarmArray = ee;
		addAlarm();
	}
	
	function init(){
		$('#clockBox').show();
		bindEvent();
		showTime();
		hockShowTime();
		var D = new Date();
		initOption("#selectHour",24,function(el){
			el.value = D.getHours();
		})
		initOption("#selectMinute",60,function(el){
			el.value = D.getMinutes();
		})
		
	}
	return{
		Init:init,
		Ring:hockRing,
		Cancal:delAlarm,
		Load:loadAlarm,
		set:setAlarm
		
	}
	
})();



var Calendar = (function(){
	/*ũ������*/
	var lunarInfo=[0x04bd8,0x04ae0,0x0a570,0x054d5,0x0d260,0x0d950,0x16554,0x056a0,0x09ad0,0x055d2,0x04ae0,0x0a5b6,0x0a4d0,0x0d250,0x1d255,0x0b540,0x0d6a0,0x0ada2,0x095b0,0x14977,0x04970,0x0a4b0,0x0b4b5,0x06a50,0x06d40,0x1ab54,0x02b60,0x09570,0x052f2,0x04970,0x06566,0x0d4a0,0x0ea50,0x06e95,0x05ad0,0x02b60,0x186e3,0x092e0,0x1c8d7,0x0c950,0x0d4a0,0x1d8a6,0x0b550,0x056a0,0x1a5b4,0x025d0,0x092d0,0x0d2b2,0x0a950,0x0b557,0x06ca0,0x0b550,0x15355,0x04da0,0x0a5b0,0x14573,0x052b0,0x0a9a8,0x0e950,0x06aa0,0x0aea6,0x0ab50,0x04b60,0x0aae4,0x0a570,0x05260,0x0f263,0x0d950,0x05b57,0x056a0,0x096d0,0x04dd5,0x04ad0,0x0a4d0,0x0d4d4,0x0d250,0x0d558,0x0b540,0x0b6a0,0x195a6,0x095b0,0x049b0,0x0a974,0x0a4b0,0x0b27a,0x06a50,0x06d40,0x0af46,0x0ab60,0x09570,0x04af5,0x04970,0x064b0,0x074a3,0x0ea50,0x06b58,0x055c0,0x0ab60,0x096d5,0x092e0,0x0c960,0x0d954,0x0d4a0,0x0da50,0x07552,0x056a0,0x0abb7,0x025d0,0x092d0,0x0cab5,0x0a950,0x0b4a0,0x0baa4,0x0ad50,0x055d9,0x04ba0,0x0a5b0,0x15176,0x052b0,0x0a930,0x07954,0x06aa0,0x0ad50,0x05b52,0x04b60,0x0a6e6,0x0a4e0,0x0d260,0x0ea65,0x0d530,0x05aa0,0x076a3,0x096d0,0x04bd7,0x04ad0,0x0a4d0,0x1d0b6,0x0d250,0x0d520,0x0dd45,0x0b5a0,0x056d0,0x055b2,0x049b0,0x0a577,0x0a4b0,0x0aa50,0x1b255,0x06d20,0x0ada0,0x14b63];var Gan=new Array("��","��","��","��","��","��","��","��","��","��");var Zhi=new Array("��","��","��","î","��","��","��","δ","��","��","��","��");var now=new Date();var SY=now.getFullYear();var SM=now.getMonth();var SD=now.getDate();function cyclical(num){return(Gan[num%10]+Zhi[num%12])}function lYearDays(y){var i,sum=348;for(i=0x8000;i>0x8;i>>=1)sum+=(lunarInfo[y-1900]&i)?1:0;return(sum+leapDays(y))}function leapDays(y){if(leapMonth(y))return((lunarInfo[y-1900]&0x10000)?30:29);else return(0)}function leapMonth(y){return(lunarInfo[y-1900]&0xf)}function monthDays(y,m){return(lunarInfo[y-1900]&(0x10000>>m))?30:29}function Lunar(objDate){var i,leap=0,temp=0;var baseDate=new Date(1900,0,31);var offset=(objDate-baseDate)/86400000;this.dayCyl=offset+40;this.monCyl=14;for(i=1900;i<2050&&offset>0;i++){temp=lYearDays(i);offset-=temp;this.monCyl+=12}if(offset<0){offset+=temp;i--;this.monCyl-=12}this.year=i;this.yearCyl=i-1864;leap=leapMonth(i);this.isLeap=false;for(i=1;i<13&&offset>0;i++){if(leap>0&&i==(leap+1)&&this.isLeap==false){--i;this.isLeap=true;temp=leapDays(this.year)}else{temp=monthDays(this.year,i)}if(this.isLeap==true&&i==(leap+1)){this.isLeap=false}offset-=temp;if(this.isLeap==false){this.monCyl++}}if(offset==0&&leap>0&&i==leap+1){if(this.isLeap){this.isLeap=false}else{this.isLeap=true;--i;--this.monCyl}}if(offset<0){offset+=temp;--i;--this.monCyl}this.month=i;this.day=offset+1}

	function cDay(m, d) {
		var nStr1 = new Array('��', 'һ', '��', '��', '��', '��', '��', '��', '��', '��', 'ʮ');
		var nStr2 = new Array('��', 'ʮ', 'إ', 'ئ', '��');
		var s;
		if (m > 10) {
			s = 'ʮ' + nStr1[m - 10]
		} else {
			s = nStr1[m]
		}
		s += '��';
		switch (d) {
		case 10:
			s += '��ʮ';
			break;
		case 20:
			s += '��ʮ';
			break;
		case 30:
			s += '��ʮ';
			break;
		default:
			s += nStr2[Math.floor(d / 10)];
			s += nStr1[d % 10]
		}
		return (s)
	}
	
	function solarDay2() {
		var lDObj = new Lunar(new Date(SY, SM, SD));
		var tt = cDay(lDObj.month, lDObj.day);
		return (tt)
	}
	function showToday(){ 
		var weekStr = "��һ����������";
		var template = '<a href="http://tool.115.com/?ct=live&ac=calendar" rel="nr" title="����鿴������">#{YY}��#{MM}��#{DD}�� ����#{week} #{cncal}</a>';
		var day = format(template,{
			YY:SY,
			MM:SM+1,
			DD:SD,
			week:weekStr.charAt(now.getDay()),
			cncal:solarDay2()
		
		})
		return day
	}

return {
	show:showToday
}
	
})();


$("#date").el.innerHTML = Calendar.show();//��ʾ����



//������ʾ��ʼ
var searchSuggest =(function(){
	var searchurl='http://www.baidu.com/s?tn=hkxs_pg&ch=500&wd=';
	var noSuggest = false;
	$("#searchInput").el.onkeyup = function(e){
		if(document.all){
			e = window.event;
		}
		var keyword = this
		var h = document.getElementById('suggest');
		if (!keyword.value || !keyword.value.length || e.keyCode == 27 || e.keyCode == 13) {
			h.style.display = 'none';
			return;
		}
		if (e.keyCode == 38 || e.keyCode == 40) {
			if (h.style.display == 'none') {
				return;
			}
			if (e.keyCode == 38) {
				if (h._i == -1){ 
					h._i = h.firstChild.rows.length - 1;
				}else {
					h._i--;
				}
			} else {
				h._i++;
			}
		
			for (var i = 0; i < h.firstChild.rows.length; i++) h.firstChild.rows[i].style.background = "#FFF";
			if (h._i >= 0 && h._i < h.firstChild.rows.length) with(h.firstChild.rows[h._i]) {
				style.background = "#E6E6E6";
				keyword.value = cells[0].attributes['_h'].value;
			} else {
				keyword.value = h._kw;
				h._i = -1;
			}
		} else {
			h._i = -1;
			h._kw = keyword.value;
			googleHint(keyword.value, this);
			//with(h.style){width=keyword.offsetWidth - 2;}
		}
	}

	
	function googleHint(key,input){
		var obj = document.getElementById('gsuggest');
		var url = src='http://www.google.cn/complete/search?hl=zh-CN&xhr=f&q=' + encodeURIComponent(key);
		//alert(url);
		if(obj){obj.parentNode.removeChild(obj)};
		XSAjax.send({url:url,charset:"utf-8"})
	}
	
	
	window.google={};
	window.google.ac={};
	var suggest = document.getElementById('suggest');

	window.google.ac.h=function(arr){
		var c = arr[1];
		if(!c || c.length<3) {return;}
		if(noSuggest==true) {return;}
		//if(b != searchInput.value) return;
		var ihtml='';
		for(var j = 0; j < c.length; j ++) {
		ihtml += '<tr style="cursor:hand" onmouseover="javascript:this.style.background=\'#E6E6E6\'" onmouseout="javascript:this.style.background=\'#FFF\';">'
		ihtml +='<td style="color:#000;font-size:12px; text-align:left;" _h="'+c[j][0] +'">';
		ihtml +='<a href="'+searchurl+c[j][0]+'" onclick="searchSuggest.clickitem(this)" key="'+c[j][0]+'" rel = "nr">'
		ihtml +='<em  style="color:#090" align="right" style="font-size:11px;">Լ ' +c[j][1] +'</em>'
		ihtml +=c[j][0]+'</a></td></tr>';
		
		}
		suggest.innerHTML='<table width="100%" border="0" cellpadding="0" cellspacing="0">' + ihtml + '</table><div class="close"><a onclick=\'searchSuggest.close();\'>�ر�</a></div>';
		
		suggest.style.display = "block";
		
		
		
	};
	
	function closeSuggest(){
		suggest.style.display = "none";
		noSuggest = true;
	
	}
	function clickitem(_this){

		$("#searchInput").el.value = _this.getAttribute("key");
	
	}
	return{
		close:closeSuggest,
		clickitem:clickitem
	}

})();//������ʾ����

var localSearch = (function(){
							
	function JHshStrLen(sString){
		var sStr,iCount,i,strTemp ; 
		iCount = 0 ;
		sStr = sString.split("");
		for (i = 0 ; i < sStr.length ; i ++){
			strTemp = escape(sStr[i]); 
			if (strTemp.indexOf("%u",0) == -1){ // ��ʾ�Ǻ���
				iCount = iCount + 1 ;
			}else{
				iCount = iCount + 2 ;
			}
		}
		return iCount ;
	}
	
	var oldkeyword='';
	var siteKey = $("#localInput").el;
	var keyUp_Timer;
	
	siteKey.onkeyup = function(){
			
		  if(this.value=='' ||JHshStrLen(this.value)<2 ){
			  //||JHshStrLen($('sitekeyword').value)<3
			 // showindexhtml();
		  }else{
			  if (this.value!=oldkeyword)
			  {
				  if(keyUp_Timer){
					window.clearTimeout(keyUp_Timer);
				  }
				  keyUp_Timer = window.setTimeout(gositesearch,250);
			  }
				
		  }
	}
	
	function gositesearch(){
		var keyword = siteKey.value;
		var result = $("#lsBox ul").el
		var rd=new Date().getTime();
		oldkeyword=keyword;
		
		url='search.php?keyword='+encodeURIComponent(keyword)+'&rd='+rd;
		//result.className = "result cl";
		$("#lsBox ul").show();
		result.innerHTML='<li class="loadding"><img src="static/images/loadding.gif" alt="loadding..." align="absmiddle" /> ����������,���Ժ�...</li>';
		
		Ajax(url,function(xhr){
						 
			var txt = xhr.responseText;
			if(txt==''){
				result.innerHTML='<li>û�����������վ��!</li>';
			}else if(txt){
				result.innerHTML=txt;
			}
			
			
		})
	}


})();



var RandomPlay = (function() {
	if(document.getElementById("RandomPlayItems").innerHTML==""){
		return;
	}					   
	var lis = $("#RandomPlayItems li").el;
	var htmlArr = [];
	var html =""
		
	//alert(Items)
	lis.forEach(function(element,index,array){
		htmlArr.push("<li>"+element.innerHTML+"</li>")
	})
	getRandom(lis.length,5)
	
	function getRandom(max,n) {
		max = max*1;
		n = n*1;
		var result=[];
		if (n > max) {
			return false;//���������
		}else {
			var ok = 1;
			r = new Array (n);
			for (var i = 1; i <= n; i++) {
				r[i] = Math.round(Math.random() * (max-1))+1;
			}
			for (var i = n; i >= 1; i--) {
			   for (var j = n; j >= 1; j--) {
					if ((i != j)  &&  (r[i] == r[j])) ok = 0;
			   }  
			}
			if (ok) {
				
				for(var i =1 ; i<= n; i++){
					var k = r[i]-1;
					result.push(k)
					
					html+= htmlArr[k]
				}
				$("#RandomPlay").el.innerHTML = html;
				//alert(result)

			}else {
				getRandom(max,n);
			}
		}
	}//����0��max��n�������
	
})();

function logad(){}

