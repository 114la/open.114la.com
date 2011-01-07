<{include file="header.tpl"}>
<div class="wrap">
    <div class="container">

        <div id="main">
            
            <div class="con">
            	<form action="?c=zhuanti_class&a=list_edit" method="post">
                    <input type="hidden" name="referer" value="<{$referer}>"/>
                  <div class="table">
                  	<div class="th">
                    	<div class="form">
                        <input type="button" value="添加专题" onclick="window.location='?c=zhuanti_class&a=edit&action=add'" />&nbsp;
                        <label for="alltopic">按分类查看</label>&nbsp;
                        <script type="text/javascript">
							var onChangeHandler = function(ele){
								window.location='?c=zhuanti_class&type=' + ele.value;
							}
						</script>
                        <select id="alltopic" onchange="onChangeHandler(this);">
                            <option selected="selected" onclick="window.location='?c=zhuanti_class'">所有专题</option>
                            <{foreach from=$class_list key = k item = i}>
                            <option<{if $k eq $key}> selected="selected"<{/if}> value='<{$k}>'><{$i}></option>
                            <{/foreach}>
                        </select>
                        &nbsp;&nbsp;<a href="?c=zhuanti_class">查看全部</a>&nbsp;
                        </div>
                    </div>
                   
                    <table class="admin-tb" id="js_data_source">
                    <tr>
                    	<th width="41" class="text-center">删除</th>    
                        <th width="80">首页显示</th>    
                        <th width="70">排序</th>            	
                        <th width="180">分类</th>
                        <th width="80">所属专题</th>                        
                        <th>操作</th>
                        
                    </tr>
                    <{foreach from=$list item=i}>
                    <tr>
                        <td class="text-center"><input rel="del" type="checkbox" name="delete[<{$i.id}>]"  /></td>
                        <td class="text-center">
                            <input rel="dis" type="checkbox" name="inindex[<{$i.id}>]" <{if $i.inindex eq 1}>checked="checked"<{/if}>/>
                            <input type="hidden" name="noindex[<{$i.id}>]" value="<{if $i.inindex eq 1}>0<{else}>1<{/if}>"/>
                        </td>
                        <td><input type="text" name="order[<{$i.id}>]" value="<{$i.displayorder}>" class="textinput" tabindex="11" /></td>                 
                        <td><a title="查看该分类下的网站" href="?c=zhuanti&classid=<{$i.id}>"><{$i.name}></a></td>
                        <td><{$i.type_zh}></td>                        
                        <td><a href="?c=zhuanti_class&a=edit&action=modify&id=<{$i.id}>">修改</a></td>
                    </tr>
                    <{/foreach}>                    
                    </table>
                    <script type="text/javascript">
                        $(document).ready(function(){
							$(".admin-tb").find("input[rel='del']").each(function(i){
								$(this).bind("click",function(){
									
									
								})
							});	
							
							
                            $("#js_data_source").find("input[rel='del']").each(function(i){
                                $(this).bind("click",function(){
                                    var tr = $(this).parent().parent();
                                    var input = tr.find("input[rel='dis']");
                                    if(this.checked){
										$(input).attr("oledchecked",$(input).attr("checked"));
										$(input).attr("checked","");
										$(input).attr("disabled","disabled");
									}
									else{
										$(input).attr("disabled","");
										$(input).attr("checked",$(input).attr("oledchecked"));
									}
									
									$(".admin-tb").find("input[rel='del']").each(function(i){
										var tr2 = $(this).parent().parent();
										if(this.checked){
											tr2.addClass("checked");
										}
										else{
											tr2.removeClass("checked");
										}
									})
                                });                             
                            });
                            $("#js_data_source").find("input[rel='dis']").change(function(){
                                if ($(this).next('input[type="hidden"]').val() == 1) $(this).next('input[type="hidden"]').val(0);
                                else $(this).next('input[type="hidden"]').val(1);
							});
                        });
                    </script>
                    <div class="th">
                    	<div class="form">
                        <input type="submit" value="提交修改" />&nbsp;
                        </div>
                    </div>
                </div>
				</form>
            </div><!--/ con-->
        </div>    
    </div><!--/ container-->
    </div><!--/ wrap-->
<{include file="footer.tpl"}>
