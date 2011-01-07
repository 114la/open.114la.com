<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        <div id="main">
            <div class="con box-green">
                <form action="?c=famous_tab&a=save" method="post">
                <input type="hidden" name="action" value="<{$action}>"/>
                <input type="hidden" name="id" value="<{$id}>"/>
                <input type="hidden" name="referer" value="<{$referer}>"/>
                <div class="box-header">
                    <h4><{if $action eq 'modify'}>修改<{else}></>添加<{/if}>网址</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120">标签名称：</th>
                            <td><input type="text" name="name" value="<{$data.name}>" class="textinput w270" /></td>
                        </tr>
                        <tr>
                            <th>ifreme网址：</th>
                            <td><input type="text" name="url" value="<{$data.url}>" class="textinput w270" /></td>
                        </tr>
                        
                        <tr>
                            <th>排序：</th>
                            <td><input type="text" name="order" value="<{$data.order}>" class="textinput w60"   onkeyup="value=value.replace(/[^\d]/g,'')" /></td>
                        </tr>
                        
                        <tr>
                            <th>是否缓存：</th>
                            <td><label><input type="radio" name="nocache" value='0' <{if $data.nocache eq 0}>checked="checked"<{/if}>  />是</label>&nbsp;&nbsp;&nbsp;<label><input type="radio" name="nocache" value='1' <{if $data.nocache}>checked="checked"<{/if}> />否</label>
								
                                
                                </td>
                        </tr>
                        <tr>
                        	<th>&nbsp;</th>
                            <td><p>这里缓存是指页面在不刷新情况下，只加载iframe一次,避免来回切换Tab时每次都去加载。<br />
                                	如选择不缓存则每次切换Tab时都重新加载，若当前Tab没有被激活,则iframe会被清空。<br />
									<em style="color:red; font-style:normal">建议只在“股票版块”等自刷新数据的iframe选择不缓存。</em><br />

                                </p>
                                
                                </td>
                        </tr>
                        
                        
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="提交" /></a> 或 <a href="?c=famous_tab&a=index&classid=<{$data.class}>">取消</a>
                    </div>
                </div>
                </form>
            </div><!--/ con-->
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<{include file=footer.tpl}>
