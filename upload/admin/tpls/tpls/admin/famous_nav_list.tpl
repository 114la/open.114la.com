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
<body id="main_page">

<div class="wrap">
    <div class="container">

        <div id="main">
            
            <div class="con">
            	<form action="<{$sys.subform}>" method="post">
                  <div class="table">
                  	<div class="th">
                    	<div class="form">
                    	  <input type="button" value="�����վ" onClick="location.href='?c=famous_nav&a=famous_nav_add'" />&nbsp;</div>
                    </div>
                    <table class="admin-tb" id="tb1">
                    <tr>
                    	<th width="41" class="text-center"><input type="checkbox" rel="control" onClick="this.checked?checkTb1(1):checkTb1(2);" /></th>
                        <th width="100">����</th>
                        <th width="150">����</th>
                        <th width="180">��ַ</th>
                        <th width="79">��ʼʱ��</th>
                        <th >����ʱ��</th>
                        
                    </tr>
<{foreach from=$data item=v key=k}>
                    <tr>  <!-- <tr class="checked">Ĭ��ѡ�� -->
                    <td class="text-center"><input name="id[]" type="checkbox" id="id[]" value="<{$v.id}>"  /></td>
                    <td><input name="orderby[<{$v.id}>]" type="text" id="orderby[<{$v.id}>]" class="textinput" value="<{$v.displayorder}>"></td>
                    <td><a href="?c=famous_nav&a=famous_nav_save&id=<{$v.id}>"><span style="color:<{$v.namecolor}>"><{$v.name}></span></a></td>
                    <td><div style="width:180px;" class="hideText" title="<{$v.url}>"><{$v.url}></div></td>
                    <td><{$v.starttime}></td>
                    <td><{$v.endtime}></td>
                    </tr>
<{/foreach}>
                    
                    <tr class="foot-ctrl">
                    <td colspan="7" class="gray">ѡ��: <a href="#" onClick="checkTb1(1);">ȫѡ</a> - <a href="#" onClick="checkTb1(3);">��ѡ</a> - <a href="#" onClick="checkTb1(2);">��</a></td>
                    </tr>

                    
                    </table>

                    <div class="th"><!--/ pages-->
                            
                            
                    	<div class="form">
                    	  <label>
                    	     &nbsp; <label><input type="radio" name="action" value="delete">ɾ��</label>
                            <input name="action" type="radio" value="order" checked>����</label>  &nbsp;&nbsp;&nbsp;
                            <input type="submit" name="Submit3" value="�ύ�޸�">
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
