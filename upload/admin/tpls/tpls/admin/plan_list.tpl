<table width="98%" align="center" cellspacing="1" cellpadding="3" class="i_table">
	<tr><td class="head" colspan="2"><b>��ʾ��Ϣ</b></td></tr>
	<tr>
		<td class="b">
<pre>

1���ƻ�������һ��ʹϵͳ�ڹ涨ʱ���Զ�ִ��ĳЩ�ض�����Ĺ��ܡ�

2����������ִ��ʱ�䣬����Ч��Ϊ���������Ḻ����
</pre>
		</td>
	</tr>
</table>
<br/>
<form method="post" action="?c=plan&a=index">
<input type="hidden" value="unsubmit" name="action"/>
<table cellspacing="1" cellpadding="3" align="center" width="98%" class="i_table">
	<tbody><tr class="head"><td colspan="11">�ƻ��������</td></tr>
	<tr align="center" class="cbg">
		<td width="6%">���</td>
		<td width="*">�������</td>
		<td width="6%">����</td>
		<td width="6%">Сʱ</td>
		<td width="6%">����</td>
		<td width="6%">��</td>
		<td width="17%">�ϴ�ִ��ʱ��</td>
		<td width="17%">�´�ִ��ʱ��</td>
		<td width="6%">����</td>
		<td width="5%">����</td>
		<td width="5%">ɾ��</td>
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
		<td><input type="button" value="����" onclick="window.location=('?c=plan&a=edit&id='+<{$current_plan.id}>)" /></td>
		<td><input type="button" value="����" onclick="window.location=('?c=plan&a=execute&id='+<{$current_plan.id}>)" /></td>
		<td>

		<input type="checkbox" name="remove_id[]" value="<{$current_plan.id}>"  />		</td>
	</tr>
<{/foreach}>
</tr>
<!---->
</tbody></table>
<br/>
<center><input type="button" onclick="CheckAll(this.form)" value="ȫ ѡ" name="chkall"/>
<input type="submit" onclick="return checkset('ȷ��Ҫɾ��������ѡ����');" value="ɾ����ѡ��"/></center>
</form>
