<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title></title>
<link href="static/css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="wrap">
    <div class="container">
        <div id="header">

            <div class="con">

            <div id="logo">
                <a href="?c=login&a=welcome" title="管理系统首页" target="main">雨林木风后台管理系统</a>
            </div>
            
            <div id="menu">
                    <div class="item">
                        <ul>
                            <li class="index"><a href="?c=login&a=menu&id=0" id="item0" target="menu" class="active" onclick="Tabmenu(this,0);">管理首页</a></li>
                            <li><a href="?c=login&a=menu&id=1" target="menu" id="item1" onclick="Tabmenu(this,1);">系统管理</a></li>
                            <li><a href="?c=login&a=menu&id=2" target="menu" id="item2" onclick="Tabmenu(this,2);">网址管理</a></li>
                            <li><a href="?c=login&a=menu&id=9" target="menu" id="item9" onclick="Tabmenu(this,9);">搜索引擎</a></li>
                            <li><a href="?c=login&a=menu&id=3" target="menu" id="item3" onclick="Tabmenu(this,3);">专题管理</a></li>
                            <li><a href="?c=login&a=menu&id=4" target="menu" id="item4" onclick="Tabmenu(this,4);">广告管理</a></li>
                            <li><a href="?c=login&a=menu&id=5" target="menu" id="item5" onclick="Tabmenu(this,5);">数据管理</a></li>
                            <li><a href="?c=login&a=menu&id=6" target="menu" id="item6" onclick="Tabmenu(this,6);">模板管理</a></li>
                            <li><a href="?c=login&a=menu&id=7" target="menu" id="item7" onclick="Tabmenu(this,7);">静态生成</a></li>
                            <!--<li><a href="?c=login&a=menu&id=8" target="menu" id="item8" onclick="Tabmenu(this,8);">插件管理</a></li>-->
                        </ul>
                    </div>
                </div><!--/ menu-->
            </div><!--/ con-->
        </div><!--/ header-->
</div>
</div>
<script type="text/javascript">
function Tabmenu(obj,n){
	var Items = document.getElementById("menu").getElementsByTagName("a");
	for(var i= 0,len = Items.length;i<len;++i){
		if(Items[i].clssName !==""){
			Items[i].className = "";
		}
		obj.className = "active";
		obj.blur();
		location.hash = n;
	}
};
(function(){
var n = location.hash.replace("#","");
if(!n){ n = 0;}
var curitem = document.getElementById("item"+n);
	Tabmenu(curitem,n);
})();
</script>
</body>
</html>
