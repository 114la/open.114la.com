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
            <a href="<{$URL}>" target="_blank">��վ��ҳ</a> - <a href="http://www.ylmf.net/thread.php?fid=346" target="_blank">��̳ר��</a>
        </div>
        <div class="con">
        <!--����-->
        <h2>������ҳ</h2>
        <p class="userpanel">       
        �û�����<{$smarty.const.USERNAME}><br />
        ������<{if 1==$smarty.const.If_manager}>��������Ա<{else}>����Ա<{/if}><br />
        <a href="?c=member&a=member_password&name=<{$smarty.const.USERNAME}>" target='main'>�� ��</a> |
        <a href="?c=login&a=welcome" target='main'>�� ҳ</a>|
        <a href="?c=login&a=logout" target="_parent">�� ��</a>
        </p>
        <{$data}>
        </div><!--/ .con-->
        </div><!--/ sidebar-->
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    var aArr = $(".con").find("li:first a");
    if (aArr && aArr.html() == "һ������ѡ��")
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
