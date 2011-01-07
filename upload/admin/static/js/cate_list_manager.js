function arrNumberOrder(a,b){return a-b;}
var CateListManager = {
	activeObj:{},
	setActive: function(index,obj){
		CateListManager.activeObj[index] = obj;
		var arr = [];
		for(var key in CateListManager.activeObj){
			var id = CateListManager.activeObj[key].classId;
			var li = $("#js_cate_list li[classid='"+id+"']");
			li.parent().find("li").removeClass("active");
			
			if(Number(key) <= Number(index)){
				//CateListManager.activeObj[key] = null;
				li.addClass("active");
				arr.push(Number(key));
			}
		}
		arr.sort(arrNumberOrder);
		var linkhtml = "";
		var isfirst = true;
		for(var i = 0, len = arr.length; i < len; i++){
			if(!isfirst){
				linkhtml += " &gt; ";
			}
			else{
				isfirst = false;
			}
			linkhtml += "<a href='javascript://'>"+CateListManager.activeObj[i.toString()].classname+"</a>";
		}
		$("#js_link_text_span").html(linkhtml);
		
	},
	_bindListEvent: function(li){
		li.bind("click",function(){
			CateListManager._SelectHandler($(this));
		});
	},
	AjaxUrl: "?c=class&a=ajax_get_list&id=",
	_loadState: {},
	_clearSelect: function(){
		$("#js_submit_classid").val("");
		$("#js_cate_list").find("td[index]").each(function(i){
			if(Number($(this).attr("index")) != 0){
				$(this).hide();
			}
			else{
				$(this).show();
				$(this).find("li").removeClass("active");
			}
		});
		$("#js_link_text_span").html("");
	},
	_SelectHandler: function(ele,callback){
		var liele = ele;
		var classId = liele.attr("classid");
		$("#js_submit_classid").val(classId);
		
		var ol = $("#js_cate_list").find("ol[classid='"+classId+"']");
		var index = Number(liele.parent().parent().attr("index"));
		CateListManager.setActive(index,{classname: liele.text(), classId: classId});
		if(ol.length){
			$("#js_cate_list").find("td[index]").each(function(i){
				if(Number($(this).attr("index")) > index){
					$(this).hide();
				}
			});
			ol.parent().show();
			if(callback){
				callback();
			}
		}
		else{
				$("#js_cate_list").find("td[index]").each(function(i){
					if(Number($(this).attr("index")) > index){
						$(this).hide();
					}
				});
				var url = CateListManager.AjaxUrl + classId;
				$.ajax({
					url: url,
					type: "GET",
					dataType: "json",
					cache: false,
					success: function(result){
						if(result){
							CateListManager._displayChild(result,classId);
						}
						if(callback){
							callback();
						}
					}
				});
		}
	},
	Init:function(){
		$("#js_cate_list ol li").each(function(i){
			CateListManager._bindListEvent($(this));
		});
	},
	_displayChild: function(result,classId){
		var ul = $("#js_cate_list");
		var ind = Number(ul.find("li[classid='"+classId+"']").parent().parent().attr("index")) + 1;
		var html = "<td index='"+ind+"'><ol classid='"+classId+"'>";
		for(var key in result){
			var item = result[key];
			html += "<li classid='"+item["classid"]+"'>"+item["classname"]+"<\/li>";
		}
		html += "<\/ol><\/td>";
		var list = $(html);
		list.find("li").not("[rel='main']").each(function(i){
			CateListManager._bindListEvent($(this));
		});
		ul.append(list);
	},
	SelectClass: function(idStr){
		if(idStr){
			var arr = idStr.split(",");
			//arr.sort(arrNumberOrder);
			var ulBox = $("#js_cate_list");
			if(arr.length > 0){
				var selectHandlerFun = function(index,length){
					if(index < length){ 
						var firstLi = ulBox.find("li[classid='"+arr[index]+"']");
						CateListManager._SelectHandler(firstLi,function(){
							index++;
							firstLi.addClass("active");
							selectHandlerFun(index,length);
						});
					}
				}
				var ind = 0;
				selectHandlerFun(ind,arr.length);
			}
		}
		else{
			CateListManager._clearSelect();
		}
	}
};