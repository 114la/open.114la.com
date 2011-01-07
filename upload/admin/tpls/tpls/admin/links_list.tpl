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
                    <input type="hidden" name="referer" value="<{$sys.goback}>"/>
                  <div class="table">
                  <div class="th">
                    	<div class="form">
                    	  <input type="button" value="�����������" onClick="location.href='?c=links&a=links_add'" />&nbsp;</div>
                    </div>

                    <table class="admin-tb" id="tb1">
                    <tr>
                    	<th width="41" class="text-center"><input type="checkbox" rel="control" onClick="this.checked?checkTb1(1):checkTb1(2);" /></th>
                        <th width="50">����</th>
                        <th width="50">��ҳ��ʾ</th>
                        <th width="150">վ������</th>
                        <th width="180">վ���ַ</th>
                        <th width="180">���ʱ��</th>
                        <th width="79">ɾ��</th>
                        <th>�޸�</th>

                    </tr>
                <{foreach from=$data item=v key=k}>
                    <tr>  <!-- <tr class="checked">Ĭ��ѡ�� -->
                    <td class="text-center"><input name="id[]" type="checkbox" id="id[]" value="<{$v.id}>" /></td>
                    <td><input type="text" name="sort[<{$v.id}>]" class="textinput" tabindex="11" value="<{$v.sort}>" /></td>
                    <td><input name="is_show[]" type="checkbox" id="is_show[]" value="<{$v.id}>" <{if $v.is_show}>checked<{/if}> /></td>
                    <td><{$v.site_name}></td>
                    <td><{$v.site_url}></td>
                    <td><{$v.add_time|date_format:"%Y-%m-%d %H:%M:%S"}></td>
                    <td><{if $v.id==1}>ɾ��<{else}><a href="?c=links&a=links_operate&id=<{$v.id}>">ɾ��</a><{/if}></td>
                    <td><a href="?c=links&a=links_edit&id=<{$v.id}>">�޸�</a></td>
                    </tr>
                <{/foreach}>

                    <tr class="foot-ctrl">
                    <td colspan="8" class="gray">ѡ��: <a href="#" onClick="checkTb1(1);">ȫѡ</a> - <a href="#" onClick="checkTb1(3);">��ѡ</a> - <a href="#" onClick="checkTb1(2);">��</a></td>
                    </tr>

                    </table>

                    <div class="th"><!--/ pages-->

                    	<div class="form">
                            <input type="submit" name="Submit3" value=" �ύ�޸� ">
                    	</div>
                    </div>
                </div>

				</form>
            </div><!--/ con-->





        </div>
    </div><!--/ container-->

</div><!--/ wrap-->
<{include file='footer.tpl'}>
