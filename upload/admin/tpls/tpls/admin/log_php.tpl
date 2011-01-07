<{include file='header.tpl'}>


<body id="main_page">

<div class="wrap">
    <div class="container">

        <div id="main">
            
            <div class="con">
            	<form action="<{$sys.formurl}>" method="get">
                  <div class="table">
                  	<div class="th">
                    	<div class="form"><strong>PHP系统操作日志&nbsp;</strong></div>
                    </div>
                    <table class="admin-tb" id="tb1">
                    <tr>
                    	<th class="text-center">级别</th>
                    	<th width="444">操作时间</th>
                        <th width="321">错误原因</th>
                        <th width="322">错误档案</th>
                        <th width="162">行数</th>
                        
                    </tr>

<{$data.0}>

                    
                  

                    
                    </table>
                    
                    
                    <div class="th"><!--/ pages-->
                            
                      <div class="pages">
                            	<{$data.1}>
                            </div>
                    	<div class="form">
                        	<input type="button" value="删除多余管理日志" onClick="location.href='?c=log&a=log_php_delete&delete=yes'"   />&nbsp;&nbsp;&nbsp;[&nbsp;系统将保留最后100条数据&nbsp;]
                        
                        </div>
                    </div>
                    
                </div>

				</form>
            </div><!--/ con-->
            
            
            
            
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<{include file='footer.tpl'}>
