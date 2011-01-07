<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<{$charset|default:GBK}>" />
<title></title>
<link href="static/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="static/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="static/js/sidebar.js"></script>
</head>
<body id="sidebar_page">
<div class="wrap">
    <div class="cotainer">
        <div id="sidebar">
        <div class="home">
            <a href="<{$URL}>" target="_blank">网站首页</a> - <a href="http://www.ylmf.net/thread.php?fid=346" target="_blank">论坛专区</a>
        </div>
        <div class="con">
        <!--公用-->
        <h2>管理首页</h2>
        <p class="userpanel">       
        用户名：<{$smarty.const.USERNAME}><br />
        级　别：<{if 1==$smarty.const.If_manager}>超级管理员<{else}>管理员<{/if}><br />
        <a href="?c=member&a=member_password&name=<{$smarty.const.USERNAME}>" target='main'>密 码</a> |
        <a href="?c=login&a=welcome" target='main'>主 页</a>|
        <a href="?c=login&a=logout" target="_parent">退 出</a>
        </p>
        <{$data}>
        </div><!--/ .con-->
        </div><!--/ sidebar-->
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    var aArr = $(".con").find("li:first a");
    if (aArr && aArr.html() == "一键生成选择")
	//if (aArr)
    {
		//alert(aArr.html())
        aArr.addClass("active");
        $('#main', window.parent.document).attr('src', aArr.attr('href'));
    }
})
</script>
</body>
</html>
