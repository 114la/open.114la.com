<{include file='header.tpl'}>


<body id="main_page">

<div class="wrap">
    <div class="container">

        <div id="main">
            
            <div class="con">
            	<form action="<{$sys.formurl}>" method="get">
                  <div class="table">
                  	<div class="th">
                    	<div class="form"><strong>数据库操作日志&nbsp;</strong></div>
                    </div>
                    <table class="admin-tb" id="tb1">
                    <tr>
                    	<th width="41" class="text-center">用户名</th>
                    	<th width="97">请求URL</th>
                        <th width="448">mysql 语句</th>
                        <th width="324">mysql 消息 </th>
                        <th width="325">请求时间</th>
                        <th width="161">IP</th>
                        
                    </tr>

<{$data.0}>

                    
                  

                    
                    </table>
                    
                    
                    <div class="th"><!--/ pages-->
                            
                            <div class="pages">
                            	<{$data.1}>
                            </div>
                    	<div class="form">
                        	<input type="button" value="删除多余管理日志" onClick="location.href='?c=log&a=log_mysql_delete&delete=yes'"   />&nbsp;&nbsp;&nbsp;[&nbsp;系统将保留最后100条数据&nbsp;]
                        
                        </div>
                    </div>
                    
                </div>

				</form>
            </div><!--/ con-->
            
            
            
            
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<{include file='footer.tpl'}>
