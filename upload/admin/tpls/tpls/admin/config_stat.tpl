<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        
        <div id="main">
            
            
            <div class="con box-green">
                <form method="post" action="?c=config&a=stat">
                <div class="box-header">
                    <h4>到访IP统计</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120"><input type="radio" name="ip" id="ip_off" /></th>
                            <td>
                                <label for="ip_off">关闭</label>
                            </td>
                        </tr>
                        <tr>
                            <th><input type="radio" name="ip" id="ip_on" /></th>
                            <td>
                                <label for="ip_on">开启</label>                             
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-header">
                    <h4>到访ISP统计 <span class="green font-n">(在开启IP统计的情况下有效)</span></h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120"><input type="radio" name="isp" id="isp_off" /></th>
                            <td>
                                <label for="isp_off">关闭</label>
                            </td>
                        </tr>
                        <tr>
                            <th><input type="radio" name="isp" id="isp_on" /></th>
                            <td>
                                <label for="isp_on">开启</label>                             
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="保存更改" /> 或 <a href="#">取消</a>
                    </div>
                </div>
                </form>
            </div><!--/ con-->
            
            
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<{include file=footer.tpl}>
