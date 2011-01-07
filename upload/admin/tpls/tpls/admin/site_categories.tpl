<{if $action == 'edit'}>
<br />
<form action="?c=class&a=edit" method="post">
<table width=98% align=center cellspacing=1 cellpadding=3 class=i_table>
<tr><td class=head colspan=2>修改分类:</td>
</tr>
<tr class=b>
  <td >上级分类:
    <select name="classid" id="classid">
        <{$options_class}>
    </select></td>
</tr>
<tr class=b>
  <td >

        分类名称:
          <label>
          <input name="classnewname" type="text" id="classnewname" value="<{ $info.classname }>" />
          </label>



 自定义路径:
 <label>
 <input name="path" type="text" id="path" value="<{$info.path}>" />(支持http://开头的外部链接)
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
      <input type="submit" name="Submit4" value="提交" /></div>
      </form>


      <br />
<{else}>
<form action="?c=class&a=add" method="post">
<table width=98% align=center cellspacing=1 cellpadding=3 class=i_table>
<tr><td class=head colspan=2>添加分类:</td>
</tr>
<tr class=b>
  <td >上级分类:
    <select name="classid" id="classid">
        <{$options_class}>
    </select></td>
</tr>
<tr class=b>
  <td >分类名称:
          <label>
          <input name="classnewname" type="text" id="classnewname" />
          分类排序:
          <input name="orderid" type="text" id="orderid"  onkeyup="value=value.replace(/[^\d]/g,'') "/>
自定义路径/文件名:
<input name="path" type="text" id="path" />(支持http://开头的外部链接)
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
    <input type="submit" name="Submit4" value="提交" />
    </label>
    </td>
</tr>
</table></form>
<br />
<form action="?c=class&a=index&type=<{$type}>" method="post">
<table width=98% align=center cellspacing=1 cellpadding=3 class=i_table>
<tr>
  <td colspan=9 class=head>
   现有分类列表 [<a href="?c=class&a=index&type=1">查看一级分类</a>] [<a href="?c=class&a=index&type=2">查看二级分类</a>] [<a href="?c=class&a=index&type=all">查看所有分类</a>]&nbsp;[<a href="?c=class&a=index&type=home">查看首页显示分类</a>] 查看分类:
   <select name="classid" id="classid" onChange="window.location=('?c=class&a=index&type=all&classid='+this.value)">
        <{$options_class}>
    </select>
   下的分类</td>
</tr>
	    <tr>
      <td width="15%" class='f_one'>分类名称</td>
      <td width="5%" class='f_one'>首页名称</td>
      <td width="10%" class='f_one'>排序</td>
      <td width="10%" class='f_one'>路径/文件名</td>
      <td width="5%"  class='f_one'>站点数量</td>
      <td width="10%" class='f_one'>管理选项</td>
      <td width="5%" class='f_one'>首页显示</td>
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
          <td >[<a href="?c=class&a=edit&id=<{$class.classid}>">修改</a>] [<a href="?c=class&a=del&id=<{$class.classid}>">删除</a>] </td>
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
  整体排序
  <input type="radio" name="action" value="indexpaixu" />
  首页排序
  <input type="radio" name="action" value="inindex" />
  </label>
  首页显示
  <label></label>
  <label>
  <input type="radio" name="action" value="path" />
  </label>
  路径修改
  <label>
  <input type="radio" name="action" value="indexname" />
  </label>
  首页名称修改<br />
<input type="submit" name="Submit" value="提交" /></div>

</form>
<br />
<{/if}>
