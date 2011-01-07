<{include file="header.tpl"}>
<div class="wrap">
    <div class="container">

        <div id="main">
            
            <div class="con">
            	<form action="?c=zhuanti&a=search" method="get">
                    <input type="hidden" name="c" value="zhuanti"/>
                    <input type="hidden" name="a" value="search"/>
                  <div class="table">
                    <div class="th">
                        站点搜索: <input type="text" value="<{$keyword}>" id="keyword" name="keyword"/>
                          <select name="search_type">
                            <option value="name">名称</option>
                            <option value="url" <{if $search_type == 'url'}>selected<{/if}>>网址</option>
                          </select>
                          <input type="submit" value="搜索" />
                    </div>
                  </div>
                </form>
            	<form action="?c=zhuanti&a=list_edit" method="post">
                    <input type="hidden" name="referer" value="<{$referer}>"/>
                  <div class="table">
                  	<div class="th">
                    	<div class="form">
                        <input type="button" value="添加网址" onclick="self.location='?c=zhuanti&a=edit&action=add'"/>&nbsp;
                        <{if $class_list}>
                        <label for="alltopic">按分类查看</label>&nbsp;
                        <script type="text/javascript">
							var onChangeHandler = function(ele){
								window.location='?c=zhuanti&classid=' + ele.value;
							}
						</script>
                        <select id="alltopic" onchange="onChangeHandler(this);">                            
                        	<option onclick="self.location='?c=zhuanti'";>所有专题</option>
                            <{foreach from=$class_list key = k item = parent}>
                                <optgroup label="<{$k}>">
                                    <{foreach from=$parent item = i}>
                                    <option<{if $i.id eq $class_id}> selected="selected"<{/if}> value='<{$i.id}>'><{$i.name}></option>
                                    <{/foreach}>
                                </optgroup>
                            <{/foreach}>
                        </select>&nbsp;
                        <{/if}>
                        &nbsp;&nbsp;<a href="?c=zhuanti">查看全部</a>&nbsp;
                       <!-- &nbsp;&nbsp;<a href="?c=zhuanti&inindex=1">查看在首页显示的站点</a>&nbsp;-->
                        &nbsp;&nbsp;<a href="?c=zhuanti&isend=1">查看过期站点</a>&nbsp;
                        </div>
                    </div>
                    <table class="admin-tb" id="js_data_source">
                    <tr>
                    	<th width="41" class="text-center">删除</th>    
                       <{* <th width="80">首页显示</th>*}>    
                        <th width="70">排序</th>            	
                        <th width="150">网站</th>
                        <th width="220">网址</th>
                        <th width="150">所属专题 &raquo; 分类</th>
                        <th width="80">开始时间</th>      
                        <th>结束时间</th>                              
                    </tr>
                    <{foreach from=$list item=i}>
                    <tr>
                        <td class="text-center"><input rel="del" type="checkbox" name="delete[<{$i.id}>]"  /></td>
                      <{*   <td class="text-center">
                            <input rel="dis" type="checkbox" name="inindex[<{$i.id}>]" <{if $i.inindex eq 1}>checked="checked"<{/if}>/>
                            <input type="hidden" name="noindex[<{$i.id}>]" value="<{if $i.inindex eq 1}>0<{else}>1<{/if}>"/>
                        </td>*}>    
                        <td><input type="text" name="order[<{$i.id}>]" class="textinput" tabindex="11" value="<{$i.displayorder}>" /></td>                 
                        <td><a href="?c=zhuanti&a=edit&action=modify&id=<{$i.id}>" style="color:<{$i.namecolor}>;"><{$i.name}></a></td>
                        <td><div style="width:220px;" class="hideText" title="<{$i.url}>"><{$i.url}></div></td>
                        <td><a title="查看该专题所有分类" href="?c=zhuanti_class&type=<{$i.type}>"><{$i.zhuanti_name}></a> &raquo; <a title="查看该分类所有网址" href="?c=zhuanti&classid=<{$i.class_id}>"><{$i.class_name}></a></td>
                        <td><{if $i.starttime gt 0}><{$i.starttime|date_format:$date_format_ymd}><{/if}></td>              
                        <td><{if $i.endtime gt 0}><{$i.endtime|date_format:$date_format_ymd}><{/if}></td>      
                    </tr>
                    <{/foreach}>
                    </table>
                    <script type="text/javascript">
                    	$(document).ready(function(){
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
                        <{if $pages}>
                        <div class="pages">
                            <{if $pages.prev gt -1}>                            
                            <a href="<{$page_url}>&start=<{$pages.prev}>">&laquo; 上一页</a>
                            <{else}>
                            <span class="nextprev">&laquo; 上一页</span>
                            <{/if}>
                            <{foreach from=$pages key=k item=i}>
                                <{if $k ne 'prev' && $k ne 'next'}>
                                    <{if $k eq 'omitf' || $k eq 'omita'}>
                                    <span>…</span>
                                    <{else}>
                                        <{if $i gt -1}>
                                        <a href="<{$page_url}>&start=<{$i}>"><{$k}></a>
                                        <{else}>
                                        <span class="current"><{$k}></span>                                        
                                        <{/if}>
                                    <{/if}>   
                                <{/if}>                             
                            <{/foreach}>
                            <{if $pages.next gt -1}>                            
                            <a href="<{$page_url}>&start=<{$pages.next}>">下一页 &raquo;</a>
                            <{else}>
                            <span class="nextprev">下一页 &raquo;</span>
                            <{/if}>
                        </div>                
                        <{/if}>
                        
                    	<div class="form">
                        <input value="提交修改" type="submit"/>&nbsp;
                        </div>
                    </div>
                </div>
				</form>
            </div><!--/ con-->
        </div>    
    </div><!--/ container-->
    </div><!--/ wrap-->
<{include file="footer.tpl"}>
