<{include file="header.tpl"}>
<div class="wrap">
    <div class="container">
        <div id="main">
            <div class="con box-green">
                <form action="?c=template_manage&action=save" method="post">
                <input type="hidden" name="filename" value="<{$filename}>"/>
                <input type="hidden" name="referer" value="<{$back}>"/>
                
                <div class="box-content">
                    <div class="pb5">
                        <input type="button" value="恢复到默认模板" onclick="self.location = '?c=template_manage&action=restore&filename=<{$filename}>'" />
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