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
    function tiaozhun(obj)
    {
        if(obj.value == "") return;
        location.href = "?c=search&classid=" + obj.value;
    }
</script>
<body id="main_page">

<div class="wrap">
    <div class="container">

        <div id="main">

            <div class="con">
            	<form action="<{$sys.subform}>" method="post">
                    <input type="hidden" name="referer" value="<{$sys.goback}>"/>
                  <div class="table">
                  <div class="th">
                    <div class="form">
                    	<input type="button" value="添加搜索引擎" onClick="location.href='?c=search&a=search_add'" />&nbsp;
                        <select name="classid" onchange="tiaozhun(this)">
                            <{html_options options=$options selected=$classid}>
                        </select>
                    </div>
                    </div>

                    <table class="admin-tb" id="tb1">
                    <tr>
                    	<th width="41" class="text-center">删除</th>
                        <th width="50">排序</th>
                        <th width="50">默认</th>
                        <th width="50">显示</th>
                        <th width="100">名称</th>
                        <th width="100">分类</th>
                        <th width="250">接口地址</th>
                        <th width="50">删除</th>
                        <th>修改</th>

                    </tr>
                <{foreach from=$data item=v key=k}>
                    <tr>  <!-- <tr class="checked">默认选中 -->
                    <td class="text-center"><input name="id[]" type="checkbox" id="id[]" value="<{$v.id}>" /></td>
                    <td><input type="text" name="sort[<{$v.id}>]" class="textinput" tabindex="11" value="<{$v.sort}>" /></td>
                    <td><input name="is_default" type="radio" id="is_default" value="<{$v.id}>" <{if $v.is_default}>checked<{/if}> /></td>
                    <td><input name="is_show[]" type="checkbox" id="is_show[]" value="<{$v.id}>" <{if $v.is_show}>checked<{/if}> /></td>
                    <td><{$v.search_select}></td>
                    <td><{$v.classname}></td>
                    <td><{$v.action}></td>
                    <td><a href="?c=search&a=search_operate&classid=<{$v.class}>&id=<{$v.id}>">删除</a></td>
                    <td><a href="?c=search&a=search_edit&id=<{$v.id}>">修改</a></td>
                    </tr>
                <{/foreach}>

                    <tr class="foot-ctrl">
                    <td colspan="9" class="gray">选择: <a href="#" onClick="checkTb1(1);">全选</a> - <a href="#" onClick="checkTb1(3);">反选</a> - <a href="#" onClick="checkTb1(2);">无</a></td>
                    </tr>

                    </table>

                    <div class="th"><!--/ pages-->

                    	<div class="form">
                            <input type="submit" name="Submit3" value=" 提交修改 ">
                    	</div>
                    </div>
                </div>

				</form>
            </div><!--/ con-->





        </div>
    </div><!--/ container-->

</div><!--/ wrap-->
<{include file='footer.tpl'}>
