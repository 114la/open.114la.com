<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        
        <div id="main">
            
            
            <div class="con box-green">
                <form method="post" action="?c=config&a=status">
                <div class="box-header">
                    <h4>Debug ģʽ����ϵͳ <span class="green font-n">(�����γ��򱨴���Ϣ,ϵͳ�����쳣ʱ�򿪴�ģʽ,��������Ϣ�ύ�����򿪷�Ա,�Ա㾡��õ����)</span></h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <td>
                              <label>
                                <{html_radios name="config[debug]" options=$option_toggle checked=$config.yl_debug separator="<br />"}>
                              </label>
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
