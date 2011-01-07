<{include file='header.tpl'}>



<div class="wrap">
    <div class="container">
        
        <div id="main"><!--/ con--><!--/ con-->
            
            <div class="con box-green">
                <form action="<{$sys.subform}>" method="post" enctype="multipart/form-data">         
                <div class="box-header">
                    <h4>修改密码</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">

<{if $smarty.const.USERNAME==$smarty.request.name}>
<tr>
    <th class="w120">原始密码：</th>
    <td><input name="oldpassword" type="password" class="textinput w270" id="oldpassword" /></td>
</tr>
<{/if}>

                        <tr>
                            <th class="w120">新密码：</th>
                            <td><input name="password" type="password" class="textinput w270" id="password" /></td>
                        </tr>
                        <tr>
                            <th>确定新密码：</th>
                            <td><input name="repassword" type="password" class="textinput w270" id="repassword" /></td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                  <div class="box-footer-inner">
                   	  <input type="submit" value="保存更改" /> 或 <a href="<{$sys.goback}>">取消</a>
                      <input name="step" type="hidden" id="step" value="2">
                    <input name="name" type="hidden" id="name" value="<{$smarty.request.name}>">
                    </div>
                </div>
                </form>
          </div><!--/ con-->
            
      </div>    
    </div><!--/ container-->


<{include file='footer.tpl'}>