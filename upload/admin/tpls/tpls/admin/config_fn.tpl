<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        
        <div id="main">
            
            
            <div class="con box-green">
                <form method="post" action="?c=config&a=fn">
                <div class="box-header">
                    <h4>�����Ż� <span class="green font-n">(����15��������1000�����ϴ򿪴�ѡ��)</span></h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <td>
                                <{html_radios name="config[lp]" options=$option_toggle checked=$config.yl_lp separator="<br />"}>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-header">
                    <h4>GZIP ѹ�����<span class="green font-n">(ѡ����������ϵͳͨ��gzip���ҳ��,���Ժ����Եؽ��ʹ�������,��ֻ���ڿͻ���֧�ֵ�����²ſ�ʹ��,����Ӵ������ϵͳ����)</span></h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <td>
                                <{html_radios name="config[obstart]" options=$option_toggle checked=$config.yl_obstart separator="<br />"}>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-header">
                    <h4>�Ƿ�����֤��<span class="green font-n">������֤�룬�����ṩϵͳ��ȫ�ԡ� <font color="red">ע���˹�����ҪGD��֧�֡�</font></span></h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <td>
                                <{html_radios name="config[verify_code]" options=$option_toggle checked=$config.yl_verify_code separator="<br />"}>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-header">
                    <h4>�Ƿ����汾������ʾ: <span class="green font-n">(���ٷ����°汾����ʱ����ʾ������ʾ)</span></h4>
  
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <td>
                              <label>
                                <{html_radios name="config[display_update_info]" options=$option_toggle checked=$config.yl_display_update_info|default:1 separator="<br />"}>
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
