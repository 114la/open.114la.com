<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        <div id="main">
            <div class="con">
                <div class="tips warn-ico">
                <form action="<{$action_url}>" method="post">
                    <input type="hidden" name="step" value="1"/>
                    <input type="hidden" name="delete" value="<{$delete}>"/>
                    <input type="hidden" name="referer" value="<{$referer}>"/>
                   	    <{$message}><input type="submit" value="ȷ��ɾ��" /> �� <a href="<{$referer}>">ȡ��</a>
                    </form>
                </div>                
      </div><!--/ con-->
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
</body>
</html>
