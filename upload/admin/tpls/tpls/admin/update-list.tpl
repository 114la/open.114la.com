<{include file='header.tpl'}>
<body id="main_page">

<div id="nav" style="display:none">
<dl>
    <dt>当前位置：</dt>
    <dd class="link"><a href="#">在线升级</a></dd>
    <dd>升级文件选择</dd>
</dl>
</div>

<div class="wrap">
    <div class="container">
        <div id="main">
            <div class="con">

                <div class="table">
                    <h2 class="th">以下是需要下载的更新文件（路径相对于根目录）：</h2>
                    <table>
                    <tr>
                    <td style='padding:10px'>
              <{if $hasupfile }>
                    <form name='fup' action='?c=update&a=makecache' method='post' accept-charset="gb2312">
                       <input type='hidden' name='lasttime' value='<{$lasttime}>' />
                       <input type='hidden' name='upitems' value='<{$upitems}>' />
		                   <{foreach from=$files key=k item=v}>
			                    <div style="border-bottom:1px dashed #ccc"><input type='checkbox' name='files[]' value='<{$k}>'  checked='checked' /> <{$k}>(<{$v}>)</div>
                       <{/foreach}>
                       <div class='verline'>
                        文件临时存放目录：admin/data/<input type='text' name='tmpdir' style='width:200px' value='<{$tmpdir}>' />
                        <br />
                        <input type='checkbox' name='skipnodir' value='1'  checked='checked' /> 跳过系统中没有的文件夹(可能是模块)
                       </div>
                       <div style='line-height:36px;background:#F8FEDA'>&nbsp;
                            <input type='submit' name='sb1' value=' 下载并应用这些补丁 ' class='np coolbg' style='cursor:pointer' />
                       </div>
                    </form>
               <{else}>
               可能网络存在问题，无法获得可用的升级文件！请检查网络，刷新后重试。
               <{/if}>
                    </td>
                    </tr>
                    </table>
                </div>

            </div><!--/ con-->
        </div>
    </div><!--/ container-->
</div><!--/ wrap-->
<{include file='footer.tpl'}>