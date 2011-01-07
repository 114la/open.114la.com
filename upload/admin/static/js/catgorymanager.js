var CatgoryManager = {
	Init:function(table){
		CatgoryManager.Table = table;
		var trcol = table.find("tr[classid]");
		trcol.each(function(i){
			CatgoryManager._bindEvent($(this).find("td[rel='classname'] a"));
		});
	},
	AjaxUrl:"?c=class&a=ajax_get_list&id=",
	GetChilds:function(classId,tr,childindex,callback){
		var url = CatgoryManager.AjaxUrl + classId;
		$.ajax({
			url: url,
			type: "GET",
			dataType: "json",
			cache: false,
			success: function(result){
				tr.attr("open","1");
				hasTrs = CatgoryManager.DisplayList(result,tr,childindex);
				if(callback){
					callback();
				}
			}
		});
	},
	_find:function(classId,obj,openState){
		CatgoryManager.Table.find("tr[parent='"+classId+"']").each(function(i){
			var tr = $(this);
			obj.list.push(tr);
			if((Number(openState) == 0 && tr.attr("open") != openState) || Number(openState) == 1){
				CatgoryManager._find(tr.attr("classid"),obj,openState);
			}
		});
	},
	_findChildTrs:function(classId){
		var result = {list:[]};
		var openState = CatgoryManager.Table.find("tr[classid='"+classId+"']").attr("open");
		CatgoryManager._find(classId,result,openState);
		return result;
	},
	_openChildHandler: function(parent,callback){
		var classnum = Number(parent.attr("classnum"));
		if(classnum > 0){
			var classId = parent.attr("classid");
			var hasTrs = CatgoryManager._findChildTrs(classId);
			if(!hasTrs.list.length){
				CatgoryManager.GetChilds(classId,parent,parent.attr("childindex"),callback);
				return;
			}
			var openState = parent.attr("open");
			if(openState == undefined || Number(openState) == 0){
				parent.attr("open","1");
				for(var i = 0, len = hasTrs.list.length; i < len; i++){
					var item = hasTrs.list[i];
					item.show();
				}
			}
			else{
				parent.attr("open","0");
				for(var i = 0, len = hasTrs.list.length; i < len; i++){
					var item = hasTrs.list[i];
					item.hide();
				}
			}
			if(callback){
				callback();
			}
		}
	},
	_bindEvent: function(a){
		a.bind("click",function(){
			var parent = $($(this).parent().parent());
			CatgoryManager._openChildHandler(parent);
		});
	},
	SelectClass: function(idStr){
		if(idStr){
			var arr = idStr.split(",");
			if(arr.length){
				var selectHandlerFun = function(index,length){
					if(index < length){
						var tr = $("#datatable").find("tr[classid='"+arr[index]+"']");
						CatgoryManager._openChildHandler(tr,function(){
							index++;
							selectHandlerFun(index,length);
						});
					}
				}
				var tb = $("#datatable");
				tb.find("tr[childindex='1']").attr("open","0");
				tb.find("tr[parent]").hide().attr("open","0");
				var ind = 0;
				selectHandlerFun(ind,arr.length);
			}
		}
	},
	SetDisplayFun:function(fun){
		CatgoryManager.DisplayList = fun;
	}
};