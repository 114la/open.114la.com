<{include file=header.tpl}>
<{* ��ӷ��� *}>
<{if $action == 'add'}>
<div class="wrap">
    <div class="container">
        
        <div id="main">
  
            
            <div class="con box-green">
                <form action="?c=local_class&a=add" method='post'>
                <div class="box-header">
                    <h4>��ӵط��������</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120">�������ƣ�</th>
                            <td><input type="text" name="classnewname" class="textinput w270" /></td>
                        </tr>
                        <tr>
                            <th>��������</th>
                            <td><input name="orderid" type="text" id="orderid" class="textinput" onkeyup="value=value.replace(/[^\d]/g,'') "/></td>
                        </tr>
                        <tr>
                            <th>keywords��</th>
                            <td><input type="text" name='keywords' class="textinput w360" /></td>
                        </tr>
                        <tr>
                            <th  style="vertical-align:top;">description��</th>
                            <td><textarea name='description' class="w360"></textarea></td>
                        </tr>
                        <tr>
                            <th  style="vertical-align:top;">�����ķ����ǣ�</th>
                            <td>
                               <select name="classid">
                                    <option value="">��ѡ�񡭡�</option>
                                    <{foreach from = $class_list item = i}>
                                        <option value="<{$i.classid}>"><{$i.classname}></option>
                                    <{/foreach}>
                               </select>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="���" /> �� <a href="?c=local_class&a=index">ȡ��</a>
                    </div>
                </div>
                </form>
            </div><!--/ con-->
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<{* �޸ķ��� *}>
<{elseif $action == 'edit'}>
<div class="wrap">
    <div class="container">
        
        <div id="main">
  
            
            <div class="con box-green">
                <form action="?c=local_class&a=edit" method='post'>
                  <input name="id" type="hidden"  value="<{$info.classid}>" />
                  <input name="type" type="hidden"  value="<{$type}>" />
                  <input name="returnid" type="hidden"  value="<{$returnid}>" />
                <div class="box-header">
                    <h4>�༭�ط��������</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120">�������ƣ�</th>
                            <td><input type="text" name="classnewname" value="<{ $info.classname }>" class="textinput w270" <{if $info.parentid eq 0}>readonly<{/if}> /></td>
                        
                        </tr>
                        <tr>
                            <th>keywords��</th>
                            <td><input type="text" name='keywords' value='<{$info.keywords}>' class="textinput w360" /></td>
                        </tr>
                        <tr>
                            <th  style="vertical-align:top;">description��</th>
                            <td><textarea name='description' class="w360"><{$info.description}></textarea></td>
                        </tr>
                        <{if $info.parentid ne 0}>
                        <tr>
                            <th  style="vertical-align:top;">�����ķ����ǣ�</th>
                            <td>
                                <select name="classid" id="classid">
                                    <option value="">��ѡ�񡭡�</option>
                                    <{foreach from = $class_list item = i}>
                                        <option<{if $info.parentid eq $i.classid}> selected="selected"<{/if}> value="<{$i.classid}>"><{$i.classname}></option>
                                    <{/foreach}>
                                </select>
                            </td>
                        </tr>
                        <{/if}>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="�޸�" /> <input name="mkhtml" type="submit" value="�޸Ĳ����ɷ���" />�� <a href="?c=local_class&a=index">ȡ��</a>
                    </div>
                </div>
                </form>
            </div><!--/ con-->
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->

<{* �����б� *}>
<{else}>
<div class="wrap">
    <div class="container">

        <div id="main">
            
            <div class="con">
            	<form action='?c=local_class&a=index&type=<{$type}>&classid=<{$classid}>' method='post'>
                  <div class="table">
                  	<div class="th">
                    	<div class="form">
                            <div class="fl">
                               <input type="button" onclick="window.location='?c=local_class&a=add&classid=<{$class_id}>'" value="��ӵط��������" />
                                  &nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                        </div>
                    </div>
                    <table class="admin-tb" id="datatable">
                    <tr>
                    	<th width="41" class="text-center">ѡ��</th>
                    	<th width="97">����</th>
                        <th width="248">��������</th>
                        <th width="300">����ҳ���ַ</th>
                    	<th width="100">վ������</th>
                        <th width="161">����</th>
                    </tr>

                    <{foreach from=$class_list item=class}>
                    <tr sitenum='<{$class.sitenum}>' sub_sitenum="<{$class.sub_sitenum}>" classid="<{$class.classid}>" classnum='<{$class.sub_classnum}>' childindex="1">
                    <td class="text-center"><input name="rmid[<{$class.classid}>]" type="checkbox" rel="del"  /></td>
                    <td><{$class.displayorder}></td>
                    <td rel="classname"><a href="javascript://"><{$class.classname}></a></td>
                    <td><{$class.path}>.htm</td>
                    <td><{$class.sub_sitenum}></td>
                    <td>[<a href="?c=local_class&a=edit&id=<{$class.classid}>&type=<{$type}>&classid=<{$classid}>&path=<{$class.class_path}>">�޸�</a>] </td>
                    </tr>
                    <{/foreach}>
                    
                    </table>
                    <div class="th">
                    	<div class="form">
                        <input type='hidden' name='commit' value='1' />
                        <input type='radio' name='action' value='del' />ɾ��
                        <input type='radio' name='action' value='update' checked />��������
                        <input type="submit" value="����" />&nbsp;
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
<div id="js_search_msg" class="js_search_msg" style="display:none;"></div>
<{include file=footer.tpl}>
<style type="text/css">
	.js_search_msg{ position:absolute; background:#fff; border:1px solid #CEDEAE;}
	.js_search_msg li{ padding:3px 5px; cursor:pointer;}
	.js_search_msg li.active{ background:#EBF4D8}}
</style>
<!-- 09.11.18 -->
<script type="text/javascript" src="static/js/catgorymanager.js"></script>
<script type="text/javascript">
    CatgoryManager.AjaxUrl = "?c=local_class&a=ajax_get_list&id=";
	CatgoryManager.SetDisplayFun(function(data,parentNode,childIndex){
		var pexyText = "��-";
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
				html += '<td rel="classname">' + pexyText + item["classname"] + ' <a href="?c=local_site&classid='+item["classid"]+'" style="color:red;">[ ��ַ�б�]</a></td>';
			}
			else{
				html += '<td rel="classname">' + pexyText + '<a href="javascript://">' + item["classname"]+'</a></td>';
			}
			
			html += '<td>&nbsp;</td>';
			html += '<td>'+ (item["sitenum"] == 0? (item["sub_sitenum"] || 0 ) : item["sitenum"])+'</td>';
			html += '<td>[<a href="?c=local_class&a=edit&id='+item["classid"]+'&type=<{$type}>&classid='+item["classid"]+'&path='+item["path"]+'">�޸�</a>]</td>';
			html += '</tr>';
		}
		//alert(html);
		var col = $(html);
		col.find("td[rel='classname'] a").each(function(i){
			CatgoryManager._bindEvent($(this));
		});
		parentNode.after(col);
		return col;
	});
	CatgoryManager.Init($("#datatable"));
</script>
