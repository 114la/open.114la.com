<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        
        <div id="main">
  
            
            <div class="con box-green">
                <form method="post" action="?c=config&a=info">
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120">ϵͳ���⣺</th>
                            <td><input type="text" class="textinput w360" name="config[sysname]" value="<{$config.yl_sysname}>" /></td>
                        </tr>
                        <tr>
                            <th>ϵͳ��ַ��</th>
                            <td><input type="text" class="textinput w360" name="config[sysurl]" value="<{$config.yl_sysurl}>"  /></td>
                        </tr>
                        <tr>
                            <th>��ϵ����URL��</th>
                            <td><input type="text" class="textinput w360" name="config[ceoconnect]" value="<{$config.yl_ceoconnect}>" /></td>
                        </tr>
                        <tr>
                            <th>����Ա���䣺</th>
                            <td><input type="text" class="textinput w360" name="config[ceoemail]" value="<{$config.yl_ceoemail}>"  /></td>
                        </tr>
                        <tr>
                            <th>ICP������Ϣ��</th>
                            <td><input type="text" class="textinput w360" name="config[icp]" value="<{$config.yl_icp}>"  /></td>
                        </tr>
                        <tr>
                            <th>ICP�������ӵ�ַ��</th>
                            <td><input type="text" class="textinput w360" name="config[icpurl]" value="<{$config.yl_icpurl}>"  /></td>
                        </tr>
                        <tr>
                            <th>keywords��</th>
                            <td><input type="text" class="textinput w360" name="config[metakeyword]" value="<{$config.yl_metakeyword}>"  /></td>
                        </tr>
                        <tr>
                            <th  style="vertical-align:top;">description��</th>
                            <td><textarea class="w360" name="config[metadescrip]"><{$config.yl_metadescrip}></textarea></td>
                        </tr>
                        <tr>
                            <th  style="vertical-align:top;">ͳ�ƴ��룺</th>
                            <td><textarea class="w360" name="config[ipstat]"><{$config.yl_ipstat}></textarea></td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="�������" />
                    </div>
                </div>
                </form>
            </div><!--/ con-->
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<{include file=footer.tpl}>
