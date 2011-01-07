<{include file='header.tpl'}>

<body id="main_page">
<div class="wrap">
    <div class="container">
        <div id="main">

            <div class="con">          
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
<{include file='footer.tpl'}>