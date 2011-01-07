<{include file=header.tpl}>
<{* 添加分类 *}>
<{if $action == 'add'}>
<div class="wrap">
    <div class="container">
        
        <div id="main">
  
            
            <div class="con box-green">
                <form action="?c=trade_class&a=add" method='post'>
                <div class="box-header">
                    <h4>添加行业分类</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120">分类名称：</th>
                            <td><input type="text" name="classnewname" class="textinput w270" /></td>
                        </tr>
                        <tr>
                            <th>外链地址：</th>
                            <td><input type="text" name="path" class="textinput w270" /></td>
                        </tr>
                        <tr>
                            <th>分类排序：</th>
                            <td><input name="orderid" type="text" id="orderid" class="textinput" onkeyup="value=value.replace(/[^\d]/g,'') "/></td>
                        </tr>
                        <tr>
                            <th>keywords：</th>
                            <td><input type="text" name='keywords' class="textinput w360" /></td>
                        </tr>
                        <tr>
                            <th  style="vertical-align:top;">description：</th>
                            <td><textarea name='description' class="w360"></textarea></td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="添加" /> 或 <a href="?c=trade_class&a=index">取消</a>
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
                <form action="?c=trade_class&a=edit" method='post'>
                  <input name="id" type="hidden"  value="<{$info.classid}>" />
                  <input name="type" type="hidden"  value="<{$type}>" />
                  <input name="returnid" type="hidden"  value="<{$returnid}>" />
                <div class="box-header">
                    <h4>编辑行业分类</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120">分类名称：</th>
                            <td><input type="text" name="classnewname" value="<{ $info.classname }>" class="textinput w270" /></td>
                        </tr>
                        <tr>
                            <th>外链地址：</th>
                            <td><input type="text" name="path" value="<{$info.path}>" class="textinput w270" /></td>
                        </tr>
                        <tr>
                            <th>keywords：</th>
                            <td><input type="text" name='keywords' value='<{$info.keywords}>' class="textinput w360" /></td>
                        </tr>
                        <tr>
                            <th  style="vertical-align:top;">description：</th>
                            <td><textarea name='description' class="w360"><{$info.description}></textarea></td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="修改" /> <input name="mkhtml" type="submit" value="修改并生成分类" />或 <a href="?c=trade_class&a=index">取消</a>
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
            	<form action='?c=trade_class&a=index&type=<{$type}>&classid=<{$classid}>' method='post'>
                  <div class="table">
                  	<div class="th">
                    	<div class="form">
                        <div class="fl">
                           <input type="button" onclick="window.location='?c=trade_class&a=add'" value="添加行业分类" />
                              &nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                        </div>
                    </div>
                    <table class="admin-tb">
                    <tr>
                    	<th width="41" class="text-center">选择</th>
                    	<th width="97">排序</th>
                        <th width="248">分类名称</th>
                        <th width="300">外链地址</th>
                    	<th width="100">站点数量</th>
                        <th width="161">操作</th>
                    </tr>

                    <{foreach from=$class_list item=class}>
                    <tr>
                    <td class="text-center"><input name="rmid[<{$class.classid}>]" type="checkbox" rel="del"  /></td>
                    <td><input name="order[]" type="text" id="order[]" class="textinput" tabindex="11" value="<{$class.displayorder}>" size="4" />
                   <input name="orderid[]" type="hidden" id="orderid[]" value="<{$class.classid}>" /></td>
                    <td><a href='?c=trade_site&classid=<{$class.classid}>'><{$class.classname}></a></td>
                    <td><input name="path[<{$class.classid}>]" type="text" class="textinput" style="width: 200px;" id="path[<{$class.classid}>]" value="<{$class.path}>" /></td>
                    <td><{$class.sitenum}></td>
                    <td>[<a href="?c=trade_class&a=edit&id=<{$class.classid}>&type=<{$type}>&classid=<{$classid}>&path=<{$class.class_path}>">修改</a>] </td>
                    </tr>
                    <{/foreach}>
                    
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

