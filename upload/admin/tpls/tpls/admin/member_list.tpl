<{include file='header.tpl'}>


<script type="text/javascript">
	var list;
	$(document).ready(function(){
		list = $("#tb1").find("input[type='checkbox']").not("[rel]");
		list.each(function(i){
			$(this).bind("click",function(){
				CheckHanler();
			});
		});
	});
	
	var CheckHanler = function(){
		list.each(function(i){
			var input = $(this);
			if(this.checked){
				input.parent().parent().addClass("checked");
			}
			else{
				input.parent().parent().removeClass("checked");
			}
		});
	}
	
	var checkTb1 = function(selectType){
		CheckInit("tb1",selectType);
	}
	
	var CheckInit = function(tabelId,selectType){
		if(list == undefined){
			list = $("#" + tabelId).find("input[type='checkbox']").not("[rel]");
		}
		CheckControl(list,selectType,CheckHanler)
	}
	
	var CheckControl = function(childs,selectType,checkHandler){
		for(var i = 0,len = childs.length; i < len; i++){
			switch(selectType){
				case 1:	//ȫѡ
					childs[i].checked = true;
					break;
				case 2:	//��ѡ
					childs[i].checked = false;
					break;
				case 3:	//��ѡ
					childs[i].checked = !childs[i].checked;
					break;
			}
		}
		if(checkHandler){
			checkHandler();
		}
	}
</script>


    <div class="container">

        <div id="main">
            
            <div class="con ">
            	<form action="<{$sys.formurl}>" method="post">
                  <div class="table">
                  	<div class="th">
                    	<div class="form">
                    	  <input type="button" value="����¹���Ա" onClick="location.href='?c=member&a=member_add'" />&nbsp;</div>
                    </div>
                    <table class="admin-tb" id="tb1">
                    <tr>
                    	<th width="41" class="text-center"><input type="checkbox" rel="control" onClick="this.checked?checkTb1(1):checkTb1(2);" /></th>
                    	<th width="97">�û���</th>
                        <th width="448">�ȼ�</th>
                        <th width="324">����¼ʱ��</th>
                        <th width="261">����¼IP</th>
                        <th width="225">����</th>
                        
                    </tr>
<{foreach from=$data item=v key=k}>
                    <tr>  <!-- <tr class="checked">Ĭ��ѡ�� -->
                    <td class="text-center">
                    <{if '��������Ա'!=$v.levelshow}>
                    <input name="id[]" type="checkbox" id="id[]" value="<{$v.name}>"  />
                    <{/if}>
                    </td>
                    <td><{$v.name}>&nbsp;</td>
                    <td><{$v.levelshow}></td>
                    <td><{$v.lastvisit|date_format:$date_format}>&nbsp;</td>
                    <td><{$v.lastip}>&nbsp;</td>
                    <td>
                    <{if '��������Ա'!=$v.levelshow}>
                    <a href="?c=member&a=member_edit&name=<{$v.name}>">Ȩ��</a>
                    <{/if}>
                                        <{if '��������Ա'!=$v.levelshow}>
                    <a href="?c=member&a=member_password&name=<{$v.name}>">����</a>
                    <{/if}>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <{if '��������Ա'!=$v.levelshow}>
                    <a href="?c=member&a=member_delete&id=<{$v.name}>">ɾ��</a>
                    <{/if}>
                    </td>
                    </tr>
<{/foreach}>
                    
                    <tr class="foot-ctrl">
                    <td colspan="6" class="gray">ѡ��: <a href="#" onClick="checkTb1(1);">ȫѡ</a> - <a href="#" onClick="checkTb1(3);">��ѡ</a> - <a href="#" onClick="checkTb1(2);">��</a></td>
                    </tr>

                    
                    </table>

                    <div class="th"><!--/ pages-->
                            
                            
                    	<div class="form">
                        <input name="�ύ" type="submit" value="ɾ ��" />
                    	</div>
                    </div>
                </div>

				</form>
            </div><!--/ con-->
            
            
            
            
            
        </div>    
    </div><!--/ container-->


<{include file='footer.tpl'}>
