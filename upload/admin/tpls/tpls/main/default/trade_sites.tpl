<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="keywords" content="<{$class_meta_keyword}>" />
<meta name="description" content="<{$class_meta_description}>" />
<title><{$title}></title>
<link href="<{$URL}>/themes/default/page.css" rel="stylesheet" type="text/css" />
<link id="skin" href="/themes/default/skins/blue/page.css" rel="stylesheet" type="text/css" />
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

<style type="text/css">
			#hangye { width:940px; margin:10px auto;}
			#hangye th { width:120px; text-align:center;border-left:1px solid #fff;border-right:1px solid #fff;}
			#hangye th.more2 { width:80px; font-weight:normal;  }
            #hangye th a{color:#07519A }
			#hangye td { text-align:center}
			#hangye td a { margin: 0 15px;}
			#hangye .bk { background-color:#EAF5FF;}
			#hangye tr { height:30px; line-height:30px;}
		</style>
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
                            <input type="hidden" name="ie" value="utf-8" />
                           
                        </form>
                     </div></div>   
                        
                        
                    </div>
                    <!--/ sengine-->
                    
                </div>
            </div>
            <h1 id="logo"><a href="#"><img src="/static/images/logo.gif" height="69" width="117" /></a></h1>
            <div id="city" style="display:none">
               
            </div><!--/ city-->
            
            
        </div><!--/ header-->
        
        <div id="guide" class="bd">
    <dl>
    <dt>����ǰ��λ�ã�</dt>
    <dd><a href="<{$URL}>" target="_parent">��ҳ</a><em>&gt;</em></dd>
    <dd>��ҵ��վ</dd>

    </dl>
    <ul>
    <li class="sethome"><a href="javascript:void(0)"  onclick="Yl.setHome(this,'<{$URL}>')" target="_parent" class="gray6">�豾վΪ��ҳ</a></li>
    <li class="feedback"><a href="<{$URL}>/feedback/" class="gray6">��������</a></li>
    </ul>
    </div><!--/ guide-->
        
    <div class="bd" id="cate">
    <h3>��ҵ��վ</h2>
    <table border="0" id="hangye" cellspacing="0" cellpadding="0">

<tbody>
<{foreach from = $trade_class_list key = k item = parent name = n}>
  <tr <{if $smarty.foreach.n.iteration % 2 eq 0}> class="bk"<{/if}>>
    <th><a><{$parent.classname}></a></th>
    <td>
    <{foreach from = $parent.sites.data item = v}>
        <a href="<{$v.url}>" target="_blank" <{if $v.namecolor}> style="color:<{$v.namecolor}>"<{/if}>><{$v.name}></a>
    <{/foreach}>
    </td>
  </tr>
<{/foreach}>
</tbody>
</table>

    	
    
    
	</div>

        
        <div id="meta" class="clearfix bd">
        	<p>
            <a href="<{$URL}>" class="back"><span>����</span><em class="fl">����</em></a>
        	<a class="close" href="javascript:closeWin()" target="_self"><span>�ر�</span><em class="fl">�ر�</em></a>
            </p>

        </div>
        <div id="gotop" class="clearfix"><a href="#page" target="_parent">���ض���</a><br />
<br />
</div>
     
      
        
        <a href="javascript:void(0)" target="_self" id="addmyfav" style="display:none;" title="��ӵ��Զ����ղؼ�">������ҳ�Զ����ղ�</a>
        
        
    </div><!--/ wrap-->
</div>
<!--/ page-->
<script type="text/javascript">
	function closeWin(){
	   window.open("","_self");
	   window.top.opener=null;
	   window.top.close();
	 }
</script>
<script type="text/javascript" src="/themes/default/js/page.js"></script>
<div style="display:none"><{$tongji}></div>
</body>
</html>
