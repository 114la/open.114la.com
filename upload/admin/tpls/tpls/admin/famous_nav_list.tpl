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
                    	  <input type="button" value="添加名站" onClick="location.href='?c=famous_nav&a=famous_nav_add'" />&nbsp;</div>
                    </div>
                    <table class="admin-tb" id="tb1">
                    <tr>
                    	<th width="41" class="text-center"><input type="checkbox" rel="control" onClick="this.checked?checkTb1(1):checkTb1(2);" /></th>
                        <th width="100">排序</th>
                        <th width="150">名称</th>
                        <th width="180">网址</th>
                        <th width="79">开始时间</th>
                        <th >结束时间</th>
                        
                    </tr>
<{foreach from=$data item=v key=k}>
                    <tr>  <!-- <tr class="checked">默认选中 -->
                    <td class="text-center"><input name="id[]" type="checkbox" id="id[]" value="<{$v.id}>"  /></td>
                    <td><input name="orderby[<{$v.id}>]" type="text" id="orderby[<{$v.id}>]" class="textinput" value="<{$v.displayorder}>"></td>
                    <td><a href="?c=famous_nav&a=famous_nav_save&id=<{$v.id}>"><span style="color:<{$v.namecolor}>"><{$v.name}></span></a></td>
                    <td><div style="width:180px;" class="hideText" title="<{$v.url}>"><{$v.url}></div></td>
                    <td><{$v.starttime}></td>
                    <td><{$v.endtime}></td>
                    </tr>
<{/foreach}>
                    
                    <tr class="foot-ctrl">
                    <td colspan="7" class="gray">选择: <a href="#" onClick="checkTb1(1);">全选</a> - <a href="#" onClick="checkTb1(3);">反选</a> - <a href="#" onClick="checkTb1(2);">无</a></td>
                    </tr>

                    
                    </table>

                    <div class="th"><!--/ pages-->
                            
                            
                    	<div class="form">
                    	  <label>
                    	     &nbsp; <label><input type="radio" name="action" value="delete">删除</label>
                            <input name="action" type="radio" value="order" checked>排序</label>  &nbsp;&nbsp;&nbsp;
                            <input type="submit" name="Submit3" value="提交修改">
                    	<input name="step" type="hidden" id="step" value="2">
                    	</div>
                    </div>
                </div>

				</form>
            </div><!--/ con-->
            
            
            
            
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<{include file='footer.tpl'}>
