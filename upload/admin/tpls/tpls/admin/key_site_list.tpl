<{include file="header.tpl"}>
<div class="wrap">
    <div class="container">

        <div id="main">
            
            <div class="con">
            	<form action="?c=key&a=list_edit" method="post">
                    <input type="hidden" name="referer" value="<{$referer}>"/>
                  <div class="table">
                  	<div class="th">
                    	<div class="form">
                        <input type="button" value="��ӹؼ���" onclick="self.location='?c=key&a=edit&action=add'"/>&nbsp;
                        <label for="alltopic">������鿴</label>&nbsp;
                        <script>
                        	var onChangeHandler = function(ele)
							{
								
								location='?c=key&classid=' + ele.value
							}
                        </script>
                        <select id="alltopic" onchange="onChangeHandler(this);">
                            <{foreach from=$class_list key = k item = parent}>
                                <optgroup label="<{$k}>">
                                    <{foreach from=$parent item = i}>
                                    <option<{if $i.id eq $class_id}> selected="selected"<{/if}> value='<{$i.id}>' ><{$i.name}></option>
                                    <{/foreach}>
                                </optgroup>
                            <{/foreach}>
                        </select>&nbsp;
                        &nbsp;&nbsp;<a href="?c=key">�鿴ȫ��</a>&nbsp;
                        &nbsp;&nbsp;<a href="?c=key&inindex=1">�鿴����ҳ��ʾ��վ��</a>&nbsp;
                        &nbsp;&nbsp;<a href="?c=key&isend=1">�鿴����վ��</a>&nbsp;
                        </div>
                    </div>
                    <table class="admin-tb" id="js_data_source">
                    <tr>
                    	<th width="41" class="text-center">ɾ��</th>    
                        <{* <th width="80">��ҳ��ʾ</th>  *}>  
                        <th width="70">����</th>
                        <th>��վ</th>
                        <th width="150">����</th>
                        <th width="80">��ʼʱ��</th>      
                        <th width="80">����ʱ��</th>                              
                        <th width="60">����</th>
                    </tr>
                    <{foreach from=$list item=i}>
                    <tr>
                        <td class="text-center"><input rel="del" type="checkbox" name="delete[<{$i.id}>]"  /></td>
                        <{*
                        <td class="text-center">
                            <input rel="dis" type="checkbox" name="inindex[<{$i.id}>]" <{if $i.inindex eq 1}>checked="checked"<{/if}>/>
                            <input type="hidden" name="noindex[<{$i.id}>]" value="<{if $i.inindex eq 1}>0<{else}>1<{/if}>"/>
                        </td>
                        *}>
                        <td><input type="text" name="order[<{$i.id}>]" class="textinput" tabindex="11" value="<{$i.displayorder}>" /></td>                 
                        <td><a  href="?c=key&a=edit&action=modify&id=<{$i.id}>" ><{$i.name}></a></td>
                        <td> <{$i.class_name}></td>
                        <td><{if $i.starttime gt 0}><{$i.starttime|date_format:$date_format_ymd}><{/if}></td>              
                        <td><{if $i.endtime gt 0}><{$i.endtime|date_format:$date_format_ymd}><{/if}></td>      
                        <td><a href="?c=key&a=edit&action=modify&id=<{$i.id}>">�޸�</a></td>
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
                            <{*
							$("#js_data_source").find("input[rel='dis']").change(function(){
                                if ($(this).next('input[type="hidden"]').val() == 1) $(this).next('input[type="hidden"]').val(0);
                                else $(this).next('input[type="hidden"]').val(1);
							});
                            *}>
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
