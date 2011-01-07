    <div id="guide" class="bd">
    <dl>
    <dt>您当前的位置：</dt>
    <dd><a href="<{$URL}>" target="_parent">首页</a></dd>
    <{if $parent_class_name}><dd><em>&gt;</em><{$parent_class_name}></dd><{/if}>
    <{if $current_class_name}><dd><em>&gt;</em><{$current_class_name}></dd><{/if}>
    </dl>
    <ul>
    <li class="sethome"><a href="javascript:void(0)" onclick="Yl.setHome(this,'<{$URL}>')" target="_parent" class="gray6">设本站为主页</a></li>
    <li class="feedback"><a href="<{$URL}>/feedback/" class="gray6">网友留言</a></li>
    </ul>
    
    </div><!--/ guide-->
        
    <div id="catenav">
    	<ul class="clearfix">
        <{foreach name=class_list from = $key_list key = k item = i}>
        	<li<{$i.txtclass}>><a href="<{$i.url}>" target="_parent"><{$k}></a> <{if not $smarty.foreach.class_list.last}>|<{/if}> </li>
        <{/foreach}>
        </ul>
    </div><!--/ catenav-->
<div class="bd" id="cate">
<{foreach from = $site_list key = k item = parent}>
	<h3 id="<{$key_list.$k.classid}>"><{$k}></h3>
    <ul class="clearfix">
    <{foreach from = $parent item = i}>
        <{if $i.name eq 'NULL'}>
            <li><a href=""></a></li>
        <{elseif $i.domain}>
            <li><a href="<{$i.url}>" target="_blank"<{if $i.namecolor}> style="color:<{$i.namecolor}>;"<{/if}>><{$i.name}></a><{$i.good}></li>
        <{else}>
            <li><a href="<{$i.url}>" target="_blank"<{if $i.namecolor}> style="color:<{$i.namecolor}>;"<{/if}>><{$i.name}></a><{$i.good}></li>
        <{/if}>
    <{/foreach}>
     </ul>
<{/foreach}>
</div>
