<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        <div id="main">
            <div class="con">
                <br/>
                <form id="Delete" name="Delete" action="?c=clear&a=delete" method="post">
                    <input type="hidden" name="action" value="delete"/>
                    <div class="tips warn-ico">
                   	 <strong>警告</strong>：该功能将删除<strong>所有系统数据库的数据和生成的静态页面！</strong>&nbsp;&nbsp;&nbsp;<input type="button" onclick="del()" value="删 除"/>
                     <br/><strong>名站首行</strong>、<strong>名站轮播</strong>和<strong>首页工具</strong>数据将会保留，请在<strong>网址管理</strong>中修改。
                     <script type="text/javascript">
					 function del(){
						clean = confirm("确定要删除吗？") ;
						if (clean) {
							document.Delete.submit();
						}
					 }
                     </script>
                     
                    </div>
                </form>
                <br/>
            </div><!--/ con-->
        </div>    
    </div><!--/ container-->
</div><!--/ wrap-->
<{include file=footer.tpl}>