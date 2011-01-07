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
                case 1: //全选
                    childs[i].checked = true;
                    break;
                case 2: //不选
                    childs[i].checked = false;
                    break;
                case 3: //反选
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
                    &nbsp;&nbsp;<a href="?c=url_add">查看全部</a>&nbsp;
                    &nbsp;&nbsp;<a href="?c=url_add&type=0">未审核</a>&nbsp;
                    &nbsp;&nbsp;<a href="?c=url_add&type=1">已通过审核</a>&nbsp;
                    &nbsp;&nbsp;<a href="?c=url_add&type=2">未通过审核</a>&nbsp;
                    </div>
                    <table class="admin-tb" id="tb1">
                    <tr>
                        <th width="70">删除</th>
                        <th width="100">网站名称</th>    
                        <th>域名</th>            	
                        <th width="70">状态</th>
                        <th width="70">操作</th>
                    </tr>
                    <{foreach from=$list item=i}>
                    <tr>
                        <td><input type="checkbox" name="delete[<{$i.id}>]/>"/></td>
                        <td><{$i.name}></td>
                        <td><{$i.domain}></td>
                        <td><{if $i.type eq 1}>通过<{elseif $i.type eq 2}>拒绝<{else}>未审核<{/if}></td>                        
                        <td><a href="?c=url_add&a=show&id=<{$i.id}>">修改</a></td>
                    </tr>
                    <{/foreach}>
                    <tr class="foot-ctrl">
                    <td colspan="5" class="gray">选择: <a href="#" onclick="checkTb1(1);">全选</a> - <a href="#" onclick="checkTb1(3);">反选</a> - <a href="#" onclick="checkTb1(2);">无</a></td>
                    </tr>
                    </table>                    
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