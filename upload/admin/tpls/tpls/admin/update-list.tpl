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
                    <h2 class="th">��������Ҫ���صĸ����ļ���·������ڸ�Ŀ¼����</h2>
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
                        �ļ���ʱ���Ŀ¼��admin/data/<input type='text' name='tmpdir' style='width:200px' value='<{$tmpdir}>' />
                        <br />
                        <input type='checkbox' name='skipnodir' value='1'  checked='checked' /> ����ϵͳ��û�е��ļ���(������ģ��)
                       </div>
                       <div style='line-height:36px;background:#F8FEDA'>&nbsp;
                            <input type='submit' name='sb1' value=' ���ز�Ӧ����Щ���� ' class='np coolbg' style='cursor:pointer' />
                       </div>
                    </form>
               <{else}>
               ��������������⣬�޷���ÿ��õ������ļ����������磬ˢ�º����ԡ�
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