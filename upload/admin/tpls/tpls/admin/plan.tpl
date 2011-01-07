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

<{if $action == 'add'}>
<div class="wrap">
    <div class="container">
        
        <div id="main">
  
            
            <div class="con box-green">
                <form action="?c=plan&a=add" method='post'>
                <div class="box-header">
                    <h4>计划任务</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120">任务标题：</th>
                            <td><input type="text" class="textinput w360" name="title" value='<{$plan.subject}>'  /></td>
                        </tr>
                        <tr>
                            <th>执行php文件名：</th>
                            <td><input type="text" class="textinput w360" name="filename" value='<{$plan.filename}>'  /></td>
                        </tr>
                        <tr>
                            <th>每月：</th>
                            <td>
                                <select name="month">
                                    <{html_options  options=$option_days selected=$plan.month }>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>每周：</th>
                            <td>
                                <select name="week">
                                    <{html_options  options=$option_weekdays selected=$plan.week }>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>每天：</th>
                            <td>
                                <select name="day">
                                    <{html_options  options=$option_hours selected=$plan.day }>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>每时：</th>
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
                            <th>是否开启该计划任务：</th>
                            <td>
                                <{html_radios name="ifopen" options=$option_toggle checked=$plan.ifopen|default:1}>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="保存更改" /> 或 <a href="?c=plan&a=index">取消</a>
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
                    <h4>计划任务</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120">任务标题：</th>
                            <td><input type="text" class="textinput w360" name="title" value='<{$plan.subject}>'  /></td>
                        </tr>
                        <tr>
                            <th>执行文件名：</th>
                            <td><input type="text" class="textinput w360" name="filename" value='<{$plan.filename}>'  /></td>
                        </tr>
                        <tr>
                            <th>每月几号执行：</th>
                            <td>
                                <select name="month">
                                    <{html_options  options=$option_days selected=$plan.month }>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>每周星期几执行：</th>
                            <td>
                                <select name="week">
                                    <{html_options  options=$option_weekdays selected=$plan.week }>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>每日几点执行：</th>
                            <td>
                                <select name="day">
                                    <{html_options  options=$option_hours selected=$plan.day }>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>每小时几分钟执行：</th>
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
                            <th>是否开启该计划任务：</th>
                            <td>
                                <{html_radios name="ifopen" options=$option_toggle checked=$plan.ifopen}>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="保存更改" /> 或 <a href="?c=plan&a=index">取消</a>
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
                    <h4>计划任务</h4>
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
                    	<th width="41" class="text-center">删除</th>
                    	<th width="97">序号</th>
                    	<th width="100">任务标题</th>
                    	<th width="100">分钟</th>
                    	<th width="100">小时</th>
                    	<th width="100">星期</th>
                    	<th width="100">日</th>
                        <th width="200">上次执行时间</th>
                        <th width="200">下次执行时间</th>
                        <th width="161">设置</th>
                        <th width="161">运行</th>
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
                        <td><input type="button" value="设置" onclick="window.location=('?c=plan&a=edit&id='+<{$current_plan.id}>)" /></td>
                        <td><input type="button" value="运行" onclick="window.location=('?c=plan&a=execute&id='+<{$current_plan.id}>)" /></td>
                    </tr>
                    <{/foreach}>
                    <tr class="foot-ctrl">
                    <td colspan="11" class="gray">选择: <a href="#" onclick="checkTb1(1);">全选</a> - <a href="#" onclick="checkTb1(3);">反选</a> - <a href="#" onclick="checkTb1(2);">无</a></td>
                    </tr>
                    </table>
                    <div class="th">
                    	<div class="form">
                        <input type="submit" value="删除" />&nbsp;
                        <input type="button" onclick="window.location='?c=plan&a=add'" value="添加任务" />&nbsp;
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
