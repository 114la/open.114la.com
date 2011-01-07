/**
 * ==========================================
 * page.js
 * Copyright (c) 2009 wwww.114la.com
 * Author: cia@115.com
 * ==========================================
 */
 
 

 
document.onclick = function(e){
	var e = e|| window.event,
	obj = e.srcElement || e.target,
	tid = obj.id;

	if(tid!="smore"){
		$("#smp").hide();
	}
	if(tid!="selectCity"){
		
		$("#citylist").hide();
	}
}; 

 
var SE = new SearchEngine({
	form:"searchForm",
	input:"searchInput",
	smb:"searchBtn"
});//ʵ������ģ����
SE.input.focus(); //����������
 //����TAB�˵���ʼ
$("#search-menu ul li a").each(function(el){
	var t = el.parentNode.tagName.toUpperCase();									
	$(el).on("click",function(el){

		if(el.id =="smore"){
			$("#smp").toggle();
			return;
		}
		
		if(t=="LI"){
			$("#search-menu ul li").removeClass("current");
			$(el.parentNode).addClass("current");
			$("#sengine").show();
			var tab = Config.Search[el.rel];
			SE.Select(tab);
			SE.input.value =SE.input.value;
		}
	});
});//����TAB�˵�����


function getPosXY(obj, offset) {
    var p = offset ? offset.slice(0) : [0, obj.offsetHeight - 1];
    do {
        p[0] += obj.offsetLeft;
        p[1] += obj.offsetTop;
        obj = obj.offsetParent;
    } while ( obj );
    return p;
}

var MyFav = (function(){
	var waitInterval,
	timer = 300,
	currentLink ={},
	Collstore = userCookie.init(),
	FavData = Collstore.get("cl"),
	star = $("#addmyfav").el;
		
	$("#cate li a").on("mouseover",function(el){
		currentLink.href = el.href.replace(/^(.*?)(\/)?$/,'$1');
		currentLink.name = el.innerHTML;

		var p =getPosXY(el),
		LINK = currentLink.name+"+"+currentLink.href+"_MyFav_";
		
		if(Collstore.is("cl") && unescape(FavData).indexOf(LINK) >-1){
			if(star.className==""){
				star.className = "active";
			}
			star.setAttribute("title","���ղص���ҳ�ղؼ�")
		}else{
			star.className = "";
			star.setAttribute("title","��ӵ��Զ����ղؼ�")
		}
		
		if(waitInterval){
			window.clearTimeout(waitInterval);
		}
		
		$("#addmyfav").setCSS({
			left:p[0]+el.offsetWidth+2+"px",
			top:(p[1]-el.offsetHeight)+"px"
		}).show();
	});//Hover
	
	$("#cate li a").on("mouseout",function(el){
		waitInterval = window.setTimeout(function(){
			$("#addmyfav").hide();
		},timer)								   
	});//out
	
	$("#addmyfav").on("mouseover",function(el){
		if(waitInterval){
			window.clearTimeout(waitInterval);
		}
		$(el).show()
	
	})
	
	$("#addmyfav").on("mouseout",function(el){
		
		waitInterval = window.setTimeout(function(){
			$(el).hide();
		},200);
	})
	
	$("#addmyfav").on("click",function(el){
		if(el.className == "active"){
			alert("��ɫ���Ǳ�ʾ�����ղع�����ַ��");
		}else{
			el.className = "active";
			saveToFav(currentLink.href,currentLink.name)
		}
		el.blur();
	})

	
	function saveToFav(url,name){
		url = url.replace(/^(.*?)(\/)?$/,'$1');
		var coll =name+"+"+url+"_MyFav_";
		if(coll){
			if(Collstore.is("cl")){
				var collCookie = Yl.trim(Collstore.get("cl"));
				coll+=unescape(collCookie);
			}
			
			coll=escape(coll);
			FavData = coll;
			Collstore.set("cl",coll);
			alert("�ɹ���ӵ���ҳ�Զ����ղأ�")
		}
	}
	return{
		save:saveToFav
	}
})();





function selectCity(){
	$("#citylist").show();
	
	
	

}



