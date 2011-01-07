String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g, '');
}
Function.prototype.bindevent = function(scope, args){
		var method = this;
		if(args === undefined){
			args = [];
		}
		return function() {
			return method.apply(scope, args.concat(arguments));
		}
	}

/**
 * TextBox 提示
 */
var TextBoxDrop = function(pInputId,pContentId){
	var _self = this;
	var _EnterHandler;
	var _AjaxMethod;
	var _input = document.getElementById(pInputId);;
	var _ContentBox = document.getElementById(pContentId);
	var _Data;
	var _activeItemStyle = "active";
	var _activeId = -1;
	var _mouseInContent = false;
	var _DisplayContentHandler;	//显示事件
	var _SetContentStyle;
	var _url = "";	//查询地址
	var _oldStr = "";	
	var _timer;
	var _oldData;
	this.GetUrlHandler;

	var bindevents = function(){
		_input.onkeyup = keyUpFun;
		_input.onkeydown = keyDownFun;
		_input.onfocus = function(){
			_input.select();
			getDataFun();
		};
		_input.onblur = function(){
			clearTimer();
			if(!_mouseInContent){
				hideBox();
			}
		};
		_ContentBox.onmousemove = function(){
			_mouseInContent = true;
		};
		_ContentBox.onmouseout = function(){
			_mouseInContent = false;
		};
	}
	
	/*Event*/
	
	var keyDownFun = function(e){
		var key = window.event ? event.keyCode : e.which;
		switch(key){
			case 13:
				if(!isHiden()){
					clearTimer();
					hideBox();
				}
				else{
					return true;
				}
				if(_EnterHandler){
					_EnterHandler(_input);
				}
				//Enter
				return false;
			case 40:
				//Down
				_activeId += 1;
				hoverItem();
				return;
			case 38:
				//UP
				_activeId -= 1;
				hoverItem();
				return;
		}
	}
	
	var keyUpFun = function(e){
		var key = window.event ? event.keyCode : e.which;
		switch(key){
			case 13:
				if(!isHiden()){
					clearTimer();
					hideBox();
				}
				else{
					return true;
				}
				return false;
			case 40:
				return;
			case 38:
				return;
			default:
				_activeId = -1;
				getDataFun();
				break;
		}
	}

	var clearTimer = function(){
		if(_timer){
			window.clearTimeout(_timer);
			_timer = null;
		}
	}
	
	/*/Event*/
	var getDataFun = function(){
		clearTimer();
		_timer = window.setTimeout(searchFun,400);
	}
	
	var searchFun = function(){
		if(_input.value != ""){
			if(_oldStr != _input.value.trim() || _oldStr == ""){
				var url = _url + _input.value.trim();
				if(_self.GetUrlHandler){
					url = _self.GetUrlHandler();
				}
				if(_AjaxMethod){
					_oldStr = _input.value.trim();
					_AjaxMethod(url,function(data){
						var arr = eval(data);
						_oldData = arr;
						if(arr && arr.length > 0){
							showBox();
							displayContent(arr);
						}
						else{
							hideBox();
						}
					});
				}
			}
			else{
				if(_oldData && _oldData.length > 0){
					showBox();
					displayContent(_oldData);
				}
			}
		}
		else{
			_oldStr = "";
			hideBox();
		}
	}
	
	var hoverItem = function(){
		var liArr = _ContentBox.getElementsByTagName("li");
		if(_activeId > liArr.length-1){
			_activeId = 0;
		}
		if(_activeId < 0){
			_activeId = liArr.length-1;
		}
		for(var i = 0; i < liArr.length; i++){
			var item = liArr[i];
			if(i == _activeId){
				item.className = _activeItemStyle;
				_input.value = item.innerHTML;
				_input.setAttribute("rel",item.getAttribute("rel"));
			}
			else{
				item.className = "";
			}
		}
	}
	this.DefaultKey = "key";
	var displayContent = function(arr){
		var html = "";
		if(_activeId > arr.length-1){
			_activeId = arr.length-1;
		}
		if(_activeId < -1){
			_activeId = -1;
		}
		_ContentBox.innerHTML = "";
		for(var i = 0; i < arr.length; i++){
			var item = document.createElement("li");
			item.innerHTML = arr[i].value;
			item.setAttribute("rel",arr[i][_self.DefaultKey]);
			item.onmouseover = mOver.bindevent(this,[item]);
			item.onmouseout = mOut.bindevent(this,[item]);
			item.onclick = mClick.bindevent(this,[item]);
			_ContentBox.appendChild(item);
		}
		if(_DisplayContentHandler){
			_DisplayContentHandler(_input,_ContentBox);
		}
		if(_SetContentStyle){
			_SetContentStyle(_input,_ContentBox);
		}
	}
	
	var mOver = function(ele){
		_activeId = -1;
		ele.className = _activeItemStyle;
	}
	
	var mOut = function(ele){
		ele.className = "";
	}
	
	var mClick =  function(ele){
		 _input.value = ele.innerHTML;
		 if(_EnterHandler){
			_EnterHandler(ele);
		 }
		 hideBox();
	}
	
	var isHiden = function(){
		return _ContentBox.style.display == "none";
	}
	
	var showBox = function(){
		_ContentBox.style.display = "block";
	}
	
	var hideBox = function(){
		_ContentBox.style.display = "none";
	}

	var init = function(){
		bindevents();
	}
	
	this.SetEnterHandler = function(pHandler){
		_EnterHandler = pHandler;
	},
	this.SetAjaxMethod = function(pMethod){
		_AjaxMethod = pMethod;
	},
	this.SetContentStyle = function(callback){
		if(callback){
			_SetContentStyle = callback;
			_SetContentStyle(_input,_ContentBox);
		}
	},
	this.DisplayContentHandler = function(pHandler){
		_DisplayContentHandler = pHandler;
	},
	this.Url = function(pUrl){
		if(pUrl){
			_url = pUrl;
		}
	}
	init();
}