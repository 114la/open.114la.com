<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        <div id="main">
            <div class="con box-green">
                <form name="makehtmlform" action="?c=make_html&action=make" method="post">
                	<input type="hidden" name="" value="" id="makehtml" />
                </form>
                <div class="box-header">
                    <h4>选择要生成的页面</h4>
                </div>
                
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <td>
                                <div style=" padding-left:480px">
                                	
                                    <button type="button" name='make[index]' onclick="Make(this.name)" class="button-02" >生成首页</button><br /><br />
                                    
                                    <button type="button" name='make[catalog]' onclick="Make(this.name)"  class="button-02" >生成内容分类页面</button><br /><br />

                                    <button type="button" name='make[zhuanti]' onclick="Make(this.name)"  class="button-02" >生成专题页面</button><br /><br />

                                    <button type="button" name='make[all]' onclick="Make(this.name)"  class="button-02" >生成全站</button><br /><br />
                                </div>
                                
                                <script type="text/javascript">
									function Make(name){
                                		var makehtml = document.getElementById('makehtml');
										var form = document.makehtmlform;
										makehtml.name = name;
										makehtml.value = 1;
										
										form.submit();
										
										
										
									}
									
                                
                                </script>
                            </td>
                        </tr>
                    </table>
                </div>
                
            </div><!--/ con-->
            
            
            
        </div>    
    </div><!--/ container-->
    </div><!--/ wrap-->
<{include file=footer.tpl}>
