<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>������� - <{$sysname}></title>
<link href="<{$URL}>/feedback/images/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<{$URL}>/feedback/images/jquery.js"></script>
<script language="javascript" type="text/javascript" src="<{$URL}>/feedback/images/feedback.js"></script>
</head>
<body>
<div class="wrap">
	<div id="header">
    	<div class="container">

    	<h1 class="logo"><a href="./" ><{$sysname}>-�������</a></h1>
    	<div id="menu">
        	<ul>
			    <li><a href="http://www.114la.com" class="home" >114����ַ����</a></li>
            	<li><a href="http://www.ylmf.com" class="ylmf" target=_blank>����ľ��</a></li>
                <li><a href="http://www.ylmf.net" class="bbs" target=_blank>������̳</a></li>
                <li><a href="http://www.xiazaiba.com" class="xiazaiba" target=_blank>��ɫ���ذ�</a></li>
                <li><a href="http://115.com" class="search" >115�ۺ�����</a></li>
            </ul>
        </div>
        </div>
    </div>
	
    <div id="content" class="container">
    	<div id="feedbackbox">
        	<h2>
			�ǳ���л���Ա�վ��֧�ֺ͹�ע�������������������������ͽ��飡<br>����Ҳ���޷�һһ�ظ��������ǻ������Ķ�������֧�����������Ķ�����</h2>

        	<div class="box-top"></div>
            <div class="con">
            
        	<form id="feedback-form" onsubmit="return false;">
           		<input type="hidden" name="token" value="cb4bfc1df93591e5cc4adcd5aed1f28f3558c2e2"/>
            	<ul onmouseover="this.className = 'hover'" onmouseout="this.className = ''">

            	<li>
                <p><label for="name">�����ǳƣ�</label></p>
                <input id="name" type="text" class="int" onfocus="inputFocus(this)" onblur="inputBlur(this)" name="username" maxlength="20" value=""/>
                </li>
                </ul>
                <ul onmouseover="this.className = 'hover'" onmouseout="this.className = ''">
                <li>
                <p><label for="email">��ϵEmail��</label><span id="msg1">Ϊ�������Ǽ�ʱ�ظ����������������������ʵEmail��</span></p>

                <input id="email" type="text" class="int" onfocus="inputFocus(this)" onblur="inputBlur(this)" name="email" maxlength="30" value="" /></li>
                </ul>
                <ul onmouseover="this.className = 'hover'" onmouseout="this.className = ''">
                <li>
                <p><label for="feedback">��������飺</label><span id="msg2">���Ҫ�������Ա�վ���������(20-300������)��лл�� <strong style="color:#F00">*</strong></span></p>
                <textarea id="feedback" class="int" onkeyup="displaySpareNumber(this,300)" onchange="displaySpareNumber(this,300)" onfocus="inputFocus(this)" onblur="inputBlur(this)" name="content"></textarea>
                <p id="spareNumberBox">��ʣ<span><input value="300" id="spareNumber" style="border:none; color:red; width:40px; text-align:center; background:none;" readonly="readonly"  /></span> ����</p>

                </li>
                </ul>
                <div id="messageBox"></div>
                <div class="form-fot">
                	<input id="submit-btn" type="submit" class="btn" name="button"  value="�� ��" />
                </div>
            </form>
            </div>

            <div class="box-fot"></div>
        </div>
    
    </div>
    
   <div id="footer"> 
            <div class="hr"></div>
            <{$sysname}>��&copy;2005-<script type="text/javascript">document.write(new Date().getFullYear());</script> . All Rights Reserved.
        </div>
</div>
<div style="display:none"><{$tongji}></div>
</body>
</html>
