<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        
        <div id="main">
            
            
            <div class="con box-green">
                <form method="post" action="?c=config&a=mail">
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
                    <h4>smtp�������˿�(Ĭ��:25)</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120"> </th>
                            <td>
                                <input  class="textinput w270" type="text" name="config[smtpport]" value="<{$config.yl_smtpport}>" /><br />
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-header">
                    <h4>SMTP�������Ƿ���Ҫ��ȫ����(SSL) <span class="green font-n">(һ�㲻��ҪSSL����,GMAIL��Ҫ,PHP��Ҫ����openssl)</span></h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <td>
                                <{html_radios name="config[smtpssl]" options=$option_toggle checked=$config.yl_smtpssl separator="<br />"}>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-header">
                    <h4>SMTP�������Ƿ���Ҫ�û���֤</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <td>
                                <{html_radios name="config[smtpauth]" options=$option_toggle checked=$config.yl_smtpauth separator="<br />"}>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-header">
                    <h4>SMTP��������֤�û��� <span class="green font-n">(��ͨ�ʼ���֤����Ҫ��@����)</span></h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120"> </th>
                            <td>
                                <input type="text"  name="config[smtpid]"  class="textinput w270"  value="<{$config.yl_smtpid}>"  /><br />
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-header">
                    <h4>SMTP��������֤����</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120"> </th>
                            <td>
                               <input type="password" class="textinput w270"   id="config[smtppass]" name="config[smtppass]" value="<{$config.yl_smtppass}>" /><br />
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
