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
                        <input type="button" value="备份当前模板" onclick="self.location = '?c=template_manage&a=backup&filename=<{$form.tpl_file}>'" /> 
                        <input type="button" value="恢复到备份模板" onclick="self.location = '?c=template_manage&a=restore&filename=<{$form.tpl_file}>'" /> 
                    </div>-->
                    <div class="pb5">
                        模板名称：<input type="text" name="form[tpl_name]" value="<{$form.tpl_name}>" /> (必填)
                    </div>
                    <div class="pb5">
                        模板文件：<input type="text" name="form[tpl_file]" value="<{$form.tpl_file}>" <{if $tpl_file_readonly}>readonly<{/if}> /> (为空时系统默认分配一个文件名)
                    </div>
                    <div>
                        <textarea name="content" style="width:98%; height:420px; border:1px solid #ccc; overflow:hidden; overflow-y:scroll;"><{$content}></textarea>
                    </div>
                    <{if $show_msg}><p>提示：修改模板后请手动更新静态页面</p><{/if}>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="保存更改" /> 或 <a href="<{$back}>">取消</a>
                    </div>
                </div>
                </form>
            </div><!--/ con-->
        </div>
    </div><!--/ container-->
</div><!--/ wrap-->
<{include file="footer.tpl"}>
