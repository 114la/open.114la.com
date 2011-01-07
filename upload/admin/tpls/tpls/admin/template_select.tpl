<{include file="header.tpl"}>
<div class="wrap">
    <div class="container">
        <div id="main">
            <div class="con box-green">
                <form action="#">
                    <div class="box-header">
                        <h4>当前主题 (<{$cur_tpl.name}>)</h4>
                    </div>
                    <div class="box-content">
                    	<div class="preview">
                        	<img src="<{$cur_tpl.preview}>" />
                        </div>
                    </div>
                    <{if $other_tpls}>
                     <div class="box-header">
                        <h4>可用主题</h4>
                    </div>
                    <div id="themeList" class="box-content">
                    	<div class="clearfix">
                            <{foreach from=$other_tpls item=i}>
                        	<div class="preview">
                            	<img src="<{$i.preview}>" />
                                <p><{$i.name}></p>
                                <p><a href="?c=template_manage&a=cur_tpl&apply=<{$i.path}>">启用</a> | <a href="?c=template_manage&a=cur_tpl&apply=<{$i.path}>&mkhtml=1">启用并生成首页</a> | 
                                <a href="?c=template_manage&a=cur_tpl&delete=<{$i.path}>" onclick="return confirm('不可恢复，确认删除吗？');">删除</a></p>
                            </div>
                            <{/foreach}>
                        </div>
                    </div>
                    <{/if}>
                    <div class="box-footer">
                        <div class="box-footer-inner">
                        	&nbsp;
                        </div>
                    </div>
                </form>
                <style type="text/css">
                	.preview { height:190px; width:225px; overflow:hidden;}
                    .preview img{ width:225px; height:190px; display:block;}
                    #themeList .preview{ float:left; margin: 0 5px; height:auto; text-align:center;}
                    #themeList .preview p { line-height:22px;}
                </style>
            </div><!--/ con-->
        </div>    
    </div><!--/ container-->
</div><!--/ wrap-->
</body>
</html>
