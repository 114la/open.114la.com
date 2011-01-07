<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="keywords" content="<{$class_meta_keyword}>" />
<meta name="description" content="<{$class_meta_description}>" />
<title><{$title}></title>
<link rel="stylesheet" type="text/css" href="<{$URL}>/public/page/style.css" media="all" />
<link id="skin" rel="stylesheet" type="text/css" href="" />
<script type="text/javascript" src="<{$URL}>/public/page/js/skin.js"></script>
<base target="_blank" />
</head>
<body>
<div id="page" class="container">
    <div id="header" class="box">
        <div class="con clearfix">
            <h1 id="logo"><a href="<{$URL}>"><img src="<{$URL}>/static/images/logo.gif" alt="" /></a></h1>
            <div class="searchform">
                <form id="searchForm" action="http://115.com/s" method="get" target="_blank">
                    <a class="label" href="http://115.com"><img width="105" height="35" alt="115聚搜" src="<{$URL}>/static/images/s/115.gif"></a>
                    <input type="text" name="q" class="text" autocomplete="off">
                    <input type="submit" class="submit" value="115聚搜">
                    <input type="hidden" name="tn" value="ylmf_4_pg">
                    <input type="hidden" name="ch" value="6">
                </form>
                <div class="ctrl">
                    <form id="ctrl_form">
                        <label for="s115_item"><input class="radio" type="radio" value="s115" name="search_select"  checked="checked" id="s115_item" />115聚搜</label>
                        <label for="baidu_item"><input class="radio" type="radio" value="baidu" name="search_select" id="baidu_item" />百度</label>
                        <label for="google_item"><input class="radio" type="radio" value="google" name="search_select" id="google_item" />Google</label>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="guide clearfix"><span class="location"><strong>您当前的位置：</strong><a href="<{$URL}>" target="_parent">导航首页</a> &raquo; <span>友情连接</span></span>
    <span class="meta"><a href="<{$URL}>/feedback/" class="feedback">留言反馈</a><a href="javascript://"  onClick="this.style.behavior='url(#default#homepage)';this.setHomePage('<{$URL}>')" class="sethome" target="_parent">把114啦设为主页</a></span></div>
    
    

      <div class="box"><b class="rc-tp"><b></b></b>
        <div class="site-list">
                <h2>友情链接</h2>
                <ul class="clearfix">
                <{foreach from=$data item=row}>
                	<li><a href="<{$row.site_url}>" target="_blank"><{$row.site_name}></a></li>
                <{/foreach}>
                 </ul>
         </div>
      <b class="rc-bt"><b></b></b></div>

        
    
    
    <div id="footer" class="clearfix"> <a href="<{$URL}>" target="_parent">返回首页</a> </div>
    <div id="gotop"><a href="#page" target="_self">返回顶部</a></div>
</div>
<script type="text/javascript" src="<{$URL}>/public/js/ylmf.js"></script>
<script type="text/javascript" src="<{$URL}>/public/page/js/common.js"></script>
<div style="display:none"><{$tongji}></div>
</body>
</html>