<{include file='header.tpl'}>


<body id="main_page">

<div class="wrap">
    <div class="container">

        <div id="main">
            
            <div class="con">
            	<form action="<{$sys.formurl}>" method="get">
                  <div class="table">
                  	<div class="th">
                    	<div class="form"><strong>����Ա������־&nbsp;</strong></div>
                    </div>
                    <table class="admin-tb" id="tb1">
                    <tr>
                    	<th width="41" class="text-center">�û���</th>
                        <th width="300">������־</th>
                        <th width="300">����¼ʱ��</th>
                        <th width="200">����¼IP</th>
                        <th>����</th>
                        
                    </tr>

<{$data.0}>

                    
                  

                    
                    </table>
                    
                    
                    <div class="th"><!--/ pages-->
                            
                            <div class="pages">
                            	<{$data.1}>
                            </div>
                    	<div class="form">
                        	<input type="button" value="ɾ�����������־" onClick="location.href='?c=log&a=log_admin_delete&delete=yes'"   />&nbsp;&nbsp;&nbsp;[&nbsp;ϵͳ���������100������&nbsp;]
                        
                        </div>
                    </div>
                    
                </div>

				</form>
            </div><!--/ con-->
            
            
            
            
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<{include file='footer.tpl'}>
