<{include file=header.tpl}>
<{* 添加分类 *}>
<{if $action == 'add'}>
<div class="wrap">
    <div class="container">
        <div id="main">
            <div class="con box-green">
                <form action="?c=class&a=add" method='post'>
                <div class="box-header">
                    <h4>添加分类</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120">分类名称：</th>
                            <td><input type="text" name="classnewname" class="textinput w270" /></td>
                        </tr>
                        <tr>
                            <th>自定义路径/文件名：</th>
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
                        <tr>
                            <th  style="vertical-align:top;">所属的分类是：</th>
                            <td>
                            <div id="classSearch" class="fl ml5" style="_margin-top:-6px;">
                                <input type="text" id="tool_kw" autocomplete="off" onclick="(this.value == '快速搜索分类') ? this.value='' :''" onblur="(this.value == '') ? this.value='快速搜索分类' :''" onmouseover="this.select()" value="快速搜索分类" class="textinput gray9 w270 mt5" />
                            </div>
                            <div style="clear:both"></div>
                        	<input id="js_submit_classid" type="hidden" name="classid"  />
                        	<div id="cate" style="height:30px; line-height:30px;">您选择的分类：<span id="js_link_text_span"></span></div>
                            <div style="color:red">提示：若不选择分类，则添加在第一级分类。</div>
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
                            </script>
                            
                            </td>
                        </tr>
                    </table>
                </div>
                
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="添加" /> 或 <a href="?c=class&a=index">取消</a>
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
                <form action="?c=class&a=edit" method='post'>
                  <input name="id" type="hidden"  value="<{$info.classid}>" />
                  <input name="type" type="hidden"  value="<{$type}>" />
                  <input name="returnid" type="hidden"  value="<{$returnid}>" />
                <div class="box-header">
                    <h4>编辑分类</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120">分类名称：</th>
                            <td><input type="text" name="classnewname" value="<{ $info.classname }>" class="textinput w270" /></td>
                        </tr>
                        <tr>
                            <th>自定义路径/文件名：</th>
                            <td><input type="text" name="path" value="<{$info.path}>" class="textinput w270" /></td>
                        </tr>
                        <tr>
                            <th>自定义模板：</th>
                            <td><input type="text" name="template" value="<{$info.template}>" class="textinput w270" /> 不填则为默认</td>
                        </tr>
                        <tr>
                            <th>keywords：</th>
                            <td><input type="text" name='keywords' value='<{$info.keywords}>' class="textinput w360" /></td>
                        </tr>
                        <tr>
                            <th  style="vertical-align:top;">description：</th>
                            <td><textarea name='description' class="w360"><{$info.description}></textarea></td>
                        </tr>
                        <tr>
                            <th  style="vertical-align:top;">所属分类：</th>
                            <td>
                        	<input id="js_submit_classid" type="hidden" name="classid"  />
                        	
                            <div id="classSearch" class="fl ml5" style="_margin-top:-6px;">
                                <input type="text" id="tool_kw" autocomplete="off" onclick="(this.value == '快速搜索分类') ? this.value='' :''" onblur="(this.value == '') ? this.value='快速搜索分类' :''" onmouseover="this.select()" value="快速搜索分类" class="textinput gray9 w270 mt5" />
                            </div>

							<div style="clear:both; overflow:hidden; height:0"></div>

                                <div id="cate" style="height:30px; line-height:30px;" class="clearfix">您选择的分类：<span id="js_link_text_span"></span></div>
                                <div><input type="button" value="移到主目录" onclick="CateListManager.SelectClass('');" /> 
                                <span style="color:red">&lt;&lt; 点击此按钮移到主目录，若选择分类则移到分类的下一级。</span></div>
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
								CateListManager.SelectClass('<{$info.id_list}>');	//------------------加选中列表
                            </script>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="修改" /> 或 <a href="?c=class&a=index">取消</a>
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
            	
                  <div class="table">
                  	<div class="th">
                    	<div class="form">
                        <div class="fl">
                           <input type="button" onclick="window.location='?c=class&a=add'" value="添加分类" />
                              &nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                        <div id="classSearch" class="fl ml5" style="_margin-top:-6px;">
                            <input type="text" id="tool_kw" autocomplete="off" onclick="(this.value == '快速搜索分类') ? this.value='' :''" onblur="(this.value == '') ? this.value='快速搜索分类' :''" onmouseover="this.select()" value="快速搜索分类" class="textinput gray9 w270 mt5" />
                        </div>
                        </div>
                    </div>
                    <form action='?c=class&a=index&type=<{$type}>&classid=<{$classid}>' method='post'>
                    <table class="admin-tb" id="datatable">
                    <thead>
                        <tr>
                            <th width="41" class="text-center">选择</th>
                            <th width="200">排序</th>
                            <th >分类名称</th>
                            <th width="200">生成目录名称 / 外链地址</th>
                            <th  width="80">站点数量</th>
                            <th width="161">操作</th>
                        </tr>
					</thead>
                    <{foreach from=$class_list item=class}>
                    <tr sitenum='<{$class.sitenum}>' sub_sitenum="<{$class.sub_sitenum}>" classnum='<{$class.sub_classnum}>'  classid="<{$class.classid}>" childindex="1">
                    <td class="text-center"><input name="rmid[<{$class.classid}>]" type="checkbox" rel="del"  /></td>
                    <td><input name="order[]" type="text" id="order[]" class="textinput" tabindex="11" value="<{$class.displayorder}>" size="4" />
                   <input name="orderid[]" type="hidden" id="orderid[]" value="<{$class.classid}>" /></td>
                    <td rel="classname"><a href="javascript://"><{$class.classname}></a></td>
                    <td><input name="path[<{$class.classid}>]" type="text" class="textinput" style="width: 200px;" id="path[<{$class.classid}>]" value="<{$class.path}>" /></td>
                    <td><{if $class.sitenum}>$class.sitenum<{else}><{$class.sub_sitenum}><{/if}></td>
                    <td>
                        [<a href="?c=class&a=edit&id=<{$class.classid}>&type=<{$type}>&classid=<{$classid}>&path=<{$class.class_path}>">修改</a>] &nbsp;
                        [<a href="?c=class&a=edit&id=<{$class.classid}>&type=<{$type}>&classid=<{$classid}>&path=<{$class.class_path}>&mkhtml=1">生成 HTML</a>]
                    </td>
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
                    </form>
                </div>
            </div><!--/ con-->            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<script type="text/javascript" src="static/js/catgorymanager.js"></script>
<script type="text/javascript">
    CatgoryManager.AjaxUrl = "?c=class&a=ajax_get_list&id=";
	CatgoryManager.SetDisplayFun(function(data,parentNode,childIndex){
		var pexyText = "├-";
		for(var i = 0; i < childIndex; i++){
			pexyText = "&nbsp;&nbsp;&nbsp;&nbsp;" + pexyText;
		}
		childIndex = Number(childIndex) + 1;
		var html = "";
		for(var key in data){
			var item = data[key];
			html += '<tr sitenum="'+item["sitenum"]+'" classnum="'+item["sub_classnum"]+'" sub_sitenum="'+item["sub_sitenum"]+'" classid="'+item["classid"]+'" childindex="'+childIndex+'" parent="'+parentNode.attr("classid")+'">';
			html += '<td class="text-center"><input name="rmid['+item["classid"]+']" type="checkbox" rel="del"  /></td>';
			html += '<td>'+pexyText+'<input name="order[]" type="text" id="order[]" class="textinput" tabindex="11" value="'+item["displayorder"]+'" size="4" />';
			html += '<input name="orderid[]" type="hidden" id="orderid[]" value="'+item["classid"]+'" /></td>';
			if(Number(item["sitenum"]) > 0){
				var classNameText = item["classname"];
				if(Number(item["sub_classnum"]) > 0){
					classNameText = '<a href="javascript://">' + classNameText + '</a>';
				}
				html += '<td rel="classname">' + pexyText + classNameText + ' <a rel="sites" href="?c=site_manage&classid='+item["classid"]+'" style="color:red;">[列表]</a></td>';
			}
			else{
				html += '<td rel="classname">' + pexyText + '<a href="javascript://">' + item["classname"]+'</a></td>';
			}
			
			html += '<td><input name="path['+item["classid"]+']" type="text" class="textinput" style="width: 200px;" id="path['+item["classid"]+']" value="'+item["path"]+'" /></td>';
			html += '<td>'+ (item["sitenum"] == 0? (item["sub_sitenum"] || 0 ) : item["sitenum"])+'</td>';
			html += '<td>[<a href="?c=class&a=edit&id='+item["classid"]+'&classid=<{$classid}>&path='+item["path"]+'">修改</a>] &nbsp; [<a href="?c=class&a=edit&id='+item["classid"]+'&classid=<{$classid}>&path='+item["path"]+'&mkhtml=1">生成 HTML</a>] </td>';
			html += '</tr>';
		}
		//alert(html);
		var col = $(html);
		col.find("td[rel='classname'] a").not("[rel='sites']").each(function(i){
			CatgoryManager._bindEvent($(this));
		});
		parentNode.after(col);
		return col;
	});
	CatgoryManager.Init($("#datatable"));
</script>
<{/if}>
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
			<{if $action == 'add'}>
				CateListManager.SelectClass($(ele).attr("rel"));
			<{elseif $action == 'edit'}>
				CateListManager.SelectClass($(ele).attr("rel"));
			<{else}>
				CatgoryManager.SelectClass($(ele).attr("rel"));
			<{/if}>
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
<{include file=footer.tpl}>
