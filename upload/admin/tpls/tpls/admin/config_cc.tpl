<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        
        <div id="main">
            
            
            <div class="con box-green">
                <form method="post" action="?c=security&a=cc">
                <div class="box-header">
                    <h4>ϵͳ���ؿ��Ʋ��� <span class="green font-n">(����ֵ��3�����������ĸ��ز����������ֵʱ���Զ�����CC����ģʽ������linux,unix,FREEBSDϵͳ��Ч)</span></h4>
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
                    <h4>CC��������</h4>
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
                    	<input type="submit" value="�������" />
                    </div>
                </div>
                </form>
            </div><!--/ con-->
            
            
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<{include file=footer.tpl}>
