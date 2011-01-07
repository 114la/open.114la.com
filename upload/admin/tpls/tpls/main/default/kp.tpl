<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=7">
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="keywords" content="<{$index_meta_keyword}>" />
<meta name="description" content="<{$index_meta_description}>" />
<title><{$title}></title>
<link href="<{$URL}>/public/home/base.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#wrap { width:1180px; margin: 0 auto; }
#main { width:955px; }
#ls dd.l { width:833px; }
#ls dd.l a { margin: 0 18px; }
#qs-result { width:953px; }
#bn { width:845px; display:inline; overflow: hidden; }
#google { margin-left:5px; }
#sw { width:430px; }
#sw a { margin:0 8px; }
#hot a { margin:0 10px; }
#hot2 a { margin:0 15px; }
#meta li a { margin:0 25px 0 0; }
#settingBox { margin-left:914px; }
#ls dl { font-family:Tahoma, Helvetica, Arial, "\5b8b\4f53", sans-serif; font-size:14px }

#bm li{ width:84px;}
#bm li.active { width:85px;background-position:0 -708px; }
#bm li#bm-def.active { width:84px;}
#q_int .button-wrap { width:148px;background-position: -5px -354px}
#qs { width:161px;}
</style>
<style id="temp-css" type="text/css"></style>
<script type="text/javascript" src="<{$URL}>/public/home/js/base.js"></script>
<script type="text/javascript" src="<{$URL}>/public/home/js/core.js"></script>
<base target="_blank" />
</head>
<body>
<em class="filter" style="display:none;"></em>
<div id="wrap">
    <div id="top" class="clearfix">
        <div id="weather"><script>if(top.location == self.location){document.write('<iframe width="540" height="22" frameborder="0" scrolling="no" allowtransparency="true" src="public/widget/weather/index.html"></iframe>')} </script> </div>
        <ul id="set">
            <li class="sethome"><a onclick="Yl.setHome(this,this.href); return false;" target="_self" href="http://www.114la.com/?114la">��114����Ϊ��ҳ</a></li>
            <li><a href="/" target="_parent" onclick="Cookie.clear('layout')">��׼��</a> | <a href="./kp.html" class="active" target="_parent">������</a></li>
            <li id="skinlist"><a class="blue" title="��ɫ">1</a><a class="green" title="��ɫ">2</a><a class="pink" title="��ɫ">3</a></li>
            <li class="setting"><a target="_self" href="javascript:void(0);" id="showSetting">��������</a></li>
        </ul>
    </div>
    <div id="header">
        <div class="box clearfix">
            <h1 id="logo"><a href="<{$URL}>" target="_parent" title="114����ַ����"><img src="<{$URL}>/static/images/logo.gif" height="69" width="117" /></a></h1>
            <div id="email_114la">
                <form id="mail" name="mail" method="post" onsubmit="MailLogin.sendMail();return false;" action="" target="_blank">
                    <ul>
                        <li>
                            <label for="mail_user_114la">�ʺţ�</label>
                            <input type="text" id="mail_user_114la" class="int" />
                        </li>
                        <li>
                            <label for="mail_server_114la">���䣺</label>
                            <select id="mail_server_114la" onchange="MailLogin.change(this)">
                                <option selected="selected">--��ѡ������--</option>
                                <option>@163.com ����</option>
                                <option>@126.com ����</option>
                                <option>@vip.163.com ����</option>
                                <option>@sina.com ����</option>
                                <option>@vip.sina.com ����</option>
                                <option>@yahoo.com.cn</option>
                                <option>@yahoo.cn</option>
                                <option>@sohu.com �Ѻ�</option>
                                <option>@tom.com</option>
                                <option>@21cn.com</option>
                                <option>@yeah.net</option>
                                <option>�����ʺ�</option>
                                <option>�ٶ��ʺ�</option>
                                <option>������</option>
                                <option>51.com</option>
                                <option>ChinaRen</option>
                                <option style="color:#36c;">--�������ڵ���ҳ��¼&darr;--</option>
                                <option>������</option>
                                <option>QQ�ռ�</option>
                                <option>@qq.com</option>
                                <option>@139.com</option>
                                <option>@gmail.com</option>
                                <option>@hotmail.com</option>
                                <option>@188.com</option>
                            </select>
                        </li>
                        <li>
                            <label for="mail_passwd_114la">���룺</label>
                            <input type="password" id="mail_passwd_114la" class="int" />
                            <input type="submit" value="�� ¼" id="mail_submit_114la" class="btn" />
                        </li>
                    </ul>
                </form>
            </div>
            <div id="bn">
                <ul id="cal">
                    <li class="date"><script type="text/javascript">document.write(Calendar.day());</script> </li>
                    <li class="lcal"><script type="text/javascript">document.write(Calendar.cnday());</script> </li>
                    <li class="m"><a href="http://tool.115.com/live/calendar/" class="hl">����</a><a href="http://astro.114la.com/" class="yc">�˳�</a><a href="public/widget/clock/index.html" class="clock">����</a></li>
                </ul>
                <div id="bn2" class="fl">
                <script type="text/javascript" src="static/js/header.js"></script>
                
                </div>
                <div class="fl" style="margin-left:5px;"><a rel="nr" href="http://www.vancl.com/?Source=alkj1"><img border="0" src="http://www.114la.com/static/images/banner/vancl10060.jpg" alt="VANCL ���ͳ�Ʒ"></a></div>
                <div class="fl" style="margin-left:5px;"><a href="http://www.amazon.cn/default.asp?source=114la"><img border="0" src="http://www.114la.com/static/images/banner/joyonew.gif" alt="׿Խ����"></a></div>
            </div>
        </div>
        <b class="rc-bt"><b></b></b></div>
        
        
        
        
    <div id="search">
        <div id="ex">
        <{foreach from = $notice_list item = i}>
            <p><a href="<{$i.url}>"<{if $i.color}> style="color:<{$i.color}>"<{/if}>><{$i.name}></a></p>
        <{/foreach}>
        </div>
       <div id="sm" class="clearfix">
            <ul id="sm_tab">
                <{foreach from=$search_class item=search_class1}>
                <li s_tab="js_type_<{$search_class1.classid}>" <{if $search_class1.is_default}> class="active" default="1"<{/if}>><{$search_class1.classname}></li>
                <{/foreach}>
            </ul>
        </div>
        <div id="sb" class="clearfix">

            <{foreach from=$search_class item=search_class2}>
            <div id="js_type_<{$search_class2.classid}>" <{if $search_class2.is_default!=1}> style="display:none;"<{/if}>>
                <div class="sw">
                    <p id="sw_<{$search_class2.classid}>">
                        <{foreach from=$search_keyword item=keyword}>
                            <{if $keyword.class == $search_class2.classid}>
                                <a href="<{$keyword.url}>"><{$keyword.name}></a>
                            <{/if}>
                        <{/foreach}>
                    </p><!--/ keywords-->
                </div>
                <div class="sf">
                    <form action="http://115.com/s" method="get" target="_blank">
                        <a href="http://115.com" id="sf_label" rel="lk"><img src="static/images/s/115.gif" width="105" height="35" rel="img" /></a><input type="text" name="q" class="int" autocomplete="off" rel="kw"/><input class="searchint" type="submit" value="115����" rel="btn" />
                        <div class="ctrl">
                        <{foreach from=$search item=row1}>
                            <{if $row1.class == $search_class2.classid}>
                            <label><input class="radio" type="radio" value="engine_<{$row1.id}>" name="search_select" rad="engine_<{$row1.id}>" <{if $row1.is_default}> checked="checked"<{/if}> /><{$row1.search_select}></label>
                            <{/if}>
                        <{/foreach}>
                        </div>
                    </form>
                </div>
            </div>
            <{/foreach}>
           
            <div id="suggest" style="display:none"></div>
        </div>
    </div>
    
        
    <div id="hot"><{*��վ�Ϸ����*}><{foreach from = $advert_search_footer item = i}><a <{if $i.color=='#FF0000' || $i.color=='red'}>class="red"<{elseif $i.color=='#008000' || $i.color=='green'}>class="green"<{elseif $i.color=='#0000FF' || $i.color=='blue'}>class="blue"<{elseif $i.color!=''}>style="color:<{$i.color}>;"<{/if}> target="_blank" href="<{$i.link}>"><{$i.title}></a><{/foreach}></div>
    <div id="content">
        <div id="cate"><b class="rc-tp"><b></b></b>
            <div class="box">
                <div id="tool">
                    <h2 class="tool-title">ʵ�ù���<span><a href="http://tool.115.com/" rel="nr">����&raquo;</a></span></h2>
                    <ul>
                        <{*ʵ�ù���*}>
                        <{foreach from = $tools item = i}>
                            <li><a href="<{$i.url}>"<{if $i.color}> style="color:<{$i.color}>"<{/if}>><{$i.name}></a></li>
                        <{/foreach}>
                    </ul>
                    <ul id="tool-tab" class="clearfix">
                        <li id="tool-tab-def" rel="tb4" class="active">�ֻ�</li>
                        <li rel="tb1">��Ʊ</li>
                        <li rel="tb2">�Ƶ�</li>
                        <li id="tool-tab-last" rel="tb3">����</li>
                    </ul>
                    <div id="tb">
                        <div id="tb1" class="tbox" style="display:none;">
                            <form class="plane" action="http://site.daodao.com/114la/go" accept-charset="utf-8" onsubmit="document.charset='utf-8';">
                                <p class="first">&nbsp;�� &nbsp;
                                    <input type="text" class="int_b" name="from" value="����" />
                                    &nbsp;��&nbsp;
                                    <input name="to" type="text" class="int_b" value="�Ϻ�" />
                                </p>
                                <p>����&nbsp;
                                    <input type="text" class="int" id="jp_today" name="date" />
                                    &nbsp;
                                    <input type="submit" value="�鿴�ۿۼ�" style="font-size:12px;" class="btn" />
                                </p>
                            </form>
                        </div>
                        <div id="tb2" class="tbox" style="display:none">
                            <form class="plane" action="http://www.daodao.com/HACSearch" accept-charset="utf-8" onsubmit="document.charset='utf-8';">
                                <p class="first">����&nbsp;
                                    <input  name="q" class="int_b" value="����" style="width:40px">
                                    &nbsp;�۸�&nbsp;
                                    <select name="l1price" style="font-size:12px; width:75px;">
                                        <option value="0,200">0-200Ԫ</option>
                                        <option value="201,500">201-500Ԫ</option>
                                        <option value="501,800">501-800Ԫ</option>
                                        <option value="800">800Ԫ����</option>
                                        <option value="" selected="selected">����</option>
                                    </select>
                                </p>
                                <p>�Ƶ�&nbsp;
                                    <input  name="nameContains" class="int_b" value="">
                                    &nbsp;
                                    <input type="submit" value="�� ��" class="btn" style="width:70px;" />
                                    <input type="hidden" name="m" value="13078" />
                                </p>
                            </form>
                        </div>
                        <div id="tb3" class="tbox" style="display:none">
                            <form class="plane" action="http://www.daodao.com/Search" onsubmit="daodao.searchTravel(); return false;">
                                <p class="first">�ǡ���&nbsp;
                                    <input type="text" id="daodao_travel_q" class="int_b" name="q" value="����" />
                                </p>
                                <p>�ؼ���&nbsp;
                                    <input class="int_b" id="daodao_travel_k" value="">
                                    &nbsp;
                                    <input type="submit" value="��������" style="height:22px; width:70px;" class="btn" />
                                    <input type="hidden" name="m" value="13078" />
                                </p>
                            </form>
                        </div>
                        <div id="tb4" class="tbox" style="margin-left:-5px;">
                            <form class="plane" action="http://www.915.com/cz/" method="post" target="_blank">
                                <p class="first">
                                    <select name="parvalue" style="font-size:12px; padding:1px;">
                                    	<option value="300">300Ԫ</option>
                                        <option selected="selected" value="100">100Ԫ</option>
                                        <option value="50">50Ԫ</option>
                                        <option value="30">30Ԫ</option>
                                    </select>
                                    <input type="text" class="int_b" name="mobile" maxlength="11" value="�������ֻ�����" onclick="(this.value == '�������ֻ�����')?this.value='':this.focus()" onblur="this.value==''?this.value='�������ֻ�����':this.value = this.value" style="width:88px;color:#666;font-size:12px;*line-height:16px;" />
                                    <input type="submit" value="��ֵ" style="height:22px;  width:38px;" class="btn" />
                                    <input type="hidden" name="ac" value="topup_submit" />
                                    <input type="hidden" name="source" value="114la" />
                                </p>
                                <p style="text-align:center;"><span class="red">1</span>���ӵ���&nbsp;&nbsp;���<span class="red">9.85</span>��&nbsp;&nbsp;&nbsp;<a href="http://www.915.com" class="red">��915�Ժ�</a></p>
                            </form>
                        </div>
                    </div>
                </div>
                <{*��վ����*}>
                <{foreach from = $site_class key = k item = parent}>
                    <h2><{$k}></h2>
                    <ul<{if $parent.0.classname_len > 6}> class="c2"<{/if}>>
                    <{foreach from = $parent item = i}>
                        <li ><a href="<{$i.urlpath}>"><{$i.classname}></a></li>
                    <{/foreach}>
                    </ul>
                <{/foreach}>
            </div>
        <b class="rc-bt"><b></b></b></div>
        <div id="main">
            <div id="bm"><b class="rc-tp"><b></b></b>
                <ul id="bm_tab" class="clearfix">
                    <li id="bm-def" class="active" rel="fm">��վ����</li>
                    <{foreach from = $famous_tab item = tab key = i}>
                    <li rel="bb<{$i}>" url="<{$tab.url}>" nocache=<{$tab.nocache}>><{$tab.name}></li>
                    <{/foreach}>
                </ul>
                <div id="qs"><b class="l"></b>
                    <div id="q_int" class="n">
                        <div class="button-wrap">
                            <input type="text" />
                        </div>
                    </div>
                    <b class="r"></b></div>
            </div>
            <div id="bb">
                <div class="box">
                    <div id="fm">
                        <ul id="topsite" class="clearfix">
                            <{*TOP ��վ*}>
                            	<{foreach from = $mz_top item = i}>
                            	<{$i.html}>
                            <{/foreach}>
                        </ul>
                        <ul id="fmsite" class="clearfix">
                            <{*��վ*}>
                            <{foreach from = $mz_list item = i}>
                            <li><a href="<{$i.url}>" <{if $i.namecolor=='#FF0000' || $i.namecolor=='red'}>class="red"<{elseif $i.namecolor=='#008000' || $i.namecolor=='green'}>class="green"<{elseif $i.namecolor=='#0000FF' || $i.namecolor=='blue'}>class="blue"<{elseif $i.namecolor!=''}>style="color:<{$i.namecolor}>;"<{/if}>><{$i.name}></a></li>
                            <{/foreach}>
                        </ul>
                    </div>
                    <div id="qs-result" style="display:none;"></div>
                </div>
                <b class="rc-bt"><b></b></b></div>
            <div id="hot2">
                <{*��վ�·����*}>
                <{$advert_notice}>
            </div>
            <div id="ls"><b class="rc-tp"><b></b></b>
                <div class="box">
                    <{*��վ����*}>
                    <{foreach from = $kz_list key ='key' item = 'item' name = n}><dl <{if $smarty.foreach.n.iteration % 2 eq 0}>class="alt"<{/if}>id="ls<{$smarty.foreach.n.iteration}>"><dt><a href="<{$item.url}>"><{$key}></a></dt><dd class="l"><{foreach key='k' item='v' from=$item.son}><a href="<{$v.url}>" <{if $v.namecolor=='#FF0000' || $v.namecolor=='red'}>class="red"<{elseif $v.namecolor=='#008000' || $v.namecolor=='green'}>class="green"<{elseif $v.namecolor=='#0000FF' || $v.namecolor=='blue'}>class="blue"<{elseif $v.namecolor!=''}>style="color:<{$v.namecolor}>;"<{/if}>><{$v.name}></a><{/foreach}></dd><dd class="m"><a href="<{$item.url}>">���� &raquo;</a></dd></dl><{/foreach}>
                </div>
                <b class="rc-bt"><b></b></b></div>
        </div>
    </div>
    <div id="meta"><b class="rc-tp"><b></b></b>
        <div class="box">
            <ul>
            <{*ר��*}>
        <{foreach from = $zhuanti key = k item = parent}>
        <li class="bd">
            <strong><a href="<{$URL_HTML}>/catalog/<{$k}>.htm"><{$parent.name}></a></strong>
            <{foreach from = $parent.son item = v}>
            <a href="<{$URL_HTML}>/catalog/<{$k}>.htm#<{$v.id}>"><{$v.name}></a>
            <{/foreach}>
            <span class="more"><a href="<{$URL_HTML}>/catalog/<{$k}>.htm">���� &raquo;</a></span>
        </li>
        <{/foreach}>
        <li class="bd">
            <strong><a href="<{$URL_HTML}>/local/">�ط�����</a></strong>
            <a  href="<{$URL_HTML}>/local/beijing.htm" title="����">����</a>
            <a  href="<{$URL_HTML}>/local/tianjin.htm" title="���">���</a>
            <a  href="<{$URL_HTML}>/local/guangdong.htm" title="�㶫">�㶫</a>
            <a  href="<{$URL_HTML}>/local/hebei.htm" title="�ӱ�">�ӱ�</a>
            <a  href="<{$URL_HTML}>/local/shanxi.htm" title="ɽ��">ɽ��</a>
            <a  href="<{$URL_HTML}>/local/liaoning.htm" title="����">����</a>
            <a  href="<{$URL_HTML}>/local/heilongjiang.htm" title="������">������</a>
            <a  href="<{$URL_HTML}>/local/shanghai.htm" title="�Ϻ�">�Ϻ�</a>
            <a  href="<{$URL_HTML}>/local/jiangsu.htm" title="����">����</a>
            <a  href="<{$URL_HTML}>/local/zhejiang.htm" title="�㽭">�㽭</a>
            <a  href="<{$URL_HTML}>/local/anhui.htm" title="����">����</a>
            <a  href="<{$URL_HTML}>/local/fujian.htm" title="����">����</a>
            <a  href="<{$URL_HTML}>/local/jiangxi.htm" title="����">����</a>
            <a  href="<{$URL_HTML}>/local/shandong.htm" title="ɽ��">ɽ��</a>
            <a  href="<{$URL_HTML}>/local/henan.htm" title="����">����</a>
            <a  href="<{$URL_HTML}>/local/hubei.htm" title="����">����</a>
            <a  href="<{$URL_HTML}>/local/taiwan.htm" title="̨��">̨��</a>
            <a  href="<{$URL_HTML}>/local/aomen.htm" title="����">����</a>
            <a  href="<{$URL_HTML}>/local/hongkong.htm" title="���">���</a>

            <span class="more"><a href="<{$URL_HTML}>/local/">���� &raquo;</a></span>
        </li>
         <{if $links}>
         <li class="bd">
            <strong><a href="<{$URL_HTML}>/catalog/links.htm">��������</a></strong>
            <{foreach from=$links item=links}>
            <a  href="<{$links.site_url}>" title="<{$links.site_name}>"><{$links.site_name}></a>
            <{/foreach}>
            <span class="more"><a href="<{$URL_HTML}>/catalog/links.htm">���� &raquo;</a></span>
         </li>
         <{/if}>
            </ul>
        </div>
    </div>
    <div id="fs">
        <div class="box">
            <form id="fs_form" onsubmit="miniSearch.gosearch(this);return false;" action="http://115.com/s" target="_blank" method="get">
            <ul class="clearfix">
            <li id="f_label">�ؼ��֣�</li>
            <li id="f_int">
            <input name="q" type="text"/>
            </li>
            <li id="f_btn">
            <input type="submit" value="�� ��" />
            </li>
            </ul>
            <input type="hidden" name="ie" value="gbk" />
            </form>
            <form id="taobao-form" action="http://search8.taobao.com/browse/search_auction.htm" target="_blank" style="display:none;">
            <input type="text" name="q" id="taobao-q" />
            </form>
            <div id="f_radio">
            <label for="s0"><input type="radio" name="st" class="radio" id="s0" checked="checked" />115����</label>
            <label for="s1"><input type="radio" name="st" class="radio" id="s1" />Google</label>
            <label for="s3"><input type="radio" name="st" class="radio" id="s3" />�Ա�</label>
            <label for="s5"><input type="radio" name="st" class="radio" id="s5" />�����</label>
            <label for="s4"><input type="radio" name="st" class="radio" id="s4" />��Ʊ</label>
            </div>
        </div>
        <b class="rc-bt"><b></b></b></div>
    <div id="footer">
        <div class="link"><a href="http://www.114la.com/114la/">����114����վϵͳV1.14</a> | <a href="<{$URL}>/url-submit/">��վ�ύ</a> | <a href="<{$URL}>/feedback">�������</a> | <a href="http://www.114la.com/114la/">Դ������</a><br />
        </div>
        <div class="hr"></div>
        <p class="copyright">Powered by 114����ַ����&copy;2005-<script type="text/javascript">document.write(new Date().getFullYear());</script>. All Rights Reserved. <a href="http://www.miibeian.gov.cn/"><{$icp}></a></p>

    </div>
<script type="text/javascript" src="<{$URL}>/public/home/js/config.js"></script>
<script type="text/javascript" src="<{$URL}>/public/home/js/main.js"></script>
<script type="text/javascript">
    try{
		if(window.SR){
			SR.SearchData = {
                <{foreach from=$search item=row2}>
                    engine_<{$row2.id}>: {
						action: "<{$row2.action}>",
						name: "<{$row2.name}>",
						btn: "<{$row2.btn}>",
						img: ["<{$row2.img_text}>","<{$row2.img_url}>"],
						url: "<{$row2.url}>",
						params: {
							<{$row2.params}>
						}
                    },
                <{/foreach}>
				none:{}
            }	
		}
		
		var sbBox = document.getElementById('sb');
		var sbForms = sbBox.getElementsByTagName('form');
		for(var i = 0,len = sbForms.length; i < len; i++){
			sbForms[i].reset();
		}
		
		var sbRadios = sbBox.getElementsByTagName('input');
		var inputTxtArr = [];
		if(sbRadios.length){
			var setRadios = [];
			for(var i = 0,len = sbRadios.length; i < len; i++){
				var input = sbRadios[i];
				if(input.getAttribute("rad") && input.checked){
					setRadios.push(input);
				}
				else if(input.getAttribute("rel") == "kw"){
					var key = inputTxtArr.push(input);
					input.setAttribute("index",key - 1);
					
				}
			}
			try{
			for(var i = 0,len = setRadios.length; i < len; i++){
				var input = setRadios[i];
				
				SR.RadioMod.ClickRadio(input);
			}
			}catch(e){}
		}
	}catch(e){}
    </script>
<div class="tongji"><{$tongji}></div>

</div>

</body>
</html>
