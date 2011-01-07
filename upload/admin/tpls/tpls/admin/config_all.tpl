<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        
        <div id="main">
            <div class="con box-green">
                <form method="post" action="?c=config&a=index">
                <div class="box-header">
                    <h4>基本设置 </h4>
                </div>
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
                        <!--  -->
                    </table>
                </div>
                <div class="box-header">
                    <h4>Debug 模式运行系统 <span class="green font-n">(不屏蔽程序报错信息,系统出现异常时打开此模式,将错误信息提交给程序开发员,以便尽快得到解决)</span></h4>
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
                    <h4>是否开启验证码<span class="green font-n">开启验证码，可以提供系统安全性。 <font color="red">注：此功能需要GD库支持。</font></span></h4>
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
                    <h4>是否开启版本升级提示: <span class="green font-n">(当官方有新版本发布时，显示升级提示)</span></h4>
  
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
                    <h4>是否允许代理访问</h4>
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
