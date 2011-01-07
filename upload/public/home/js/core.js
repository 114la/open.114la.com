
var SR = {}

//模型
SR.SearchMode = function(obj){
	var _cache = obj;
	var _self = this;
	var _tabEle = _cache.Tab;
	_tabEle.onclick = (function(){
		if(_cache.ClickHandler){
			_cache.ClickHandler(_self);
		}
	})
	
	this.Show = function(){
		if(_cache.Content){
			_cache.Content.style.display = "";
		}
		_cache.Tab.className = _cache.AbledClass;
		var inputs = _cache.Content.getElementsByTagName("input");
		for(var i = 0,len = inputs.length; i < len; i++){
			if(inputs[i].getAttribute("type","text")){
				//inputs[i].focus();
				if(document.all){
					Yl.getFocus(inputs[i]); //fix ie
				}else{
					inputs[i].focus();
				}
				break;
			}
		}
	}
	
	this.Hide = function(){
		if(_cache.Content){
			_cache.Content.style.display = "none";
		}
		_cache.Tab.className = _cache.DisabledClass;
	}
}

//关联对象
SR.SearchRate = (function(){
	var _cache = {
		Data: []
	};
	
	var instance = function(obj){
		return new SR.SearchMode(obj);
	}
	
	//点击Tab方法
	var clickFun = function(mod){
		for(var k in _cache.Data){
			if(_cache.Data[k].Hide){
				_cache.Data[k].Hide();
			}
		}
		mod.Show();
	}
	
	return {
		Add: function(arr,defaultKey){
			if(arr.length){
				for(var i = 0,len = arr.length; i < len; i++){
					var obj = arr[i];
					obj.ClickHandler = function(r){
						clickFun(r);
					}
					var mod = instance(obj);
					_cache.Data.push(mod);
				}
				if(defaultKey == undefined){
					defaultKey = 0;
				}
				clickFun(_cache.Data[defaultKey]);
			}
		},
		Init: function(tabTagName,abledClass,disabledClass){
			abledClass = abledClass || "";
			disabledClass = disabledClass || "";
			var tabList = document.getElementsByTagName(tabTagName);
			var arr = [];
			var defaultKey = 0;
			for(var i = 0,len = tabList.length; i < len; i++){
				var item = tabList[i];
				var attr = item.getAttribute("s_tab");
				if(attr != null){
					var content = document.getElementById(attr);
					var obj = {
						Tab: item,
						Content: content,
						AbledClass:abledClass,
						DisabledClass:disabledClass
					}
					var ind = arr.push(obj);
					if(item.getAttribute("default")){
						defaultKey = ind - 1;
					}
					new SR.RadioMod(content);
				}
			}
			SR.SearchRate.Add(arr,defaultKey);
		}
	}
})();

SR.RadioMod = function(box){
	var _cache = {radios:[]}
	var l = box.getElementsByTagName("input");
	for(var i = 0,len = l.length; i < len; i++){
		var item = l[i];
		var type = item.getAttribute("rad");
		if(type != null){
			_cache.radios.push(item);
		}
	}
	
	var bind = function(){
		for(var i = 0,len = _cache.radios.length; i < len; i++){
			var ele = _cache.radios[i];
			ele.onclick = (function(){
				var radio = this;
				SR.RadioMod.ClickRadio(radio);
			})
		}
	}
	
	if(_cache.radios.length){
		bind();
	}
}

SR.RadioMod.ClickRadio = function(radio){
	var type = radio.getAttribute("rad");
	var mod = SR.SearchData[type];
	if(mod){
		var form = radio.form;
		var inputs = form.getElementsByTagName("input");
		var delInd = [];
		for(var j = 0,jlen = inputs.length; j < jlen; j++){
			var item = inputs[j];
			var rel = item.getAttribute("rel");
			if(item.getAttribute("type") == "hidden"){
				delInd.push(item);
			}
			if(rel){
				switch(rel){
					case "kw":
						item.setAttribute("name",mod.name);
						break;
					case "btn":
						item.value = mod.btn;
						break;
				}
			}
		}
		var img = form.getElementsByTagName("img");
		for(var j = 0,jlen = img.length; j < jlen; j++){
			img[j].setAttribute("src", mod.img[1]);
			img[j].setAttribute("title",mod.img[0]);
		}
		var a = form.getElementsByTagName("a");
		for(var j = 0,jlen = a.length; j < jlen; j++){
			if(a[j].getAttribute("rel") == "lk"){
				a[j].setAttribute("href", mod.url);
			}
		}
		for(var j = 0,jlen = delInd.length; j < jlen; j++){
			form.removeChild(delInd[j]);
		}
		form.setAttribute("action",mod.action);
		if(mod.params){
			for(var k in mod.params){
				var hidden = document.createElement('input');
				hidden.setAttribute("type","hidden");
				hidden.setAttribute("name",k);
				hidden.value = mod.params[k];
				//hidden.value = mod.params[k];
				form.appendChild(hidden);
				//hidden.setAttribute("value",mod.params[k]);
				
				
			}
		}
	}
}


window.onload = (function(){
	SR.SearchRate.Init("li","active","");
	var sbBox = document.getElementById('sb');
	var sbForms = sbBox.getElementsByTagName('form');
	/*for(var i = 0,len = sbForms.length; i < len; i++){
		sbForms[i].reset();
	}*/
	
})