<{include file='header.tpl'}>
<body id="main_page">

<div id="nav" style="display:none">
<dl>
    <dt>��ǰλ�ã�</dt>
    <dd class="link"><a href="#">��������</a></dd>
    <dd>�����ļ�ѡ��</dd>
</dl>
</div>

<div class="wrap">
    <div class="container">
        <div id="main">
            <div class="con">
                
                <div class="table">
                    <h2 class="th">����������Ҫд��Ȩ�޵�Ŀ¼��״̬��</h2>       
                    <table>
                    <tr>
                    <td style='padding:10px'>
              
              <{foreach from=$dirinfos key=k item=v}>
                <div style='border-bottom:1px dashed #ccc'><{$v.name}> ״̬��(<{ if $v.writeable }> [������] <{else}> <font color='red'>[������д]</font> <{/if}>)</div>
              <{/foreach}>
              
              <div style='line-height:36px;background:#F8FEDA'>&nbsp;
                   <input type='button' name='sb1' value=' ���Ѿ�ȷ����ЩĿ¼û���⣬��ʼ���ز����������� '
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