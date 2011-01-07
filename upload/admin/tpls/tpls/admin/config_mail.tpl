<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        
        <div id="main">
            
            
            <div class="con box-green">
                <form method="post" action="?c=config&a=mail">
                <div class="box-header">
                    <h4>电子邮件发送 </h4>
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
                    <h4>电子邮件发送方式</h4>
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
                    <h4>收信邮箱地址</h4>
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
                    <h4>smtp服务器地址</h4>
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
                    <h4>smtp服务器端口(默认:25)</h4>
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
                    <h4>SMTP服务器是否需要安全连接(SSL) <span class="green font-n">(一般不需要SSL连接,GMAIL需要,PHP需要启用openssl)</span></h4>
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
                    <h4>SMTP服务器是否需要用户验证</h4>
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
                    <h4>SMTP服务器验证用户名 <span class="green font-n">(普通邮件认证不需要加@域名)</span></h4>
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
                    <h4>SMTP服务器验证密码</h4>
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
                    	<input type="submit" value="保存更改" />
                    </div>
                </div>
                </form>
            </div><!--/ con-->
            
            
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<{include file=footer.tpl}>
