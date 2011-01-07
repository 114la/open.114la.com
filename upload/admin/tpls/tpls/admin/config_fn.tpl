<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        
        <div id="main">
            
            
            <div class="con box-green">
                <form method="post" action="?c=config&a=fn">
                <div class="box-header">
                    <h4>进程优化 <span class="green font-n">(建议15分钟在线1000人以上打开此选项)</span></h4>
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
                    <h4>GZIP 压缩输出<span class="green font-n">(选择开启讲允许系统通过gzip输出页面,可以很明显地降低带宽需求,但只有在客户端支持的情况下才可使用,并会加大服务器系统开销)</span></h4>
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
