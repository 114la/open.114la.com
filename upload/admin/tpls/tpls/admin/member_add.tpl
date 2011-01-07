<{include file='header.tpl'}>

<body id="main_page">
<div class="wrap">
    <div class="container">
        
        <div id="main">
            
            
            <div class="con box-green">
                <form action="<{$sys.subform}>" method="post" enctype="multipart/form-data">                
                <div class="box-header">
                    <h4>添加新用户</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120">用户名：</th>
                            <td><input name="name" type="text" class="textinput w270" id="name" value="<{$data.name}>" /></td>
                        </tr>
                        <tr>
                            <th>确定新密码：</th>
                            <td><input name="password" type="password" class="textinput w270" id="password" /></td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="添加" /> 或 <a href="<{$sys.goback}>">取消</a>
                      <input name="step" type="hidden" id="step" value="2">
                    </div>
                </div>
                </form>
            </div><!--/ con-->            
        </div>    
    </div><!--/ container-->
</div>
<{include file='footer.tpl'}>