<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        <div id="main">
            <div class="con box-green">
                <form action="?c=famous_tab&a=save" method="post">
                <input type="hidden" name="action" value="<{$action}>"/>
                <input type="hidden" name="id" value="<{$id}>"/>
                <input type="hidden" name="referer" value="<{$referer}>"/>
                <div class="box-header">
                    <h4><{if $action eq 'modify'}>�޸�<{else}></>���<{/if}>��ַ</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120">��ǩ���ƣ�</th>
                            <td><input type="text" name="name" value="<{$data.name}>" class="textinput w270" /></td>
                        </tr>
                        <tr>
                            <th>ifreme��ַ��</th>
                            <td><input type="text" name="url" value="<{$data.url}>" class="textinput w270" /></td>
                        </tr>
                        
                        <tr>
                            <th>����</th>
                            <td><input type="text" name="order" value="<{$data.order}>" class="textinput w60"   onkeyup="value=value.replace(/[^\d]/g,'')" /></td>
                        </tr>
                        
                        <tr>
                            <th>�Ƿ񻺴棺</th>
                            <td><label><input type="radio" name="nocache" value='0' <{if $data.nocache eq 0}>checked="checked"<{/if}>  />��</label>&nbsp;&nbsp;&nbsp;<label><input type="radio" name="nocache" value='1' <{if $data.nocache}>checked="checked"<{/if}> />��</label>
								
                                
                                </td>
                        </tr>
                        <tr>
                        	<th>&nbsp;</th>
                            <td><p>���ﻺ����ָҳ���ڲ�ˢ������£�ֻ����iframeһ��,���������л�Tabʱÿ�ζ�ȥ���ء�<br />
                                	��ѡ�񲻻�����ÿ���л�Tabʱ�����¼��أ�����ǰTabû�б�����,��iframe�ᱻ��ա�<br />
									<em style="color:red; font-style:normal">����ֻ�ڡ���Ʊ��顱����ˢ�����ݵ�iframeѡ�񲻻��档</em><br />

                                </p>
                                
                                </td>
                        </tr>
                        
                        
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="�ύ" /></a> �� <a href="?c=famous_tab&a=index&classid=<{$data.class}>">ȡ��</a>
                    </div>
                </div>
                </form>
            </div><!--/ con-->
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<{include file=footer.tpl}>
