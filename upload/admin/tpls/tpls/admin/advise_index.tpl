<{include file="header.tpl"}>

<script type="text/javascript">
                    	$(document).ready(function(){
							$("#js_data_source").find("input[rel='del']").each(function(i){
								$(this).bind("click",function(){
									var tr = $(this).parent().parent();
									var input = tr.find("input[rel='dis']");
									if(this.checked){
										$(input).attr("checked","");
										$(input).attr("disabled","disabled");
									}
									else{
										$(input).attr("disabled","");
									}
								});								
							});
							$("#js_data_source").find("input[rel='dis']").change(function(){
                                if ($(this).next('input[type="hidden"]').val() == 1) $(this).next('input[type="hidden"]').val(0);
                                else $(this).next('input[type="hidden"]').val(1);
							});
						});
                    </script>

<div class="wrap">
    <div class="container">

        <div id="main">
            <div id="nav" style="display:none">
            <dl>
	            <dt>��ǰλ�ã�</dt>
	            <dd class="link"><a href="#">��ҳ����</a></dd>
	            <dd>ר�����</dd>
            </dl>
            </div>
            <div class="con ">
            	<form action="<{$sys.subform}>" method="post">
            	  <div class="table">
               	  <div class="th">
                    	<div class="form">
                        <input type="button" value="��ӹ��" onclick="location.href='?c=advise_index&a=advise_index_add&action=<{$smarty.request.action}>'"/>&nbsp;</div>
                    </div>
                    
                   
                    
<table class="admin-tb" id="js_data_source">
<tr><td colspan="11" class=head>������</td></tr>
<tr align="center">
    <td class=cbg width="5%">ɾ��</td>
    <td class=cbg width="10%">����</td>
    <td class=cbg width="10%">˳��</td>
    <td class=cbg width="10%">�������</td>
    <td class=cbg width="41%">�������</td>
    <td width="9%" class=cbg>����ʱ��</td>		
    <td class=cbg width="5%">����</td>
    
</tr>
                
<{foreach from=$data item=v key=k}>
<tr align="center" class=b>
    <td  class="text-center" ><input name="id[]" type="checkbox" id="id[]" value="<{$v.id}>"></td>
    <td > <input type="checkbox" name="applyid[]" value="<{$v.id}>" <{if 1==$v.state}>checked<{/if}>  >
    	  <input name="select_id_all[]" type="hidden" id="select_id_all[]" value="<{$v.id}>"/>
    </td>
    <td ><{$v.vieworder}></td>
    <td ><{$v.varname}></td>
    <td ><{$v.title}></td>
    <td ><{$v.endtime}></td>
    
    <td ><a href="?c=advise_index&a=advise_index_save&id=<{$v.id}>&action=<{$smarty.request.action}>">�༭</a></td>
		
</tr>
<{/foreach}>

</table>
               
<script>
$("#js_data_source").find("input[rel='dis']").change(function(){
                                if ($(this).next('input[type="hidden"]').val() == 1) $(this).next('input[type="hidden"]').val(0);
                                else $(this).next('input[type="hidden"]').val(1);
							});
</script>
                    
                    <div class="th">
                        
                        
                   	  <div class="form">
                        <div class="form">
<label><input type="radio" name="subaction" value="delete">ɾ��</label> &nbsp; 
<label><input name="subaction" type="radio" value="display" checked>����</label> &nbsp; 
  &nbsp;&nbsp;&nbsp;
  <input type="submit" name="Submit3" value="�ύ�޸�"><input name="action" type="hidden" id="action" value="<{$smarty.request.action}>">

                    	
                    	<input name="step" type="hidden" id="step" value="2">
                    	</div>&nbsp;
                        </div>
                    </div>
                </div>
				</form>
            </div><!--/ con-->
        </div>    
    </div><!--/ container-->
    </div><!--/ wrap-->
<{include file="footer.tpl"}>