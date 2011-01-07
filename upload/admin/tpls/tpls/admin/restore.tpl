<{include file=header.tpl}>
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

<div class="wrap">
    <div class="container">

        <div id="main">
                
            <div class="con">
            	<form action='?c=restore&a=delete_backup_file' method='post'>
                  <div class="table">
                    <div style="padding: 10px;">
                       <h4>��ʾ��Ϣ��</h4>
                                                              �������ڻָ��������ݵ�ͬʱ,������ԭ������,��ȷ���Ƿ���Ҫ�ָ�,�������������ʧ�� <br/> ���ݿⱸ��Ŀ¼ admin/data/backup/
                    </div>
                    <div class="box-header">
                        <h4>ϵͳ�����ļ�</h4>
                    </div>
                    <table class="admin-tb" id="tb1">
                    <tr>
                    	<th width="70">ɾ��</th>
                    	<th width="300">�ļ���</th>
                    	<th width="100">����ʱ��</th>
                    	<th width="100">����</th>
                    </tr>
                    <{foreach from=$list item=current_row key=row_id }>
                    <tr>
                        <td><input type='checkbox' name='file[]' value='<{$current_row.name}>' /></td>
                        <td><{$current_row.name}></td>
                        <td><{$current_row.time}></td>
                        <td><a href='?c=restore&a=restore&pre=<{$current_row.pre}>'>����</a></td>
                    </tr>
                    <{/foreach}>

                    <tr class="foot-ctrl">
                    <td colspan="6" class="gray">ѡ��: <a href="#" onclick="checkTb1(1);">ȫѡ</a> - <a href="#" onclick="checkTb1(3);">��ѡ</a> - <a href="#" onclick="checkTb1(2);">��</a></td>
                    </tr>
                    </table>
                    
                    <div class="th">
                    	<div class="form">
                        <input type="submit" value="ɾ��" />&nbsp;
                        </div>
                    </div>
                </div>

				</form>




            </div><!--/ con-->
            
            
            
            
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<{include file=footer.tpl}>
