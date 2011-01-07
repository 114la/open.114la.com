<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        
        <div id="main">
            
            
            <div class="con box-green">
                <form method="post" action="?c=config&a=ip">
                <div class="box-header">
                    <h4>以下为被禁止的IP</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <td><textarea class="w360" name="ip_deny_list"><{$ip_deny_list}></textarea></td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="保存更改" />
                    </div>
                </div>
                </form>
            </div><!--/ con-->
            
            
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<{include file=footer.tpl}>
