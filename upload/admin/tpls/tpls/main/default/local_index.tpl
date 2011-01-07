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
            <div id="city">
                <h2>地方服务</h2>
                <p id="selectBtn"><a  class="gray6" id="selectCity" onclick="selectCity()">选择城市</a></p>
                <div id="citylist" style="display:none">
                	<span class="t">去其它城市</span>
<p class="clearfix">
<a href="<{$URL_HTML}>/local/" title="全部" target="_parent">全部</a>
<a  href="beijing.htm" title="北京" target="_parent">北京</a>
<a  href="tianjin.htm" title="天津" target="_parent">天津</a>
<a  href="hebei.htm" title="河北" target="_parent">河北</a>
<a  href="shanxi.htm" title="山西" target="_parent">山西</a>
<a  href="neimenggu.htm" title="内蒙古" target="_parent">内蒙古</a>
<a  href="liaoning.htm" title="辽宁" target="_parent">辽宁</a>
<a  href="jilin.htm" title="吉林" target="_parent">吉林</a>
<a  href="heilongjiang.htm" title="黑龙江" target="_parent">黑龙江</a>
<a  href="shanghai.htm" title="上海" target="_parent">上海</a>
<a  href="jiangsu.htm" title="江苏" target="_parent">江苏</a>
<a  href="zhejiang.htm" title="浙江" target="_parent">浙江</a>
<a  href="anhui.htm" title="安徽" target="_parent">安徽</a>
<a  href="fujian.htm" title="福建" target="_parent">福建</a>
<a  href="jiangxi.htm" title="江西" target="_parent">江西</a>
<a  href="shandong.htm" title="山东" target="_parent">山东</a>
<a  href="henan.htm" title="河南" target="_parent">河南</a>
<a  href="hubei.htm" title="湖北" target="_parent">湖北</a>
<a  href="hunan.htm" title="湖南" target="_parent">湖南</a>
<a  href="guangdong.htm" title="广东" target="_parent">广东</a>
<a  href="guangxi.htm" title="广西" target="_parent">广西</a>
<a  href="hainan.htm" title="海南" target="_parent">海南</a>
<a  href="chongqing.htm" title="重庆" target="_parent">重庆</a>
<a  href="sichuan.htm" title="四川" target="_parent">四川</a>
<a  href="guizhou.htm" title="贵州" target="_parent">贵州</a>
<a  href="yunnan.htm" title="云南" target="_parent">云南</a>
<a  href="xizang.htm" title="西藏" target="_parent">西藏</a>
<a  href="shaanxi.htm" title="陕西" target="_parent">陕西</a>
<a  href="gansu.htm" title="甘肃" target="_parent">甘肃</a>
<a  href="qinghai.htm" title="青海" target="_parent">青海</a>
<a  href="ningxia.htm" title="宁夏" target="_parent">宁夏</a>
<a  href="xinjiang.htm" title="新疆" target="_parent">新疆</a>
<a  href="taiwang.htm" title="台湾" target="_parent">台湾</a>
<a  href="hongkong.htm" title="香港" target="_parent">香港</a>
<a  href="aomeng.htm" title="澳门" target="_parent">澳门</a>
                    </p>
                </div>
                
            </div><!--/ city-->
            
            
        </div><!--/ header-->
        
    <div id="guide" class="bd">
    <dl>
    <dt>您当前的位置：</dt>
    <dd><a href="<{$URL}>" target="_parent">首页</a><em>&gt;</em></dd>
    <dd>地方服务</dd>
    </dl>
    <ul>
    <li class="sethome"><a href="javascript:void(0)" onclick="Yl.setHome(this,'<{$URL}>')" target="_parent" class="gray6">设本站为主页</a></li>
    <li class="feedback"><a href="<{$URL}>/feedback/" class="gray6">网友留言</a></li>
    </ul>
    
    </div><!--/ guide-->
        
    <div id="map" style="margin: 20px auto; width:737px;">
    	<img src="<{$URL}>/static/images/chinamap.gif" border="0" usemap="#Map" alt="地图"  width="737" height="581" />
        <map name="Map" id="Map">
<area shape="rect" coords="173,166,208,186" href="xinjiang.htm" alt="新疆" />
<area shape="rect" coords="210,371,239,388" href="xizang.htm" alt="西藏" />
<area shape="rect" coords="335,473,364,488" href="yunnan.htm" alt="云南" />
<area shape="rect" coords="434,545,460,563" href="hainan.htm" alt="海南" />
<area shape="rect" coords="481,514,510,531" href="aomeng.htm" alt="澳门" />
<area shape="rect" coords="518,497,547,517" href="hongkong.htm" alt="香港" />
<area shape="rect" coords="423,467,451,485" href="guangxi.htm" alt="广西" />
<area shape="rect" coords="504,468,537,484" href="guangdong.htm" alt="广东" />
<area shape="rect" coords="608,430,639,449" href="taiwang.htm" alt="台湾" />
<area shape="rect" coords="682,543,732,558" href="#" alt="南沙诸岛" />
<area shape="rect" coords="542,436,572,455" href="fujian.htm" alt="福建" />
<area shape="rect" coords="465,416,494,432" href="hunan.htm" alt="湖南" />
<area shape="rect" coords="509,406,539,424" href="jiangxi.htm" alt="江西" />
<area shape="rect" coords="561,378,594,399" href="zhejiang.htm" alt="浙江" />
<area shape="rect" coords="597,337,629,358" href="shanghai.htm" alt="上海" />
<area shape="rect" coords="554,323,585,339" href="jiangsu.htm" alt="江苏" />
<area shape="rect" coords="529,350,556,367" href="anhui.htm" alt="安徽" />
<area shape="rect" coords="469,361,494,377" href="hubei.htm" alt="湖北" />
<area shape="rect" coords="400,417,428,434" href="guizhou.htm" alt="贵州" />
<area shape="rect" coords="386,381,419,399" href="chongqing.htm" alt="重庆" />
<area shape="rect" coords="347,350,377,368" href="sichuan.htm" alt="四川" />
<area shape="rect" coords="407,326,438,342" href="shaanxi.htm" alt="陕西" />
<area shape="rect" coords="476,319,507,340" href="henan.htm" alt="河南" />
<area shape="rect" coords="536,266,564,283" href="shandong.htm" alt="山东" />
<area shape="rect" coords="455,262,482,281" href="shanxi.htm" alt="山西" />
<area shape="rect" coords="356,300,387,319" href="gansu.htm" alt="甘肃" />
<area shape="rect" coords="314,286,342,303" href="qinghai.htm" alt="青海" />
<area shape="rect" coords="379,260,409,279" href="ningxia.htm" alt="宁夏" />
<area shape="rect" coords="407,204,454,222" href="neimenggu.htm" alt="内蒙古" />
<area shape="rect" coords="511,205,542,224" href="beijing.htm" alt="北京" />
<area shape="rect" coords="493,230,523,248" href="hebei.htm" alt="河北" />
<area shape="rect" coords="533,225,562,241" href="tianjin.htm" alt="天津" />
<area shape="rect" coords="578,187,611,206" href="liaoning.htm" alt="辽宁" />
<area shape="rect" coords="614,96,657,118" href="heilongjiang.htm" alt="黑龙江" />
<area shape="rect" coords="607,148,641,169" href="jilin.htm" alt="吉林" />
</map>
    </div>
    
        
    <div class="bd" id="cate">
    
    
    
    <h3>综合地方门户</h2>
    <ul>
        <{foreach from = $local_index_list item = v}>
        <li><a href="<{$v.url}>" target="_blank" <{if $v.namecolor}> style="color:<{$v.namecolor}>"<{/if}>><{$v.name}></a></li>
        <{/foreach}>
    </ul>
   
</div>

        
    <div id="meta" class="clearfix bd">
        <p>
        <a href="<{$URL}>" class="back" target="_parent"><span>返回</span><em class="fl">返回</em></a>
        <a class="close" href="javascript:closeWin()" target="_self"><span>关闭</span><em class="fl">关闭</em></a>
        </p>
    </div>
    <div id="gotop" class="clearfix">
    	<a href="#page" target="_parent">返回顶部</a><br /><br />
    </div>
    
    <a href="javascript:void(0)" target="_self" id="addmyfav" style="display:none;" title="添加到自定义收藏夹">加入首页自定义收藏</a>
    
    </div><!--/ wrap-->
</div><!--/ page-->
<script type="text/javascript">
	function closeWin(){
	   window.open("","_self");
	   window.top.opener=null;
	   window.top.close();
	 }
</script>
<script type="text/javascript" src="<{$URL}>/themes/default/js/page.js"></script>
<div style="display:none"><{$tongji}></div>
</body>
</html>
