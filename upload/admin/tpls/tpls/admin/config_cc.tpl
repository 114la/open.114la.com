<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        
        <div id="main">
            
            
            <div class="con box-green">
                <form method="post" action="?c=security&a=cc">
                <div class="box-header">
                    <h4>系统负载控制参数 <span class="green font-n">(建议值：3，当服务器的负载参数大于这个值时，自动开启CC防护模式。仅对linux,unix,FREEBSD系统有效)</span></h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120"> </th>
                            <td><input name='config[loadavg]' value='<{$config.yl_loadavg}>' /></td>
                        </tr>
                    </table>
                </div>
                <div class="box-header">
                    <h4>CC攻击防护</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <td>
<{html_radios name="config[cc]" options=$option_cc checked=$config.yl_cc separator="<br />"}>
                            </td>
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
