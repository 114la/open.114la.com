<{include file="header.tpl"}>
<div class="wrap">
    <div class="container">
        <div id="main">
            <div class="con box-green">
                <form action="<{$sys.subform}>" method="post">
                <input type="hidden" name="referer" value="<{$sys.goback}>"/>
                <{if $form.id}><input type="hidden" name="id" value="<{$form.id}>"/><{/if}>

                <div class="box-content">
                    <!--<div class="pb5">
                        <input type="button" value="���ݵ�ǰģ��" onclick="self.location = '?c=template_manage&a=backup&filename=<{$form.tpl_file}>'" /> 
                        <input type="button" value="�ָ�������ģ��" onclick="self.location = '?c=template_manage&a=restore&filename=<{$form.tpl_file}>'" /> 
                    </div>-->
                    <div class="pb5">
                        ģ�����ƣ�<input type="text" name="form[tpl_name]" value="<{$form.tpl_name}>" /> (����)
                    </div>
                    <div class="pb5">
                        ģ���ļ���<input type="text" name="form[tpl_file]" value="<{$form.tpl_file}>" <{if $tpl_file_readonly}>readonly<{/if}> /> (Ϊ��ʱϵͳĬ�Ϸ���һ���ļ���)
                    </div>
                    <div>
                        <textarea name="content" style="width:98%; height:420px; border:1px solid #ccc; overflow:hidden; overflow-y:scroll;"><{$content}></textarea>
                    </div>
                    <{if $show_msg}><p>��ʾ���޸�ģ������ֶ����¾�̬ҳ��</p><{/if}>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="�������" /> �� <a href="<{$back}>">ȡ��</a>
                    </div>
                </div>
                </form>
            </div><!--/ con-->
        </div>
    </div><!--/ container-->
</div><!--/ wrap-->
<{include file="footer.tpl"}>
