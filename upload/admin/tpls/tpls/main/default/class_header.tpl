<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="keywords" content="<{$class_meta_keyword}>" />
<meta name="description" content="<{$class_meta_description}>" />
<title><{$title}></title>
<link href="<{$URL}>/themes/default/page.css" rel="stylesheet" type="text/css" />
<link id="skin" href="<{$URL}>/themes/default/skins/blue/page.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<{$URL}>/themes/default/js/ylmf.cai.js"></script>
<script type="text/javascript" src="<{$URL}>/themes/default/js/config.js"></script>
<script type="text/javascript" src="<{$URL}>/themes/default/js/base.js"></script>
<script type="text/javascript">
var PageSkin = (function(){
	var PageskinCookie = userCookie.init();
	if(PageskinCookie.is("style")){
		var skins = ["blue","orange","green","purple","blue2"];
		var skinName = skins[Number(PageskinCookie.get("style"))];
		document.getElementById("skin").href = "<{$URL}>/themes/default/skins/"+skinName+"/page.css";
	}
	return{
		cookie:PageskinCookie
	}
})()

</script>
<base target="_blank" />
</head>
<body>
<div id="page">
<script type="text/javascript">
	(function(){
		if(PageSkin.cookie.is("bg")){
			var value = PageSkin.cookie.get("bg");
			var img = "<{$URL}>/themes/default/images/bg/"+Yl.trim(value);
			if(Yl.trim(value)!=="default"){
				$("#page").setStyle("background","url("+img+")");
			}else{
				$("#page").setStyle("background","");
			}
		}else{
			return;
		}
	})()
</script>
    <div class="wrap">
        <div id="header" class="clearfix">
                <div id="search" class="clearfix">
                <div id="search-menu" class="clearfix">
                    <ul class="clearfix">
                        <li><a rel="s115">115聚搜</a></li>
                        <li class="current"><a rel="web">网 页</a></li>
                        <li><a rel="mp3">MP3</a></li>
                        <li><a rel="v115">影 视</a></li>
                        <li><a rel="image">图 片</a></li>
                        <li><a rel="zhidao">知 道</a></li>
                    </ul>
                    <ul  class="clearfix" style="margin:0">
                        <li id="search-menu-more"><span><a class="more" id="smore">更 多</a></span>
                            <div id="smp"> <a href=" http://video.baidu.com/?tn=lqowen_1_pg">视 频</a> <a href=" http://tieba.baidu.com/?source=114la.com">贴 吧</a> <a href=" http://baike.baidu.com/?source=114la.com">百 科</a> <a href=" http://stock.baidu.com/?source=114la.com">股 票</a> <a href=" http://u.115.com/?11413">网 盘</a>  <a href=" http://fav.115.com/?source=114la.com">收藏夹</a>  <a href=" http://tool.115.com/?11413">工具箱</a></div>
                        </li>
                    </ul>
                </div>
                <div id="search-form" class="bd">
                <div class="search-bg">
                    <div class="con">
                    <div id="sengine" class="clearfix">
                        <form id="searchForm" action="http://www.baidu.com/baidu" method="get" target="_blank">
                            <label for="baidu"><a href="#"><img src="<{$URL}>/static/images/sl/logox3.gif" width="79" height="27" /></a></label>
                            <div class="input">
                                <input type="text" id="searchInput" name="wd" autocomplete="off" />
                            </div>
                            <input type="submit" id="searchBtn" class="btn" value="百度一下" />
                            <input type="hidden" name="tn" value="lqowen_1_pg" />
                            <input type="hidden" name="ie" value="utf-8" />
                           
                        </form>
                     </div></div>   
                        
                        
                    </div>
                    <!--/ sengine-->
                    
                </div>
            </div>
            <h1 id="logo"><a href="<{$URL}>" target="_parent"><img src="<{$URL}>/static/images/logo.gif" height="69" width="117" /></a></h1>

        </div><!--/ header-->
