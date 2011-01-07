<{include file="header.tpl"}>
<div class="wrap">
    <div class="container">
        <div id="main">
            <div class="con box-green">
                <div class="box-header">
                    <h4>意见反馈</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120" >昵称：</th>
                            <td><{$data.username}></td>
                        </tr>
                        <tr>
                            <th>E-Mail：</th>
                            <td><{$data.email}></td>
                        </tr>
                        <tr>
                            <th style="vertical-align: top;">内容：</th>
                            <td><{$data.content|nl2br}></td>
                        </tr>
                        <tr>
                            <th>时间：</th>
                            <td><{$data.add_time|date_format:$date_format}></td>
                        </tr>
                        <tr>
                            <th></th>
                            <td><a href="<{$referer}>">返回</a></td>
                        </tr>
                    </table>
                </div>
            </div><!--/ con-->
        </div>    
    </div><!--/ container-->
    </div><!--/ wrap-->
<{include file="footer.tpl"}>