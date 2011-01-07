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
<body id="main_page">

<div class="wrap">
    <div class="container">

        <div id="main">

            <div class="con">
            	<form action="<{$sys.subform}>" method="post">
                  <div class="table">
                  <div class="th">
                    	<div class="form">
                    	  <input type="button" value="添加模板" onClick="location.href='?c=template_manage&a=template_add'" />&nbsp;</div>
                    </div>

                    <table class="admin-tb" id="tb1">
                    <tr>
                    	<th width="41" class="text-center"><input type="checkbox" rel="control" onClick="this.checked?checkTb1(1):checkTb1(2);" /></th>
                        <th width="150">模板名称</th>
                        <th width="180">模板文件</th>
                        <th width="180">添加时间</th>
                        <th width="80">备份模板</th>
                        <th width="80">还原模板</th>
                        <th width="79">删除</th>
                        <th>修改</th>

                    </tr>
                <{foreach from=$data item=v key=k}>
                    <tr>  <!-- <tr class="checked">默认选中 -->
                    <td class="text-center"><{if $v.id!=1}><input name="id[]" type="checkbox" id="id[]" value="<{$v.id}>" /><{/if}></td>
                    <td><{$v.tpl_name}></td>
                    <td><{$v.tpl_file}></td>
                    <td><{$v.add_time|date_format:"%Y-%m-%d %H:%M:%S"}></td>
                    <td><{if $v.id==1}>备份模板<{else}><a href="?c=template_manage&a=backup&filename=<{$v.tpl_file}>">备份模板</a><{/if}></td>
                    <td><a href="?c=template_manage&a=restore&filename=<{$v.tpl_file}>">还原模板</a></td>
                    <td><{if $v.id==1}>删除<{else}><a href="?c=template_manage&a=template_delete&id=<{$v.id}>">删除</a><{/if}></td>
                    <td><a href="?c=template_manage&a=template_edit&id=<{$v.id}>">修改</a></td>
                    </tr>
                <{/foreach}>

                    <tr class="foot-ctrl">
                    <td colspan="8" class="gray">选择: <a href="#" onClick="checkTb1(1);">全选</a> - <a href="#" onClick="checkTb1(3);">反选</a> - <a href="#" onClick="checkTb1(2);">无</a></td>
                    </tr>

                    </table>

                    <div class="th"><!--/ pages-->

                    	<div class="form">
                            <input type="submit" name="Submit3" value=" 删除所选 ">
                    	</div>
                    </div>
                </div>

				</form>
            </div><!--/ con-->





        </div>
    </div><!--/ container-->

</div><!--/ wrap-->
<{include file='footer.tpl'}>
