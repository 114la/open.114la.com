<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        
        <div id="main">
            <div class="con box-green">
                <form method="post" action="?c=config&a=index">
                <div class="box-header">
                    <h4>�������� </h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120">ϵͳ���⣺</th>
                            <td><input type="text" class="textinput w360" name="config[sysname]" value="<{$config.yl_sysname}>" /></td>
                        </tr>
                        <tr>
                            <th>ϵͳ��ַ��</th>
                            <td><input type="text" class="textinput w360" name="config[sysurl]" value="<{$config.yl_sysurl}>"  /></td>
                        </tr>
                        <tr>
                            <th>��ϵ����URL��</th>
                            <td><input type="text" class="textinput w360" name="config[ceoconnect]" value="<{$config.yl_ceoconnect}>" /></td>
                        </tr>
                        <tr>
                            <th>����Ա���䣺</th>
                            <td><input type="text" class="textinput w360" name="config[ceoemail]" value="<{$config.yl_ceoemail}>"  /></td>
                        </tr>
                        <tr>
                            <th>ICP������Ϣ��</th>
                            <td><input type="text" class="textinput w360" name="config[icp]" value="<{$config.yl_icp}>"  /></td>
                        </tr>
                        <tr>
                            <th>ICP�������ӵ�ַ��</th>
                            <td><input type="text" class="textinput w360" name="config[icpurl]" value="<{$config.yl_icpurl}>"  /></td>
                        </tr>
                        <tr>
                            <th>keywords��</th>
                            <td><input type="text" class="textinput w360" name="config[metakeyword]" value="<{$config.yl_metakeyword}>"  /></td>
                        </tr>
                        <tr>
                            <th  style="vertical-align:top;">description��</th>
                            <td><textarea class="w360" name="config[metadescrip]"><{$config.yl_metadescrip}></textarea></td>
                        </tr>
                        <!--  -->
                    </table>
                </div>
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
                <div class="box-header">
                    <h4>�����ʼ����� </h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <td>
                                <{html_radios  name="config[sendemail]" options=$option_toggle checked=$config.yl_sendemail separator="<br />"}>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-header">
                    <h4>�����ʼ����ͷ�ʽ</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <td>
                                <{html_radios name="config[sendemailtype]" options=$option_sendmailtype checked=$config.yl_sendemailtype separator="<br />"}>
                            </td>
                        </tr>
                   </table>
                </div>
                <div class="box-header">
                    <h4>���������ַ</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120"> </th>
                            <td>
                                <input class="textinput w270" name="config[fromemail]" value="<{$config.yl_fromemail}>" /><br />
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-header">
                    <h4>smtp��������ַ</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120"> </th>
                            <td>
                                <input type="text"  class="textinput w270"  name="config[smtpserver]" value="<{$config.yl_smtpserver}>" /><br />
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-header">
                    <h4>�Ƿ�����������</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <td>
                                <{html_radios name="config[proxy]" options=$option_proxy checked=$config.yl_proxy separator="<br />"}>
                            </td>
                        </tr>
                    </table>
                </div>
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
                <div class="box-header">
                    <h4>����Ϊ����ֹ��IP</h4>
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
                    	<input type="submit" value="�������" />
                    </div>
                </div>
                </form>
            </div><!--/ con-->
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<{include file=footer.tpl}>
