<{include file=header.tpl}>
<{* 添加分类 *}>
<{if $action == 'add'}>
<div class="wrap">
    <div class="container">
        
        <div id="main">
  
            
            <div class="con box-green">
                <form action="?c=cool_class&a=add" method='post'>
                <div class="box-header">
                    <h4>添加酷站分类</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120">分类名称：</th>
                            <td><input type="text" name="classnewname" class="textinput w270" /></td>
                        </tr>
                        <tr>
                            <th>链接地址：</th>
                            <td><input type="text" name="path" class="textinput w270" /></td>
                        </tr>
                        <tr>
                            <th>分类排序：</th>
                            <td><input name="orderid" type="text" id="orderid" class="textinput" onkeyup="value=value.replace(/[^\d]/g,'') "/></td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="添加" />或 <a href="?c=class&a=index">取消</a>
                    </div>
                </div>
                </form>
            </div><!--/ con-->
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<{* 修改分类 *}>
<{elseif $action == 'edit'}>
<div class="wrap">
    <div class="container">
        
        <div id="main">
  
            
            <div class="con box-green">
                <form action="?c=cool_class&a=edit" method='post'>
                  <input name="id" type="hidden"  value="<{$info.classid}>" />
                <div class="box-header">
                    <h4>编辑酷站分类</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120">分类名称：</th>
                            <td><input type="text" name="classnewname" value="<{ $info.classname }>" class="textinput w270" /></td>
                        </tr>
                        <tr>
                            <th>链接地址：</th>
                            <td><input type="text" name="path" value="<{$info.path}>" class="textinput w270" /></td>
                        </tr>
                        <tr>
                            <th>分类排序：</th>
                            <td><input name="orderid" value="<{$info.displayorder}>" type="text" id="orderid" class="textinput" onkeyup="value=value.replace(/[^\d]/g,'') "/></td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="修改" />或 <a href="?c=class&a=index">取消</a>
                    </div>
                </div>
                </form>
            </div><!--/ con-->
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->

<{* 分类列表 *}>
<{else}>
<div class="wrap">
    <div class="container">

        <div id="main">
            
            <div class="con">
            	<form action='?c=cool_class&a=index' method='post'>
                  <div class="table">
                  	<div class="th">
                    	<div class="form">
                        <div class="fl">
                           <input type="button" onclick="window.location='?c=cool_class&a=add'" value="添加分类" />
                              &nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                        </div>
                    </div>
                    <table class="admin-tb">
                    <tr>
                    	<th width="41" class="text-center">选择</th>
                    	<th width="97">排序</th>
                        <th width="248">分类名称</th>
                        <th width="300">链接地址</th>
                    	<th width="100">站点数量</th>
                        <th width="161">操作</th>
                    </tr>

                    <{if $class_list}>
                    <{foreach from=$class_list item=class}>
                    <tr>
                    <td class="text-center"><input name="rmid[<{$class.classid}>]" type="checkbox" rel="del"  /></td>
                    <td><input name="order[<{$class.classid}>]" type="text" id="order[]" class="textinput" tabindex="11" value="<{$class.displayorder}>" size="4" />
                    <td><a href="?c=cool_site&classid=<{$class.classid}>"><{$class.classname}></a></td>
                    <td><input name="path[<{$class.classid}>]" type="text" class="textinput" style="width: 200px;" id="path[<{$class.classid}>]" value="<{$class.path}>" /></td>
                    <td><{$class.sitenum}></td>
                    <td>[<a href="?c=cool_class&a=edit&id=<{$class.classid}>">修改</a>] </td>
                    </tr>
                    <{/foreach}>
                    <{else}>
                    <tr>
                    	<td colspan='6'>暂无酷站分类</td>
                    </tr>
                    <{/if}>
                    
                    </table>
                    <div class="th">
                    	<div class="form">
                        <input type='hidden' name='commit' value='1' />
                        <input type='radio' name='action' value='del' />删除
                        <input type='radio' name='action' value='update' checked />其他更改
                        <input type="submit" value="保存" />&nbsp;
                        &nbsp;
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
