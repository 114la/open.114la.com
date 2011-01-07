<{include file='header.tpl'}>
<body id="main_page">

<div id="nav" style="display:none">
<dl>
    <dt>当前位置：</dt>
    <dd class="link"><a href="#">首页管理</a></dd>
    <dd>控制台</dd>
</dl>
</div>
<script type="text/javascript">
	var nav = document.getElementById("nav");
	var pnav = window.parent.document.getElementById("nav")
	pnav.innerHTML = nav.innerHTML;
</script>
<div class="wrap">
    <div class="container">
        <div id="main">
            <div class="con">
                <{if $data.site_new}>
                <div class="tips" style="margin-top:10px; border-top:1px solid #F93">
                                            目前有 <strong class="red"><{$data.site_new}></strong> 个待处理的收录申请 <a href="<{$data.site_url}>">立即处理 &raquo;</a>
                </div>
                <{/if}>
                <{if $data.safe_notice}>

		  <div class="table">
                    <h2 class="th">114啦网址导航建站系统  更新消息</h2>       
                    <table><tr><td>
                        <p>
                            欢迎使用雨林木风114啦网址导航建站系统，当前版本号：V<{$curver}>，最后更新时间：<{$curtime}>。
                            <br />
                           <!-- <a href='http://www.ylmf.net/thread.php?fid=346' target='_blank'>114啦网址导航建站系统开源讨论专区&gt;&gt;</a>-->
                        </p>
                        <div class="table" id="version_notice" style="display:none;background-color:#fff">            
                            <p class="tips"></p>
                        </div>
                    </td></tr></table>
                </div>

                <div class="table">
                    <h2 class="th">安全提示</h2>       
                    <div class="tips">
                        <p>为了使用更安全，建议您将后台管理目录名称由默认的  <strong>admin</strong>　修改为其他目录名， <strong>修改步骤如下：</strong></p>
			 <p>1、修改ftp根目录下的 <strong>init.php</strong> 文件，将第 <strong>10</strong> 行，将该行最后一个引号里的 <strong>admin</strong>（小写字母） 修改为新的目录名。</p>
                        <p>2、修改ftp根目录下的 <strong>admin</strong> 目录名为新的目录名。</p>
                    </div>
                </div>
                <{/if}>
                
              
                
                <div class="table">
                    <h2 class="th">服务器基本信息 <span class="head"><{$smarty.server.SERVER_NAME}><{$data.serverip}> &nbsp;<{$data.systime}></span></h2>                
                    <table>
                        <tr>
                        <td colspan="2"> System:<{$data.sysinfo}></td>
                        <td colspan="2">Web server:<span class="b"><{$smarty.server.SERVER_SOFTWARE}></span></td>
                        <td colspan="2">PHP Version:<{$data.phpversion}></td>
                        </tr>
                        <tr>
                        <td colspan="2">Mysql  Version:<{$data.dbversion}></td>
                        <td colspan="2"> display_errors:<{$data.dispalyerror}></td>
                        <td colspan="2">Server API:<{$data.serverapi}></td>
                        </tr>
                        <tr>
                        <td colspan="2">PHP Safe: <{$data.phpsafe}> </td>
                        <td colspan="2">Session Support:<{$data.sessionsp}></td>
                        <td colspan="2">Cookie Support:<{$data.cookiesp}></td>
                        </tr>
                        <tr>
                        <td colspan="2">Zend Optimizer Support:<{$data.zendoptsp}></td>
                        <td colspan="2">eAccelerator Support:<{$data.eaccsp}></td>
                        <td colspan="2">Xcache Support:<{$data.xcachesp}></td>
                        </tr>
                        <tr>
                        <td colspan="2">register_globals:<{$data.registerglobal}></td>
                        <td colspan="2">magic_quotes_gpc:<{$data.mqqsp}></td>
                        <td colspan="2">magic_quotes_runtime:<{$data.mprsp}></td>
                        </tr>
                        <tr>
                        <td colspan="2">upload_max_filesize:<{$data.maxupsize}></td>
                        <td colspan="2">post_max_size:<{$data.maxpostsize}></td>
                        <td colspan="2">max_execution_time:<{$data.maxexectime}></td>
                        </tr>
                        <tr>
                        <td width="12%">allow_url_fopen:<{$data.allowurlopen}></td>
                        <td width="13%">Curl Support:<{$data.curlsp}></td>
                        <td width="12%">Iconv Support:<{$data.iconvsp}></td>
                        <td width="13%">Zlib Support:<{$data.zlibsp}></td>
                        <td width="12%">GD Support:<{$data.gdsp}></td>
                        <td width="13%">DBA Support:<{$data.dbasp}></td>
                        </tr>
                    </table>
                </div>                
                <div class="table">
                    <h2 class="th">统计信息</h2>                
                    <table>
                    <tr>
                    <td> 当前站点数:<{$data.sitesum}></td>
                    <td>数据库大小:<{$data.datasize}></td>
                    </tr>
                    </table>
                </div>
            </div><!--/ con-->
        </div>    
    </div><!--/ container-->
</div><!--/ wrap-->
<script type="text/javascript">
$(document).ready(function()
{
    $.get('?c=update&t', function(data)
    {
        if(data.length < 50)
        {
            return ;
        }
        var result = eval("(" + data + ")");
        var tpl = nstyle = '';
        if( result.upitems != null )
        {
            tpl += "<div style='width:98%'><form name='fup' action='?c=update&a=getlist' method='post'>";
			      tpl += "<input type='hidden' name='lasttime' value='"+ result.lasttime +"' />";
			      tpl += "<input type='hidden' name='upitems' value='"+ result.upitems +"' />";
			      tpl += "<div class='upinfotitle'><strong>当前可用的更新有：</strong></div>";
			      for(i=0; i<result.vers.length; i++)
			      {
				        nstyle = result.vers[i].issafe==1 ? "color:red;" : "";
				        tpl += "<div style='border-bottom:1px dashed #bbb;"+ nstyle +"' class='verline'>【" + (result.vers[i].issafe==1 ? "安全更新" : "普通更新") + "】";
				        tpl += result.vers[i].vtime + "，更新说明："+ result.vers[i].vmsg +"</div>";
			      }
			      tpl += "<div style='line-height:32px'><input type='submit' name='sb1' value=' 点击此获取所有更新文件，然后选择安装 ' class='coolbg' style='cursor:pointer' />\r\n";
			      tpl += " &nbsp; <input type='button' name='sb2' value=' 忽略这些更新 ' onclick=\"location='?c=update&a=skinupdate&lasttime="+result.lasttime+"'\" class='coolbg'  style='cursor:pointer' /></div>\r\n";
			      tpl += "</form></div>";
			      $('#version_notice .tips').html(tpl);
            $('#version_notice').slideDown('slow');
        }
   });
});
</script>
<{include file='footer.tpl'}>