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


    <div class="container">

        <div id="main">
            
            <div class="con ">
            	<form action="<{$sys.formurl}>" method="post">
                  <div class="table">
                  	<div class="th">
                    	<div class="form">
                    	  <input type="button" value="添加新管理员" onClick="location.href='?c=member&a=member_add'" />&nbsp;</div>
                    </div>
                    <table class="admin-tb" id="tb1">
                    <tr>
                    	<th width="41" class="text-center"><input type="checkbox" rel="control" onClick="this.checked?checkTb1(1):checkTb1(2);" /></th>
                    	<th width="97">用户名</th>
                        <th width="448">等级</th>
                        <th width="324">最后登录时间</th>
                        <th width="261">最后登录IP</th>
                        <th width="225">操作</th>
                        
                    </tr>
<{foreach from=$data item=v key=k}>
                    <tr>  <!-- <tr class="checked">默认选中 -->
                    <td class="text-center">
                    <{if '超级管理员'!=$v.levelshow}>
                    <input name="id[]" type="checkbox" id="id[]" value="<{$v.name}>"  />
                    <{/if}>
                    </td>
                    <td><{$v.name}>&nbsp;</td>
                    <td><{$v.levelshow}></td>
                    <td><{$v.lastvisit|date_format:$date_format}>&nbsp;</td>
                    <td><{$v.lastip}>&nbsp;</td>
                    <td>
                    <{if '超级管理员'!=$v.levelshow}>
                    <a href="?c=member&a=member_edit&name=<{$v.name}>">权限</a>
                    <{/if}>
                                        <{if '超级管理员'!=$v.levelshow}>
                    <a href="?c=member&a=member_password&name=<{$v.name}>">密码</a>
                    <{/if}>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <{if '超级管理员'!=$v.levelshow}>
                    <a href="?c=member&a=member_delete&id=<{$v.name}>">删除</a>
                    <{/if}>
                    </td>
                    </tr>
<{/foreach}>
                    
                    <tr class="foot-ctrl">
                    <td colspan="6" class="gray">选择: <a href="#" onClick="checkTb1(1);">全选</a> - <a href="#" onClick="checkTb1(3);">反选</a> - <a href="#" onClick="checkTb1(2);">无</a></td>
                    </tr>

                    
                    </table>

                    <div class="th"><!--/ pages-->
                            
                            
                    	<div class="form">
                        <input name="提交" type="submit" value="删 除" />
                    	</div>
                    </div>
                </div>

				</form>
            </div><!--/ con-->
            
            
            
            
            
        </div>    
    </div><!--/ container-->


<{include file='footer.tpl'}>
