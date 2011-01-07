<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<{$charset|default:GBK}>" />
<title></title>
<link href="static/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="static/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="static/js/common.js"></script>
</head>
<body id="main_page">
		<div id="nav" style="display:none;">
		<dl>
		<dt>当前位置：</dt>
            <{foreach from=$npa item=cp}>
		    <dd class="link"><{$cp}></dd><!--导航-->
            <{foreachelse}>
		    <dd class="link">管理首页</dd><!--导航-->
            <{/foreach}>
		</dl>
		</div>

<script type="text/javascript">
	if ($.browser.msie) {
		document.execCommand("BackgroundImageCache", false, true);
	}
	var nav = document.getElementById("nav");
	var pnav = window.parent.document.getElementById("nav")
	pnav.innerHTML = nav.innerHTML;

</script>

<{ if $error}><{ if $error}><div class="con" style="padding:7px 5px 2px 5px; font-size:13px; color:#F33;"><div class="tips mb5" style=" background:url(static/images/infor-ico.gif) no-repeat 15px center #FFF8CC; padding-left:45px"><{$error}></div></div><{/if}><{/if}>
