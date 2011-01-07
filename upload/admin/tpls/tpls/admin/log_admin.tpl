<{include file='header.tpl'}>


<body id="main_page">

<div class="wrap">
    <div class="container">

        <div id="main">
            
            <div class="con">
            	<form action="<{$sys.formurl}>" method="get">
                  <div class="table">
                  	<div class="th">
                    	<div class="form"><strong>管理员操作日志&nbsp;</strong></div>
                    </div>
                    <table class="admin-tb" id="tb1">
                    <tr>
                    	<th width="41" class="text-center">用户名</th>
                        <th width="300">操作日志</th>
                        <th width="300">最后登录时间</th>
                        <th width="200">最后登录IP</th>
                        <th>其他</th>
                        
                    </tr>

<{$data.0}>

                    
                  

                    
                    </table>
                    
                    
                    <div class="th"><!--/ pages-->
                            
                            <div class="pages">
                            	<{$data.1}>
                            </div>
                    	<div class="form">
                        	<input type="button" value="删除多余管理日志" onClick="location.href='?c=log&a=log_admin_delete&delete=yes'"   />&nbsp;&nbsp;&nbsp;[&nbsp;系统将保留最后100条数据&nbsp;]
                        
                        </div>
                    </div>
                    
                </div>

				</form>
            </div><!--/ con-->
            
            
            
            
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<{include file='footer.tpl'}>
