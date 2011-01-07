<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        
        <div id="main">
            
            
            <div class="con box-green">
                <form method="post" enctype="multipart/form-data" action="?c=mysites&a=index">
                <div class="box-header">
                    <h4>导入Mysites数据</h4>
                </div>
                <div class="box-content">
                <span class="green font-n"> 友情提示：转换的数据库，必须是从MySites后台备份的*.zip数据．若导入不成功，请解压该压缩包，并重新压缩为*.zip．(*为文件名)</span><br /><br />
                    <table class="table-font">
                        <tr>
                            <td>
                              <label>
                                Mysites数据文件：<input type='file' name="data_file" />
                              </label>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="导入" />
                    </div>
                </div>
                </form>
            </div><!--/ con-->
            
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->

<{include file=footer.tpl}>
