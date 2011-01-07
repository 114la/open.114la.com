<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        
        <div id="main">
            
            
            <div class="con box-green">
                <form method="post" action="?c=config&a=status">
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
