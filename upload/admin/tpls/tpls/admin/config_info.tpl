<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        
        <div id="main">
  
            
            <div class="con box-green">
                <form method="post" action="?c=config&a=info">
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120">系统标题：</th>
                            <td><input type="text" class="textinput w360" name="config[sysname]" value="<{$config.yl_sysname}>" /></td>
                        </tr>
                        <tr>
                            <th>系统地址：</th>
                            <td><input type="text" class="textinput w360" name="config[sysurl]" value="<{$config.yl_sysurl}>"  /></td>
                        </tr>
                        <tr>
                            <th>联系我们URL：</th>
                            <td><input type="text" class="textinput w360" name="config[ceoconnect]" value="<{$config.yl_ceoconnect}>" /></td>
                        </tr>
                        <tr>
                            <th>管理员邮箱：</th>
                            <td><input type="text" class="textinput w360" name="config[ceoemail]" value="<{$config.yl_ceoemail}>"  /></td>
                        </tr>
                        <tr>
                            <th>ICP备案信息：</th>
                            <td><input type="text" class="textinput w360" name="config[icp]" value="<{$config.yl_icp}>"  /></td>
                        </tr>
                        <tr>
                            <th>ICP备案链接地址：</th>
                            <td><input type="text" class="textinput w360" name="config[icpurl]" value="<{$config.yl_icpurl}>"  /></td>
                        </tr>
                        <tr>
                            <th>keywords：</th>
                            <td><input type="text" class="textinput w360" name="config[metakeyword]" value="<{$config.yl_metakeyword}>"  /></td>
                        </tr>
                        <tr>
                            <th  style="vertical-align:top;">description：</th>
                            <td><textarea class="w360" name="config[metadescrip]"><{$config.yl_metadescrip}></textarea></td>
                        </tr>
                        <tr>
                            <th  style="vertical-align:top;">统计代码：</th>
                            <td><textarea class="w360" name="config[ipstat]"><{$config.yl_ipstat}></textarea></td>
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
