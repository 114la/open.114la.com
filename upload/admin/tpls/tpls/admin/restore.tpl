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
				case 1:	//全选
					childs[i].checked = true;
					break;
				case 2:	//不选
					childs[i].checked = false;
					break;
				case 3:	//反选
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
                       <h4>提示信息：</h4>
                                                              本功能在恢复备份数据的同时,将覆盖原有数据,请确定是否需要恢复,以免造成数据损失。 <br/> 数据库备份目录 admin/data/backup/
                    </div>
                    <div class="box-header">
                        <h4>系统备份文件</h4>
                    </div>
                    <table class="admin-tb" id="tb1">
                    <tr>
                    	<th width="70">删除</th>
                    	<th width="300">文件名</th>
                    	<th width="100">备份时间</th>
                    	<th width="100">导入</th>
                    </tr>
                    <{foreach from=$list item=current_row key=row_id }>
                    <tr>
                        <td><input type='checkbox' name='file[]' value='<{$current_row.name}>' /></td>
                        <td><{$current_row.name}></td>
                        <td><{$current_row.time}></td>
                        <td><a href='?c=restore&a=restore&pre=<{$current_row.pre}>'>导入</a></td>
                    </tr>
                    <{/foreach}>

                    <tr class="foot-ctrl">
                    <td colspan="6" class="gray">选择: <a href="#" onclick="checkTb1(1);">全选</a> - <a href="#" onclick="checkTb1(3);">反选</a> - <a href="#" onclick="checkTb1(2);">无</a></td>
                    </tr>
                    </table>
                    
                    <div class="th">
                    	<div class="form">
                        <input type="submit" value="删除" />&nbsp;
                        </div>
                    </div>
                </div>

				</form>




            </div><!--/ con-->
            
            
            
            
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<{include file=footer.tpl}>
