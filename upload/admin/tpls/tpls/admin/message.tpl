<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>网址跳转中……</title>
<link href="static/css/style.css" rel="stylesheet" type="text/css" />
<link href="static/css/style-zdb.css" rel="stylesheet" type="text/css" />
</head>
<body>







<div class="success">
                    
                    <p>&nbsp;</p>
                    <p><strong><{$message}> <span id="seconds" style="color:#f60;">2</span>秒后自动返回</strong>
                  </p>
                    <p><a href="<{$url_page}>" id="url">如果您的浏览器没有自动跳转，请点击这里！ </a>
                    </p>
                    <p>&nbsp;</p>
                
              </div>
              
              
<{if $stop_loop!=1}>
<script type="text/javascript">

var i = 2;
var reTime = setInterval(function(){
	i = i-1;
	if(i<0){
		
		window.location.href= '<{$url_page}>'
		window.clearInterval(reTime);
		return;
		
	}
	document.getElementById("seconds").innerHTML = i;
},1000);

</script>
<{/if}>
</body>

</html>
