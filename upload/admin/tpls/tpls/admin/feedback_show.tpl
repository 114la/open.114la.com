<{include file="header.tpl"}>
<div class="wrap">
    <div class="container">
        <div id="main">
            <div class="con box-green">
                <div class="box-header">
                    <h4>�������</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120" >�ǳƣ�</th>
                            <td><{$data.username}></td>
                        </tr>
                        <tr>
                            <th>E-Mail��</th>
                            <td><{$data.email}></td>
                        </tr>
                        <tr>
                            <th style="vertical-align: top;">���ݣ�</th>
                            <td><{$data.content|nl2br}></td>
                        </tr>
                        <tr>
                            <th>ʱ�䣺</th>
                            <td><{$data.add_time|date_format:$date_format}></td>
                        </tr>
                        <tr>
                            <th></th>
                            <td><a href="<{$referer}>">����</a></td>
                        </tr>
                    </table>
                </div>
            </div><!--/ con-->
        </div>    
    </div><!--/ container-->
    </div><!--/ wrap-->
<{include file="footer.tpl"}>