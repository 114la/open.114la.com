<{include file="header.tpl"}>
<div class="wrap">
    <div class="container">

        <div id="main">
            
            <div class="con">
            	<form action="?c=trade_site&a=search" method="get">
                    <input type="hidden" name="c" value="trade_site"/>
                    <input type="hidden" name="a" value="search"/>
                  <div class="table">
                    <div class="th">
                        վ������: <input type="text" value="<{$keyword}>" id="keyword" name="keyword"/>
                          <select name="search_type">
                            <option value="name">����</option>
                            <option value="url" <{if $search_type == 'url'}>selected<{/if}> >��ַ</option>
                          </select>
                          <input type="submit" value="����" />
                    </div>
                  </div>
                </form>

            	<form action="?c=trade_site&a=list_edit" method="post">
                    <input type="hidden" name="referer" value="<{$referer}>"/>
                  <div class="table">
                  	<div class="th">
                    	<div class="form fl">
                        <input type="button" value="�����ַ" onclick="self.location='?c=trade_site&a=edit&action=add&classid=<{$class_id}>'"/>&nbsp;
                        <label for="alltopic">������鿴</label>&nbsp;
                        <select id="alltopic">
                                <option value="0">ȫ��</option>
                            <{foreach from=$class_list item=class}>
                                <option value="<{$class.classid}>" <{if $class.classid == $class_id}>selected<{/if}> ><{$class.classname}></option>
                            <{/foreach}>
                        </select>&nbsp;
                        <span id="alltopic_span" style="display:none;"><{$class_id}></span>
                        <script>
                            document.getElementById("alltopic").value = document.getElementById("alltopic_span").innerHTML;
                            $(document).ready(function() {
                                $('#alltopic').change(function(){
                                    self.location='?c=trade_site&classid=' + $(this).val();
                                });
                            });
                        </script>                        
                        </div>
                        <div id="classSearch" class="fl" >
                        &nbsp;&nbsp;<a href="?c=trade_site&isend=1">�鿴����վ��</a>&nbsp;
                        </div>                        
             
                    </div>
                    <table class="admin-tb" id="js_data_source">
                    <tr>
                    	<th width="41" class="text-center">ɾ��</th>    
                        <th width="40">�Ƽ�</th>    
                        <th width="70">����</th>            	
                        <th width="120">��վ</th>
                        <th width="280">��ַ</th>
                        <th width="80">����</th>
                        <th width="80">��ʼʱ��</th>      
                        <th width="80">����ʱ��</th>   
                        <th>�����</th>                            
                    </tr>
                    <{foreach from=$list item=i}>
                    <tr>
                        <td class="text-center"><input rel="del" type="checkbox" name="delete[<{$i.id}>]"  /></td>
                        <td class="text-center">
                            <input rel="dis" type="checkbox" name="recommend[<{$i.id}>]" <{if $i.good eq 1}>checked="checked"<{/if}>/>
                            <input type="hidden" name="norecommend[<{$i.id}>]" value="<{if $i.good eq 1}>0<{else}>1<{/if}>"/>
                        </td>
                        <td><input type="text" name="order[<{$i.id}>]" class="textinput" tabindex="11" value="<{$i.displayorder}>" /></td>                 
                        <td><a href="?c=trade_site&a=edit&action=modify&id=<{$i.id}>"><{$i.name}></a></td>
                        <td><div style="width:280px" class="hideText" title="<{$i.url}>"><{$i.url}></div></td>
                        <td><a href="?c=trade_site&classid=<{$i.class_id}>"><{$i.class_name}></a></td>
                        <td><{if $i.starttime gt 0}><{$i.starttime|date_format:$date_format_ymd}><{/if}></td>              
                        <td><{if $i.endtime gt 0}><{$i.endtime|date_format:$date_format_ymd}><{/if}></td>
                        <td><{$i.adduser}></td>
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
										$(input).attr("checked","");
										$(input).attr("disabled","disabled");
									}
									else{
										$(input).attr("disabled","");
									}
								});								
							});
                            /*
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
                            */
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
                            <a href="<{$page_url}>&start=<{$pages.prev}>">&laquo; ��һҳ</a>
                            <{else}>
                            <span class="nextprev">&laquo; ��һҳ</span>
                            <{/if}>
                            <{foreach from=$pages key=k item=i}>
                                <{if $k ne 'prev' && $k ne 'next'}>
                                    <{if $k eq 'omitf' || $k eq 'omita'}>
                                    <span>��</span>
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
                            <a href="<{$page_url}>&start=<{$pages.next}>">��һҳ &raquo;</a>
                            <{else}>
                            <span class="nextprev">��һҳ &raquo;</span>
                            <{/if}>
                        </div>                
                        <{/if}>
                        
                    	<div class="form">
                        <input value="�ύ�޸�" type="submit"/>&nbsp;
                        </div>
                    </div>
                </div>
				</form>
            </div><!--/ con-->
        </div>    
    </div><!--/ container-->
    </div><!--/ wrap-->
<{include file="footer.tpl"}>
