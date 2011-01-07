<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>雨林木风后台管理系统--登录</title>
<style type="text/css">
	html,body { height:100%; width:100%; overflow:hidden;}
	#loadding {
        background:#DCE2BF;
        filter:alpha(opacity=80);
        left:0;
        opacity:0.8;
        position:absolute; 	 
        top:0;		
        z-index:800;
        -ms-filter:"alpha(opacity=80)";   
		width:100%;
        height:100%;
}
.wait { height:60px; line-height:19px; width:220px; z-index:1000; color:#000;
     position: absolute;
     text-align:center;
      color:#8B9F27;
       font-family:Tahoma, Geneva, sans-serif;
     left:50%;
     top:305px;
     margin: -20px 0 0 -110px;
      font-size:12px;
     font-weight:bold;
}
</style>
<link href="static/css/style.css" rel="stylesheet" type="text/css" />
<link href="static/css/style-zdb.css" rel="stylesheet" type="text/css" />
</head>

<body>
<script type="text/javascript">
setTimeout("window.location.href= '<{$url_page}>' ",<{$timeout}>);
</script>
<div id="loadding">
	
</div>
<div class="wait" style="color:#090;">
&radic; 登陆成功，页面载入中……<br />
<a href="<{$url_page}>" id="url">如果您的浏览器没有自动跳转,<br />
请点击这里！</a><br />
<img src="static/images/loadding.gif" align="baseline" />
</div>

</body>
</html>
