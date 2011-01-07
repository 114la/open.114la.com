<table width="98%" align="center" cellspacing="1" cellpadding="3" class="i_table">
	<tr><td class="head" colspan="2"><b>提示信息</b></td></tr>
	<tr>
		<td class="b">
<pre>

1、计划任务是一项使系统在规定时间自动执行某些特定任务的功能。

2、合理设置执行时间，能有效地为服务器减轻负担。
</pre>
		</td>
	</tr>
</table>
<br/>
<form method="post" action="?c=plan&a=index">
<input type="hidden" value="unsubmit" name="action"/>
<table cellspacing="1" cellpadding="3" align="center" width="98%" class="i_table">
	<tbody><tr class="head"><td colspan="11">计划任务管理</td></tr>
	<tr align="center" class="cbg">
		<td width="6%">序号</td>
		<td width="*">任务标题</td>
		<td width="6%">分钟</td>
		<td width="6%">小时</td>
		<td width="6%">星期</td>
		<td width="6%">日</td>
		<td width="17%">上次执行时间</td>
		<td width="17%">下次执行时间</td>
		<td width="6%">设置</td>
		<td width="5%">运行</td>
		<td width="5%">删除</td>
	</tr>
<!---->
<{foreach from=$plan_list item=current_plan }>
	<tr class="b" align="center">
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
		<td>

		<input type="checkbox" name="remove_id[]" value="<{$current_plan.id}>"  />		</td>
	</tr>
<{/foreach}>
</tr>
<!---->
</tbody></table>
<br/>
<center><input type="button" onclick="CheckAll(this.form)" value="全 选" name="chkall"/>
<input type="submit" onclick="return checkset('确定要删除所有所选项吗？');" value="删除所选项"/></center>
</form>
