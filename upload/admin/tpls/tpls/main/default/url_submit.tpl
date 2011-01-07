<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>网站提交 ->  网站收录提交入口 -<{$sysname}></title>
<style>
<!--
body { background:#3C7FAF url(<{$URL}>/satatic/images/bd_bg.png) repeat-x top; margin:0; font:12px Verdana; color:#07519A; }
a { color:#07519A; text-decoration:none; }
a:hover { color:#F00; }
form { margin:0; padding:0; }
#wrap { width:760px; margin:auto; padding:0 10px; background:#FFF; }
h2 { font:bold 12px/26px Verdana; padding:0 8px; margin:0; border:1px solid #ACE; border-bottom:none; background:#EDF6FF; }
h2 em { font:normal 12px/26px Verdana; color:#E00; margin-left:15px; }
h3 { font:bold 12px/24px Verdana; padding:0; margin:0; }
.record { width:100%; border:solid #ACE; border-width:1px 1px 0 0; }
.record th { width:120px; line-height:18px; padding:3px 8px; background:#EDF6FF; border:solid #ACE; border-width:0 0 1px 1px; font-weight:normal; text-align:left; }
.record td { line-height:18px; padding:3px 8px; border:solid #ACE; border-width:0 0 1px 1px; }
td.bot { text-align:center; background:#EDF6FF; }
.record em { margin-left:8px; font-style:normal; color:#E00; }
.record .txt { border:1px solid #ACE; font:12px Verdana; color:#07519A; width:180px; padding:2px 3px; }
.record textarea { border:1px solid #ACE; width:65%; height:60px; font:12px/18px Verdana; color:#07519A; }
.record .btn { border:1px solid #ACE; font:12px Verdana; height:22px; line-height:19px; background:#DAECFE; color:#07519A; padding:0 5px; }
.con { padding:8px; line-height:18px; }
.con em { font-style:normal; color:#E00; }
.con p { padding:5px 0; margin:0; }
.con th { font-weight:normal; }
.urltxt { border:1px solid #ACE; font:12px Verdana; padding:2px 3px; margin:3px 0; color:#07519A; width:300px; }

a img { border:none; }
ul,dl,dt,dd { padding:0; margin:0; list-style:none; }
form { margin:0; }
#header { width:760px; margin:auto; overflow:hidden; }
#elogin { font:12px/27px Verdana; background:#EBF3FB; border:1px solid #ACE; padding:0 12px; }
#elogin label a { margin-right:8px; }
#elogin .r { float:right; }
#banner { padding:6px 0 0 5px; }
#logo { float:left; width:124px; height:70px; overflow:hidden; }
#money { float:right; height:62px; padding-top:8px; overflow:hidden; }
#money .mcon { float:left; height:60px; margin-left:5px; border:1px solid #ACE; overflow:hidden; }
#hotag{ float:left; margin-left:5px; width:470px; height:54px; background:url(http://www.114la.com/images/hot_key.png); padding:4px 0; position:relative; }
#hotag a{ float:left; width:67px; height:18px; text-align:center; white-space:nowrap; overflow:hidden; font:12px/18px Verdana; }
#hotag form{ position:absolute; left:334px; top:43px; width:130px; margin:0; padding:0; }
#hotag input{ float:left; }
#hotag .txt{ width:93px; height:13px; background:none; border:none; padding:0 2px; font:12px Verdana; margin-right:6px; }
#hotag .btn{ width:24px; height:13px; padding:0; background:none; border:none; }
#footer { width:760px; margin:auto; font:11.5px/18px Verdana; text-align:center; padding:8px 0; border-top:3px solid #AACCEE; }
#footer .link { width:510px; line-height:22px; margin:auto; background:url(<{$URL}>/static/images/sitem_bg.gif) repeat-x bottom; }
#footer .hr {
border-bottom:1px dashed #AACCEE;
height:0;
margin:8px 20%;
overflow:hidden;
}
-->
</style>

<script language="javascript">function addBookmark(title,url) {
    if (window.sidebar) {
        window.sidebar.addPanel(title, url,"");
    } else if( document.all ) {
        window.external.AddFavorite( url, title);
    } else if( window.opera && window.print ) {
        return true;
    }
}</script>
<script type="text/javascript" language="javascript">
 Validator = {
	Require : /.+/,
	Email : /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/,
	Phone : /^((\(\d{3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}$/,
	Mobile : /^((\(\d{3}\))|(\d{3}\-))?(13\d{1}|15[0-9]{1})\d{8}$/,   /*新加入了移动的159开头手机号码*/
	YDMobile : /^((\(\d{3}\))|(\d{3}\-))?(13[4-9]{1}|15[15689]{1})\d{8}$/, 
	LTMobile : /^((\(\d{3}\))|(\d{3}\-))?(13[0-3]{1}|15[23]{1})\d{8}$/, 
	Url : /^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/,
	IdCard : /^\d{15}(\d{2}[A-Za-z0-9])?$/,
	Currency : /^\d+(\.\d+)?$/,
	Number : /^\d+$/,
	Zip : /^[1-9]\d{5}$/,
	QQ : /^[1-9]\d{4,10}$/,
	Integer : /^[-\+]?\d+$/,
	Double : /^[-\+]?\d+(\.\d+)?$/,
	English : /^[A-Za-z]+$/,
	Chinese :  /^[\u0391-\uFFE5]+$/,
	UnSafe : /^(([A-Z]*|[a-z]*|\d*|[-_\~!@#\$%\^&\*\.\(\)\[\]\{\}<>\?\\\/\'\"]*)|.{0,5})$|\s/,
	IsSafe : function(str){return !this.UnSafe.test(str);},
	SafeString : "this.IsSafe(value)",
	Limit : "this.limit(value.length,getAttribute('min'),  getAttribute('max'))",
	LimitB : "this.limit(this.LenB(value), getAttribute('min'), getAttribute('max'))",
	Date : "this.IsDate(value, getAttribute('min'), getAttribute('format'))",
	Repeat : "value == document.getElementsByName(getAttribute('to'))[0].value",
	Range : "getAttribute('min') < value && value < getAttribute('max')",
	Compare : "this.compare(value,getAttribute('operator'),getAttribute('to'))",
	Custom : "this.Exec(value, getAttribute('regexp'))",
	Group : "this.MustChecked(getAttribute('name'), getAttribute('min'), getAttribute('max'))",
	ErrorItem : [document.forms[0]],
	ErrorMessage : ["以下原因导致提交失败：\t\t\t\t"],
	Validate : function(theForm, mode){
		var obj = theForm || event.srcElement;
		var count = obj.elements.length;
		this.ErrorMessage.length = 1;
		this.ErrorItem.length = 1;
		this.ErrorItem[0] = obj;
		for(var i=0;i<count;i++){
			with(obj.elements[i]){
				var _dataType = getAttribute("dataType");
				if(typeof(_dataType) == "object" || typeof(this[_dataType]) == "undefined")  continue;
				this.ClearState(obj.elements[i]);
				if(getAttribute("require") == "false" && value == "") continue;
				switch(_dataType){
					case "Date" :
					case "Repeat" :
					case "Range" :
					case "Compare" :
					case "Custom" :
					case "Group" : 
					case "Limit" :
					case "LimitB" :
					case "SafeString" :
						if(!eval(this[_dataType]))	{
							this.AddError(i, getAttribute("msg"));
						}
						break;
					default :
						if(!this[_dataType].test(value)){
							this.AddError(i, getAttribute("msg"));
						}
						break;
				}
			}
		}
		if(this.ErrorMessage.length > 1){
			mode = mode || 1;
			var errCount = this.ErrorItem.length;
			switch(mode){
			case 2 :
				for(var i=1;i<errCount;i++)
					this.ErrorItem[i].style.color = "red";
			case 1 :
				alert(this.ErrorMessage.join("\n"));
			//document.getElementById("message").innerHTML = this.ErrorMessage.join("<br />");
				this.ErrorItem[1].focus();
				break;
			case 3 :
				for(var i=1;i<errCount;i++){
				try{
					var span = document.createElement("SPAN");
					span.id = "__ErrorMessagePanel";
					span.style.color = "red";
					this.ErrorItem[i].parentNode.appendChild(span);
					span.innerHTML = this.ErrorMessage[i].replace(/\d+:/,"*");
					}
					catch(e){alert(e.description);}
				}
				this.ErrorItem[1].focus();
				break;
			default :
				alert(this.ErrorMessage.join("\n"));
			//document.getElementById("message").innerHTML = this.ErrorMessage.join("<br />");
				break;
			}
			return false;
		}
		return true;
	},
	limit : function(len,min, max){
		min = min || 0;
		max = max || Number.MAX_VALUE;
		return min <= len && len <= max;
	},
	LenB : function(str){
		return str.replace(/[^\x00-\xff]/g,"**").length;
	},
	ClearState : function(elem){
		with(elem){
			if(style.color == "red")
				style.color = "";
			var lastNode = parentNode.childNodes[parentNode.childNodes.length-1];
			if(lastNode.id == "__ErrorMessagePanel")
				parentNode.removeChild(lastNode);
		}
	},
	AddError : function(index, str){
		this.ErrorItem[this.ErrorItem.length] = this.ErrorItem[0].elements[index];
		this.ErrorMessage[this.ErrorMessage.length] = this.ErrorMessage.length + ":" + str;
	},
	Exec : function(op, reg){
		return new RegExp(reg,"g").test(op);
	},
	compare : function(op1,operator,op2){
		switch (operator) {
			case "NotEqual":
				return (op1 != op2);
			case "GreaterThan":
				return (op1 > op2);
			case "GreaterThanEqual":
				return (op1 >= op2);
			case "LessThan":
				return (op1 < op2);
			case "LessThanEqual":
				return (op1 <= op2);
			default:
				return (op1 == op2);            
		}
	},
	MustChecked : function(name, min, max){
		var groups = document.getElementsByName(name);
		var hasChecked = 0;
		min = min || 1;
		max = max || groups.length;
		for(var i=groups.length-1;i>=0;i--)
			if(groups[i].checked) hasChecked++;
		return min <= hasChecked && hasChecked <= max;
	},
	IsDate : function(op, formatString){
		formatString = formatString || "ymd";
		var m, year, month, day;
		switch(formatString){
			case "ymd" :
				m = op.match(new RegExp("^((\\d{4})|(\\d{2}))([-./])(\\d{1,2})\\4(\\d{1,2})$"));
				if(m == null ) return false;
				day = m[6];
				month = m[5]--;
				year =  (m[2].length == 4) ? m[2] : GetFullYear(parseInt(m[3], 10));
				break;
			case "dmy" :
				m = op.match(new RegExp("^(\\d{1,2})([-./])(\\d{1,2})\\2((\\d{4})|(\\d{2}))$"));
				if(m == null ) return false;
				day = m[1];
				month = m[3]--;
				year = (m[5].length == 4) ? m[5] : GetFullYear(parseInt(m[6], 10));
				break;
			default :
				break;
		}
		if(!parseInt(month)) return false;
		month = month==12 ?0:month;
		var date = new Date(year, month, day);
        return (typeof(date) == "object" && year == date.getFullYear() && month == date.getMonth() && day == date.getDate());
		function GetFullYear(y){return ((y<30 ? "20" : "19") + y)|0;}
	}
 }

   function copyToClipBoard(clipBoardContent){
    window.clipboardData.setData("Text",clipBoardContent); 
    alert("地址已经复制成功，您可以粘贴到其他需要的地方！"); 
  } 
</script>
</head>
<body>
<div id="wrap">
<div id="header">
  <div id="elogin">
    <div class="r"><a href="#" onclick="javascript:this.style.behavior='url(#default#homepage)';this.setHomePage('<{$URL}>');">设为首页</a> | <a href="javascript:addBookmark('<{$sysname}>','<{$URL}>');">加入收藏</a></div>
      <a href="<{$URL}>" target="_blank"><<返回首页</a>　 <a href="http://fav.115.com" >网络收藏夹</a>
    <label></label>
  </div>
  <div id="banner">
    <div id="money">
    <div class="mcon"><a href="http://u.115.com/?13"><img alt="115网络U盘" src="http://www.114la.com/image/115-u_1.gif"　target="_blank" /></a></div>

    </div>
    <div id="logo"><a href="<{$URL}>/" target="_top"><img src="<{$URL}>/static/images/logo.gif" alt="LOGO"/></a></div>
  </div>
</div>
<div class="con">
    <h3>如果您希望<a href="<{$URL}>" target="_blank"><{$sysname}></a> 收录您的网站，贵站需要满足以下条件（即收录原则）： </h3>
    <p>1. 不收录有反动、色情、赌博等不良内容或提供不良内容链接的网站，以及网站名称或内容违反国家有关政策法规的网站；<br />
      2. 不收录含有病毒、木马，弹出插件或恶意更改他人电脑设置的网站、及有多个弹窗广告的网站；<br />
      3. 不收录网站名称和实际内容不符的网站，请不必现在申请收录，欢迎您在贵站建设完毕后再申请； <br />
      4. 不收录以同类型网站通用名称文字作为申请的名称，例如&ldquo;在线音乐&rdquo;，请以适当的网站名做为申请名称，如xiazaiba.com的网站中文名是&ldquo;<a href=http://www.xiazaiba.com/" target="_blank">绿色下载吧</a>&rdquo;； <br />
      5. 不收入非顶级域名、挂靠其他站点、无实际内容，只提供域名指向的网站或仅有单页内容的网站； <br />
      6. 不收录在正常情况下无法访问的网站 <br />
      7. 公益性网站，或内容确实有独特之处的网站将优先收录 </p>
	<p><em>特别强调:
        <br />     
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 本站仅收录PR值大于等于 2，Alexa 排名 100W 以内，BAIDU、GOOGLE 均有收录，健康有内容并每日更新，且具有真实的信息产业部 ICP/IP 备案信息的各类网站。<br />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 如果不能满足上述要求的站点，若具有公益性质，或内容确实有独特之处的网站，可以填写较充分理由申请，我们将酌情收录。
 <br />
&nbsp;&nbsp;&nbsp;&nbsp; 一些购物类网站等盈利性站点，请直接联系本站客服进行广告服务咨询。我们将为您提供最佳广告位！
</em></p>
    <p>本站保留收录决定权以及贵站在本站网址数据库中相关内容的编辑决定权 </p>
  </div>
  <{if $message}><h2 style="color: blue;"><{$message}></h2><{/if}>
  <form action="<{$URL}>/url-submit/" method="post" onSubmit="return Validator.Validate(this,3)" name='siteadd' id="siteadd">
    <input type="hidden" name="action" value="add"/>
    <table border="0" cellpadding="0" cellspacing="0" class="record">
      <tr>
        <th>网站名称：</th>

        <td><input name="name" type="text" class="txt" id="name" value="" dataType="Require"  msg="网站名称不能为空" />
        	<em>*</em></td>
      </tr>
      <tr>
        <th>网站网址：</th>
        <td><input name="siteurl" type="text" class="txt" id="siteurl" value=""  dataType="Url"  msg="网站地址要以http://开头" />
        	<em>*</em></td>
      </tr>
      <tr>
        <th>网站简介：</th>

        <td><textarea name="jianjie" cols="" rows="" id="jianjie" dataType="Require"  msg="网站简介不能为空">
</textarea>
          	<em>* </em>请将您的描述控制在200字以内</td>
      </tr>

      <tr>
        <th>网站分类：</th>
        <td><input name="class" type="text" class="txt" id="class" value="" dataType="Require"  msg="网站分类不能为空" />
          	<em>*</em> 依据贵站定位写明详细分类  如&ldquo;音乐MP3-在线音乐&rdquo;</td>
      </tr>
	  
	  <tr>

        <th>腾讯QQ：</th>
        <td><input name="qq" type="text" class="txt" id="qq" value="" dataType="QQ"  msg="QQ不正确!" onkeyup="value=value.replace(/[^\d]/g,'') "   />
        	<em>* </em></td>
      </tr>
	  
	  <tr>
        <th>电子邮件：</th>
        <td><input name="email" type="text" class="txt" id="email" value=""  dataType="Email"  msg="电子邮件地址不正确!" />

         <em>* 请填写最常用的邮箱,用于发送收录审核情况! </em></td>
      </tr>
	  <tr>
        <th>网站访问量：</th>
        <td><input name="pv" type="text" class="txt" id="pv" value="" />
          日独立IP</td>

      </tr>
      <tr>
        <th>网站备案信息：</th>

        <td><input name="icp" type="text" class="txt" id="icp" value=""/></td>
      </tr>
      <tr>
        <th>建站时间：</th>
        <td><input name="sitetime" type="text" class="txt" id="sitetime" value="" /></td>
      </tr>
      <tr>

        <th>联 系 人：</th>
        <td><input name="lianxiren" type="text" class="txt" id="lianxiren" value=""/></td>
      </tr>
      <tr>
        <th>通讯地址：</th>
        <td><input name="address" type="text" class="txt" id="address" value="" /></td>
      </tr>

      <tr>
        <th>手机号码：</th>
        <td><input name="mobile" type="text" class="txt" id="mobile" value="" /></td>
      </tr>
      <tr>

        <th>固定电话：</th>
        <td><input name="tel" type="text" class="txt" id="tel" value=""/>
        区号-电话号码</td>
      </tr>
      
      <tr>
        <th>友情链接：</th>
        <td><input name="sharelink" type="radio" value="1" />
          是
          <input name="sharelink" type="radio" value="0" checked="checked" />
          否<em>(是否已做好本站友情链接)此项为可选,如有做链接将优先收录</em></td>

      </tr>
      <tr>
        <td colspan="2" class="bot"><input type="submit" value="提交申请" class="btn" />
          <input type="reset" value="重新填写" class="btn" />
          </td>
      </tr>
    </table>
  </form>
  <div class="con">以上内容请仔细填写，工作人员将认真审核每一个站点，并做备案记录，连续申请多次不通过的网站将自动列入黑名单并不再收录，此举是为了广大网民的利益，如果您没有做好自己站点内容的准备，请勿浪费时间提交申请。</div>

  <div class="con">
   <h3>友情链接示例</h3>
  <table>
  <tr>
    <th>网站说明：</th>
    <td>114啦网址导航</td>
  </tr>

  <tr>
    <th>首页地址：</th>
    <td><input name="input" type="text" onclick="copyToClipBoard(this.value)" value="<{$URL}>" class="urltxt" /></td>
  </tr>
  <tr>
    <th>图片链接：</th>
    <td><img src="<{$URL}>/static/images/8831-logo.gif" alt="<{$sysname}>" width="88" height="31" /></td>
  </tr>

  <tr>
    <th>首页地址：</th>
    <td><input name="input1" type="text" class="urltxt" id="input1" onclick="copyToClipBoard(this.value)" value="<{$URL}>" /></td>
  </tr>
  <tr>
    <th>Logo地址：</th>
    <td><input name="input2" type="text" class="urltxt" id="input2" onclick="copyToClipBoard(this.value)" value="<{$URL}>/logo.gif" /></td>
  </tr>

  <tr>
    <th>网站简介：</th>
    <td><{$sysname}></td>
  </tr>
</table>
  </div>
<div id="footer"> <a href="http://www.114la.com/114la/index.html" target="_blank">关于114啦建站系统V1.13</a> | <a href="<{$URL}>/url-submit/" target="_blank">网站提交</a> | <a href="<{$URL}>/feedback" target="_blank">意见反馈</a> | <a href="http://www.114la.com/gongyihuodong/index.htm" target="_blank">公益活动</a> 
            <div class="hr"></div>
           Powered by <a href="http://www.114la.com/">114啦网址导航</a>&copy;2005-<script type="text/javascript">document.write(new Date().getFullYear());</script> . All Rights Reserved.
        </div>
        <!--/ footer-->
<div style="display:none">
<{$tongji}>
</div>

</div>

</body>
</html>
