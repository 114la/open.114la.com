<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        <div id="main">
            <div class="con">
                <form action='?c=site_manage&a=multi_add' method='post'>
                  <div class="table">
                  	<div class="th">
                    	<div class="form">
                        </div>
                    </div>
                  <style type="text/css">
                  	table.admin-tb tr:hover { background-color:#FFFFCC;}
                  </style>
                    <table id="site_multi_add" class="admin-tb">
                    	<tr>
                        <th width="45" align="center">行 号</th>
                        <th>网站名称</th>
                        <th>网 址</th>
                        <th>备 注</th>
                        </tr>
                        <tr><td>1</td>
                            <td><input name='sites[1][name]' type="text" class="textinput" style="width:90%" /></td>
                            <td><input name='sites[1][url]' type="text" class="textinput" style="width:90%" /></td>
                            <td><input name='sites[1][remark]' type="text" class="textinput" style="width:90%" /></td>
                        </tr>
                        <tr>
                        	<td>2</td>
                            <td><input name='sites[2][name]' type="text" class="textinput" style="width:90%" /></td>
                            <td><input name='sites[2][url]' type="text" class="textinput" style="width:90%" /></td>
                            <td><input name='sites[2][remark]' type="text" class="textinput" style="width:90%" /></td>
                        </tr>
                        <tr><td>3</td>
                            <td><input name='sites[3][name]' type="text" class="textinput" style="width:90%" /></td>
                            <td><input name='sites[3][url]' type="text" class="textinput" style="width:90%" /></td>
                            <td><input name='sites[3][remark]' type="text" class="textinput" style="width:90%" /></td>
                        </tr>
                        <tr><td>4</td>
                            <td><input name='sites[4][name]' type="text" class="textinput" style="width:90%" /></td>
                            <td><input name='sites[4][url]' type="text" class="textinput" style="width:90%" /></td>
                            <td><input name='sites[4][remark]' type="text" class="textinput" style="width:90%" /></td>
                        </tr>
                                        
                    </table>
                    <div class="add" style="background:#F2F4F6; border:1px dashed #E3E6EB; padding:5px; margin:3px 0;" >
                    	<a href="javascript:void(0)" id="addrow"><img src="static/images/add.gif" alt="添加一行" /></a>
                        <script type="text/javascript">
                        	$("#addrow").bind("click",function(){
							
							var i = $("#site_multi_add").find("tr").length;
							var html = "<tr><td>"+i+"</td>"
							+'<td><input name="sites['+i+'][name]" type="text" class="textinput" style="width:90%" /></td>'
							+'<td><input name="sites['+i+'][url]" type="text" class="textinput" style="width:90%" /></td>'
							+'<td><input name="sites['+i+'][remark]" type="text" class="textinput" style="width:90%" /></td>'
							+'</tr>';
						$("#site_multi_add").append(html);
							
							})
                        </script>
                   </div>
                    
                    <div class="clearfix">
                    		<div id="classSearch" class="fl ml5" style="_margin-top:-6px;">
                                输入类别关键字查找：<input type="text" id="tool_kw" autocomplete="off" onclick="(this.value == '快速搜索分类') ? this.value='' :''" onblur="(this.value == '') ? this.value='快速搜索分类' :''" onmouseover="this.select()" value="快速搜索分类" class="textinput gray9 w270 mt5" />
                            </div>
                            <div style="clear:both"></div>
                    		<div id="cate" style="height:30px; line-height:30px;">您选择的分类：<span id="js_link_text_span"></span></div>
                        	<input id="js_submit_classid" type="hidden" name="classid"  />
                            <div id="cate_list">
                                <table>
                                    <tr id="js_cate_list">
                                        <td index="0">
                                            <ol>
                                            <{foreach from=$class_list item=class}>
                                                <li classid="<{$class.classid}>"><{$class.classname}></li>
                                            <{/foreach}>
                                            </ol>
                                        </td>
                                    </tr>
                                </table>
                            </div> 
                            <script type="text/javascript" src="static/js/cate_list_manager.js"></script>
                            <script type="text/javascript">
                                CateListManager.Init();
                                <{if $class_id_list <> ''}>
                                CateListManager.SelectClass('<{$class_id_list}>');	//------------------加选中列表
                                <{/if}>
                            </script>
                            
                    </div>
                    <div class="th">
                    	<div class="form">
                        <div class="fl">
                           <input type="submit" value="确定" />
                        </div>
                        </div>
                    </div>
                </div>
				</form>
            </div><!--/ con-->
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<div id="js_search_msg" class="js_search_msg" style="display:none;"></div>
<style type="text/css">
	.js_search_msg{ position:absolute; background:#fff; border:1px solid #CEDEAE;}
	.js_search_msg li{ padding:3px 5px; cursor:pointer;}
	.js_search_msg li.active{ background:#EBF4D8}
</style>
<script type="text/javascript" src="static/js/textboxdrop.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".admin-tb").find("input[rel='del']").each(function(i){
			$(this).bind("click",function(){
				$(".admin-tb").find("input[rel='del']").each(function(i){
					var tr = $(this).parent().parent();
					if(this.checked){
						tr.addClass("checked");
					}
					else{
						tr.removeClass("checked");
					}
				})
				
			})
		});					   
		
		var t = new TextBoxDrop("tool_kw","js_search_msg");
		t.SetEnterHandler (function(ele){
			CateListManager.SelectClass($(ele).attr("rel"));
		});
		t.DefaultKey = "id_list";
		t.SetAjaxMethod($.get);
		t.Url('?c=class&a=search&k=');
		t.SetContentStyle(function(intput,contentbox){
			var inputBox = $(intput);
			if($.browser.ie){
				contentbox.style.left = inputBox.offset().left;
				contentbox.style.top = inputBox.offset().top + 23;
			}
			else{
				$(contentbox).css({
					top : inputBox.offset().top + 23,
					left: inputBox.offset().left
				});
			}
		});
		t.DisplayContentHandler(function(input,contentbox){						   
			if($(contentbox).width() < $(input).outerWidth()){
				$(contentbox).width($(input).outerWidth());
			}
		});
	});
</script>
<{include file="footer.tpl"}>
