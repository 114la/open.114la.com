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
                    <h2 class="th">本次升级需要写入权限的目录及状态：</h2>       
                    <table>
                    <tr>
                    <td style='padding:10px'>
              
              <{foreach from=$dirinfos key=k item=v}>
                <div style='border-bottom:1px dashed #ccc'><{$v.name}> 状态：(<{ if $v.writeable }> [√正常] <{else}> <font color='red'>[×不可写]</font> <{/if}>)</div>
              <{/foreach}>
              
              <div style='line-height:36px;background:#F8FEDA'>&nbsp;
                   <input type='button' name='sb1' value=' 我已经确认这些目录没问题，开始下载补丁进行升级 '
                    onclick="location='?c=update&a=start';" class='coolbg' style='cursor:pointer' />
              </div>
              
                    </td>
                    </tr>
                    </table>
                </div>
                
            </div><!--/ con-->
        </div>    
    </div><!--/ container-->
</div><!--/ wrap-->
<{include file='footer.tpl'}>