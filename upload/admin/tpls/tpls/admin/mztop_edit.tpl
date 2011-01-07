<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        <div id="main">
            <div class="con box-green">
                <form action="?c=mztop&a=save" method="post">
                <input type="hidden" name="action" value="<{$action}>"/>
                <input type="hidden" name="id" value="<{$id}>"/>
                <input type="hidden" name="referer" value="<{$referer}>"/>
                <div class="box-header">
                    <h4><{if $action eq 'modify'}>修改<{else}></>添加<{/if}>名站首行网址</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120">名称：</th>
                            <td><input type="text" name="name" value="<{$data.name}>" class="textinput w270" /></td>
                        </tr>
                        <tr>
                            <th>HTML：</th>
                            <td> <textarea name='html' class="textinput" style="width:500px; height:300px;"><{$data.html}></textarea> </td>
                        </tr>
                        <tr>
                            <th>排序：</th>
                            <td><input type="text" name="order" value="<{$data.order}>" class="textinput w60"   onkeyup="value=value.replace(/[^\d]/g,'')" /></td>
                        </tr>
                        <tr>
                            <th>显示：</th>
                            <td>
                                <input type="radio" id="pass_yes" name="show" value="1"<{if $data.show eq 1}> checked="checked"<{/if}>/>
                                <label class="hand" for="pass_yes">是</label>
                                <input type="radio" id="pass_no" name="show" value="0"<{if $data.show eq 0}> checked="checked"<{/if}>/>
                                <label class="hand" for="pass_no">否</label>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="提交" /></a> 或 <a href="?c=mztop&a=index&classid=<{$data.class}>">取消</a>
                    </div>
                </div>
                </form>
            </div><!--/ con-->
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<{include file=footer.tpl}>
