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

<{if $action == 'add'}>
<div class="wrap">
    <div class="container">
        
        <div id="main">
  
            
            <div class="con box-green">
                <form action="?c=plan&a=add" method='post'>
                <div class="box-header">
                    <h4>�ƻ�����</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120">������⣺</th>
                            <td><input type="text" class="textinput w360" name="title" value='<{$plan.subject}>'  /></td>
                        </tr>
                        <tr>
                            <th>ִ��php�ļ�����</th>
                            <td><input type="text" class="textinput w360" name="filename" value='<{$plan.filename}>'  /></td>
                        </tr>
                        <tr>
                            <th>ÿ�£�</th>
                            <td>
                                <select name="month">
                                    <{html_options  options=$option_days selected=$plan.month }>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>ÿ�ܣ�</th>
                            <td>
                                <select name="week">
                                    <{html_options  options=$option_weekdays selected=$plan.week }>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>ÿ�죺</th>
                            <td>
                                <select name="day">
                                    <{html_options  options=$option_hours selected=$plan.day }>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>ÿʱ��</th>
                            <td>
                                <select name="hours[]">
                                    <{html_options  options=$option_minutes selected=$plan.hour[0] }>
                                </select>
                                <select name="hours[]">
                                    <{html_options  options=$option_minutes selected=$plan.hour[1] }>
                                </select>
                                <select name="hours[]">
                                    <{html_options  options=$option_minutes selected=$plan.hour[2] }>
                                </select>
                                <select name="hours[]">
                                    <{html_options  options=$option_minutes selected=$plan.hour[3] }>
                                </select>                           
                            </td>
                        </tr>
                        <tr>
                            <th>�Ƿ����üƻ�����</th>
                            <td>
                                <{html_radios name="ifopen" options=$option_toggle checked=$plan.ifopen|default:1}>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="�������" /> �� <a href="?c=plan&a=index">ȡ��</a>
                    </div>
                </div>
                </form>
            </div><!--/ con-->
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<{elseif $action == 'edit'}>
<div class="wrap">
    <div class="container">
        
        <div id="main">
  
            
            <div class="con box-green">
                <form action="?c=plan&a=edit&id=<{$plan.id}>" method='post'>
                <div class="box-header">
                    <h4>�ƻ�����</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120">������⣺</th>
                            <td><input type="text" class="textinput w360" name="title" value='<{$plan.subject}>'  /></td>
                        </tr>
                        <tr>
                            <th>ִ���ļ�����</th>
                            <td><input type="text" class="textinput w360" name="filename" value='<{$plan.filename}>'  /></td>
                        </tr>
                        <tr>
                            <th>ÿ�¼���ִ�У�</th>
                            <td>
                                <select name="month">
                                    <{html_options  options=$option_days selected=$plan.month }>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>ÿ�����ڼ�ִ�У�</th>
                            <td>
                                <select name="week">
                                    <{html_options  options=$option_weekdays selected=$plan.week }>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>ÿ�ռ���ִ�У�</th>
                            <td>
                                <select name="day">
                                    <{html_options  options=$option_hours selected=$plan.day }>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>ÿСʱ������ִ�У�</th>
                            <td>
                                <select name="hours[]">
                                    <{html_options  options=$option_minutes selected=$plan.hour[0] }>
                                </select>
                                <select name="hours[]">
                                    <{html_options  options=$option_minutes selected=$plan.hour[1] }>
                                </select>
                                <select name="hours[]">
                                    <{html_options  options=$option_minutes selected=$plan.hour[2] }>
                                </select>
                                <select name="hours[]">
                                    <{html_options  options=$option_minutes selected=$plan.hour[3] }>
                                </select>                           
                            </td>
                        </tr>
                        <tr>
                            <th>�Ƿ����üƻ�����</th>
                            <td>
                                <{html_radios name="ifopen" options=$option_toggle checked=$plan.ifopen}>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="�������" /> �� <a href="?c=plan&a=index">ȡ��</a>
                    </div>
                </div>
                </form>
            </div><!--/ con-->
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<{else}>
<div class="wrap">
    <div class="container">

        <div id="main">
            
            <div class="con">
            	<form action='?c=plan&a=index' method='post'>
                <div class="box-header">
                    <h4>�ƻ�����</h4>
                </div>
                  <div class="table">
                  	<div class="th">
                    	<div class="form">
                        <div class="fl">
                        </div>
                        
                        </div>
                    </div>
                    <table class="admin-tb" id="tb1">
                    <tr>
                    	<th width="41" class="text-center">ɾ��</th>
                    	<th width="97">���</th>
                    	<th width="100">�������</th>
                    	<th width="100">����</th>
                    	<th width="100">Сʱ</th>
                    	<th width="100">����</th>
                    	<th width="100">��</th>
                        <th width="200">�ϴ�ִ��ʱ��</th>
                        <th width="200">�´�ִ��ʱ��</th>
                        <th width="161">����</th>
                        <th width="161">����</th>
                    </tr>

                    <{foreach from=$plan_list item=current_plan }>
                    <tr>
                        <td> <input type="checkbox" name="remove_id[]" value="<{$current_plan.id}>" /></td>
                        <td><{$current_plan.id}></td>
                        <td><{$current_plan.subject}></td>
                        <td><{$current_plan.hour}></td>
                        <td><{$current_plan.day}></td>
                        <td><{$current_plan.week}></td>
                        <td><{$current_plan.month}></td>
                        <td><{$current_plan.usetime|date_format:$date_format}></td>
                        <td><{$current_plan.nexttime|date_format:$date_format}></td>
                        <td><input type="button" value="����" onclick="window.location=('?c=plan&a=edit&id='+<{$current_plan.id}>)" /></td>
                        <td><input type="button" value="����" onclick="window.location=('?c=plan&a=execute&id='+<{$current_plan.id}>)" /></td>
                    </tr>
                    <{/foreach}>
                    <tr class="foot-ctrl">
                    <td colspan="11" class="gray">ѡ��: <a href="#" onclick="checkTb1(1);">ȫѡ</a> - <a href="#" onclick="checkTb1(3);">��ѡ</a> - <a href="#" onclick="checkTb1(2);">��</a></td>
                    </tr>
                    </table>
                    <div class="th">
                    	<div class="form">
                        <input type="submit" value="ɾ��" />&nbsp;
                        <input type="button" onclick="window.location='?c=plan&a=add'" value="�������" />&nbsp;
                        </div>
                    </div>
                </div>

				</form>




            </div><!--/ con-->
            
            
            
            
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<{/if}>
<{include file=footer.tpl}>
