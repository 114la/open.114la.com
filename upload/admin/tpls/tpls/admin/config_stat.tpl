<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        
        <div id="main">
            
            
            <div class="con box-green">
                <form method="post" action="?c=config&a=stat">
                <div class="box-header">
                    <h4>����IPͳ��</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120"><input type="radio" name="ip" id="ip_off" /></th>
                            <td>
                                <label for="ip_off">�ر�</label>
                            </td>
                        </tr>
                        <tr>
                            <th><input type="radio" name="ip" id="ip_on" /></th>
                            <td>
                                <label for="ip_on">����</label>                             
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-header">
                    <h4>����ISPͳ�� <span class="green font-n">(�ڿ���IPͳ�Ƶ��������Ч)</span></h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120"><input type="radio" name="isp" id="isp_off" /></th>
                            <td>
                                <label for="isp_off">�ر�</label>
                            </td>
                        </tr>
                        <tr>
                            <th><input type="radio" name="isp" id="isp_on" /></th>
                            <td>
                                <label for="isp_on">����</label>                             
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="�������" /> �� <a href="#">ȡ��</a>
                    </div>
                </div>
                </form>
            </div><!--/ con-->
            
            
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<{include file=footer.tpl}>
