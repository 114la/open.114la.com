<{include file="header.tpl"}>
<script type="text/javascript">
    var list;
    $(document).ready(function(){
        list = $("#tb1").find("input[type='checkbox']").not("[rel]");
        list.each(function(i){
            $(this).bind("click",function(){
                CheckHanler();
            });
        });
    });
    
    var CheckHanler = function(){
        list.each(function(i){
            var input = $(this);
            if(this.checked){
                input.parent().parent().addClass("checked");
            }
            else{
                input.parent().parent().removeClass("checked");
            }
        });
    }
    
    var checkTb1 = function(selectType){
        CheckInit("tb1",selectType);
    }
    
    var CheckInit = function(tabelId,selectType){
        if(list == undefined){
            list = $("#" + tabelId).find("input[type='checkbox']").not("[rel]");
        }
        CheckControl(list,selectType,CheckHanler)
    }
    
    var CheckControl = function(childs,selectType,checkHandler){
        for(var i = 0,len = childs.length; i < len; i++){
            switch(selectType){
                case 1: //ȫѡ
                    childs[i].checked = true;
                    break;
                case 2: //��ѡ
                    childs[i].checked = false;
                    break;
                case 3: //��ѡ
                    childs[i].checked = !childs[i].checked;
                    break;
            }
        }
        if(checkHandler){
            checkHandler();
        }
    }
</script>
<div class="wrap">
    <div class="container">
        <div id="main">
            
            <div class="con">
            	<form action="?c=url_add&a=delete" method="post">
                    <input type="hidden" name="referer" value="<{$referer}>"/>
                  <div class="table">
                  	<div class="th">
                    &nbsp;&nbsp;<a href="?c=url_add">�鿴ȫ��</a>&nbsp;
                    &nbsp;&nbsp;<a href="?c=url_add&type=0">δ���</a>&nbsp;
                    &nbsp;&nbsp;<a href="?c=url_add&type=1">��ͨ�����</a>&nbsp;
                    &nbsp;&nbsp;<a href="?c=url_add&type=2">δͨ�����</a>&nbsp;
                    </div>
                    <table class="admin-tb" id="tb1">
                    <tr>
                        <th width="70">ɾ��</th>
                        <th width="100">��վ����</th>    
                        <th>����</th>            	
                        <th width="70">״̬</th>
                        <th width="70">����</th>
                    </tr>
                    <{foreach from=$list item=i}>
                    <tr>
                        <td><input type="checkbox" name="delete[<{$i.id}>]/>"/></td>
                        <td><{$i.name}></td>
                        <td><{$i.domain}></td>
                        <td><{if $i.type eq 1}>ͨ��<{elseif $i.type eq 2}>�ܾ�<{else}>δ���<{/if}></td>                        
                        <td><a href="?c=url_add&a=show&id=<{$i.id}>">�޸�</a></td>
                    </tr>
                    <{/foreach}>
                    <tr class="foot-ctrl">
                    <td colspan="5" class="gray">ѡ��: <a href="#" onclick="checkTb1(1);">ȫѡ</a> - <a href="#" onclick="checkTb1(3);">��ѡ</a> - <a href="#" onclick="checkTb1(2);">��</a></td>
                    </tr>
                    </table>                    
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