<{if $action == 'edit'}>
<br />
<form action="?c=class&a=edit" method="post">
<table width=98% align=center cellspacing=1 cellpadding=3 class=i_table>
<tr><td class=head colspan=2>�޸ķ���:</td>
</tr>
<tr class=b>
  <td >�ϼ�����:
    <select name="classid" id="classid">
        <{$options_class}>
    </select></td>
</tr>
<tr class=b>
  <td >

        ��������:
          <label>
          <input name="classnewname" type="text" id="classnewname" value="<{ $info.classname }>" />
          </label>



 �Զ���·��:
 <label>
 <input name="path" type="text" id="path" value="<{$info.path}>" />(֧��http://��ͷ���ⲿ����)
 </label></td>
</tr>
<tr>
<td>
keywords : <textarea name='keywords'><{$info.keywords}></textarea>
</td>
</tr>
<tr>
<td>
desciption : <textarea name='description'><{$info.description}></textarea>
</td>
</tr>
</table>


    <div align="center">
      <input name="action" type="hidden" id="action" value="edit" />
      <input name="step" type="hidden" id="step" value="1" />
      <input name="id" type="hidden" id="id" value="<{$info.classid}>" />
      <input type="submit" name="Submit4" value="�ύ" /></div>
      </form>


      <br />
<{else}>
<form action="?c=class&a=add" method="post">
<table width=98% align=center cellspacing=1 cellpadding=3 class=i_table>
<tr><td class=head colspan=2>��ӷ���:</td>
</tr>
<tr class=b>
  <td >�ϼ�����:
    <select name="classid" id="classid">
        <{$options_class}>
    </select></td>
</tr>
<tr class=b>
  <td >��������:
          <label>
          <input name="classnewname" type="text" id="classnewname" />
          ��������:
          <input name="orderid" type="text" id="orderid"  onkeyup="value=value.replace(/[^\d]/g,'') "/>
�Զ���·��/�ļ���:
<input name="path" type="text" id="path" />(֧��http://��ͷ���ⲿ����)
      </label>
</td>
</tr>
<tr>
<td>
keywords : <textarea name='keywords'></textarea>
</td>
</tr>
<tr>
<td>
desciption : <textarea name='description'></textarea>
</td>
</tr>
<tr class=b  align="center">
  <td >
    <label>
    <input name="action" type="hidden" id="action" value="add" />
    <input type="submit" name="Submit4" value="�ύ" />
    </label>
    </td>
</tr>
</table></form>
<br />
<form action="?c=class&a=index&type=<{$type}>" method="post">
<table width=98% align=center cellspacing=1 cellpadding=3 class=i_table>
<tr>
  <td colspan=9 class=head>
   ���з����б� [<a href="?c=class&a=index&type=1">�鿴һ������</a>] [<a href="?c=class&a=index&type=2">�鿴��������</a>] [<a href="?c=class&a=index&type=all">�鿴���з���</a>]&nbsp;[<a href="?c=class&a=index&type=home">�鿴��ҳ��ʾ����</a>] �鿴����:
   <select name="classid" id="classid" onChange="window.location=('?c=class&a=index&type=all&classid='+this.value)">
        <{$options_class}>
    </select>
   �µķ���</td>
</tr>
	    <tr>
      <td width="15%" class='f_one'>��������</td>
      <td width="5%" class='f_one'>��ҳ����</td>
      <td width="10%" class='f_one'>����</td>
      <td width="10%" class='f_one'>·��/�ļ���</td>
      <td width="5%"  class='f_one'>վ������</td>
      <td width="10%" class='f_one'>����ѡ��</td>
      <td width="5%" class='f_one'>��ҳ��ʾ</td>
    </tr>
<{foreach from=$class_list item=class}>
        <tr class=b>
          <td ><{$class.class_text}></td>

          <td ><label>
            <input name="indexname[<{$class.classid}>]" type="text" id="indexname[<{$class.classid}>}]" value="<{$class.indexname}>" size="4" maxlength="2" />
          </label></td>
          <td ><label>
          <input name="order[]" type="text" id="order[]" value="<{$class.displayorder}>" size="4" />
           <input name="orderid[]" type="hidden" id="orderid[]" value="<{$class.classid}>" />
          </label></td>
          <td ><label>
            <input name="path[<{$class.classid}>]" type="text" id="path[<{$class.classid}>]" value="<{$class.path}>" />
          </label></td>
          <td ><{$class.sitenum}></td>
          <td >[<a href="?c=class&a=edit&id=<{$class.classid}>">�޸�</a>] [<a href="?c=class&a=del&id=<{$class.classid}>">ɾ��</a>] </td>
            <td ><label>
            <{$class.inindex}>
            <{$class.inindexcheck}>
            </label></td>
            </tr>
<{/foreach}>

</table>
<div align="center">
  <label>
  <input name="action" type="radio" value="paixu" checked="checked" />
  ��������
  <input type="radio" name="action" value="indexpaixu" />
  ��ҳ����
  <input type="radio" name="action" value="inindex" />
  </label>
  ��ҳ��ʾ
  <label></label>
  <label>
  <input type="radio" name="action" value="path" />
  </label>
  ·���޸�
  <label>
  <input type="radio" name="action" value="indexname" />
  </label>
  ��ҳ�����޸�<br />
<input type="submit" name="Submit" value="�ύ" /></div>

</form>
<br />
<{/if}>
