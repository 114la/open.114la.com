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
                        <li><a rel="s115">115����</a></li>
                        <li class="current"><a rel="web">�� ҳ</a></li>
                        <li><a rel="mp3">MP3</a></li>
                        <li><a rel="v115">Ӱ ��</a></li>
                        <li><a rel="image">ͼ Ƭ</a></li>
                        <li><a rel="zhidao">֪ ��</a></li>
                    </ul>
                    <ul  class="clearfix" style="margin:0">
                        <li id="search-menu-more"><span><a class="more" id="smore">�� ��</a></span>
                            <div id="smp"> <a href=" http://video.baidu.com/?tn=lqowen_1_pg">�� Ƶ</a> <a href=" http://tieba.baidu.com/?source=114la.com">�� ��</a> <a href=" http://baike.baidu.com/?source=114la.com">�� ��</a> <a href=" http://stock.baidu.com/?source=114la.com">�� Ʊ</a> <a href=" http://u.115.com/?11413">�� ��</a>  <a href=" http://fav.115.com/?source=114la.com">�ղؼ�</a>  <a href=" http://tool.115.com/?11413">������</a></div>
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
                            <input type="submit" id="searchBtn" class="btn" value="�ٶ�һ��" />
                            <input type="hidden" name="tn" value="lqowen_1_pg" />
                           
                        </form>
                     </div></div>   
                        
                        
                    </div>
                    <!--/ sengine-->
                    
                </div>
            </div>
            <h1 id="logo"><a href="<{$URL}>" target="_parent"><img src="<{$URL}>/static/images/logo.gif" height="69" width="117" /></a></h1>
            <div id="city">
                <h2><{$province}></h2>
                <p id="selectBtn"><a  class="gray6" id="selectCity" onclick="selectCity()">ȥ��������</a></p>
                <div id="citylist" style="display:none">
                	<span class="t">ȥ��������</span>
<p class="clearfix">
<a href="<{$URL_HTML}>/local/" title="ȫ��" target="_parent">ȫ��</a>
<a  href="beijing.htm" title="����" target="_parent">����</a>
<a  href="tianjin.htm" title="���" target="_parent">���</a>
<a  href="hebei.htm" title="�ӱ�" target="_parent">�ӱ�</a>
<a  href="shanxi.htm" title="ɽ��" target="_parent">ɽ��</a>
<a  href="neimenggu.htm" title="���ɹ�" target="_parent">���ɹ�</a>
<a  href="liaoning.htm" title="����" target="_parent">����</a>
<a  href="jilin.htm" title="����" target="_parent">����</a>
<a  href="heilongjiang.htm" title="������" target="_parent">������</a>
<a  href="shanghai.htm" title="�Ϻ�" target="_parent">�Ϻ�</a>
<a  href="jiangsu.htm" title="����" target="_parent">����</a>
<a  href="zhejiang.htm" title="�㽭" target="_parent">�㽭</a>
<a  href="anhui.htm" title="����" target="_parent">����</a>
<a  href="fujian.htm" title="����" target="_parent">����</a>
<a  href="jiangxi.htm" title="����" target="_parent">����</a>
<a  href="shandong.htm" title="ɽ��" target="_parent">ɽ��</a>
<a  href="henan.htm" title="����" target="_parent">����</a>
<a  href="hubei.htm" title="����" target="_parent">����</a>
<a  href="hunan.htm" title="����" target="_parent">����</a>
<a  href="guangdong.htm" title="�㶫" target="_parent">�㶫</a>
<a  href="guangxi.htm" title="����" target="_parent">����</a>
<a  href="hainan.htm" title="����" target="_parent">����</a>
<a  href="chongqing.htm" title="����" target="_parent">����</a>
<a  href="sichuan.htm" title="�Ĵ�" target="_parent">�Ĵ�</a>
<a  href="guizhou.htm" title="����" target="_parent">����</a>
<a  href="yunnan.htm" title="����" target="_parent">����</a>
<a  href="xizang.htm" title="����" target="_parent">����</a>
<a  href="shaanxi.htm" title="����" target="_parent">����</a>
<a  href="gansu.htm" title="����" target="_parent">����</a>
<a  href="qinghai.htm" title="�ຣ" target="_parent">�ຣ</a>
<a  href="ningxia.htm" title="����" target="_parent">����</a>
<a  href="xinjiang.htm" title="�½�" target="_parent">�½�</a>
<a  href="taiwan.htm" title="̨��" target="_parent">̨��</a>
<a  href="hongkong.htm" title="���" target="_parent">���</a>
<a  href="aomen.htm" title="����" target="_parent">����</a>
                    </p>
                </div>
            </div><!--/ city-->
            
            
        </div><!--/ header-->
        
    <div id="guide" class="bd">
    <dl>
    <dt>����ǰ��λ�ã�</dt>
    <dd><a href="<{$URL}>" target="_parent">��ҳ</a><em>&gt;</em></dd>
    <dd><a href="<{$URL_HTML}>/local/" target="_parent">�ط�����</a><em>&gt;</em></dd>
    <dd><{$province}></dd>
    </dl>
    <ul>
    <li class="sethome"><a href="javascript:void(0)" onclick="Yl.setHome(this,'<{$URL}>')" target="_parent" class="gray6">�豾վΪ��ҳ</a></li>
    <li class="feedback"><a href="<{$URL}>/feedback/" class="gray6">��������</a></li>
    </ul>
    
    </div><!--/ guide-->
        
    
    
        
    <div class="bd" id="cate">
    <{foreach from = $local_class_list key = k item = parent name = n}>
    <h3 id="<{$parent.classid}>"><{$parent.classname}></h2>
    <ul>
        <{foreach from = $parent.sites.data item = v}>
        <li><a href="<{$v.url}>" target="_blank" <{if $v.namecolor}> style="color:<{$v.namecolor}>"<{/if}>><{$v.name}></a></li>
        <{/foreach}>
    </ul>
    <{/foreach}>
    </div>

        
    <div id="meta" class="clearfix bd">
        <p>
        <a href="<{$URL}>" class="back" target="_parent"><span>����</span><em class="fl">����</em></a>
        <a class="close" href="javascript:closeWin()" target="_self"><span>�ر�</span><em class="fl">�ر�</em></a>
        </p>
    </div>
    <div id="gotop" class="clearfix">
    	<a href="#page" target="_parent">���ض���</a><br /><br />
    </div>
    
    <a href="javascript:void(0)" target="_self" id="addmyfav" style="display:none;" title="��ӵ��Զ����ղؼ�">������ҳ�Զ����ղ�</a>
    
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
