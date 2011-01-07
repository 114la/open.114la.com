<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        <div id="main">
            <div class="con box-green">
                <form action="?c=cool_site&a=save" method="post">
                <input type="hidden" name="action" value="<{$action}>"/>
                <input type="hidden" name="id" value="<{$data.id}>"/>
                <input type="hidden" name="referer" value="<{$referer}>"/>
                <div class="box-header">
                    <h4><{if $action eq 'modify'}>�޸�<{else}></>���<{/if}>��ַ</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120">��վ���ƣ�</th>
                            <td><input style="color:<{$data.namecolor|default:'#000'}>;" type="text" id="js_test_link" name="site_name" value="<{$data.name}>" class="textinput w270" /><span style="margin-left:10px;">������ɫ��</span><span id="js_link_color" style="margin-right:10px;"></span><input id="js_test_input" name="color" type="hidden" value="<{$data.namecolor}>" /></td>
                        </tr>
                        <tr>
                            <th>��վ��ַ��</th>
                            <td><input type="text" name="site_url" value="<{$data.url}>" class="textinput w270" /></td>
                        </tr>
                        <tr>
                            <th>��ʼʱ�䣺</th>
                            <td><input type="text" id="start_time" name="start_time" value="<{if $data.starttime}><{$data.starttime|date_format:$date_format_ymd}><{/if}>" class="textinput w80" /></td>
                        </tr>
                        <tr>
                            <th>����ʱ�䣺</th>
                            <td><input type="text" id="end_time" name="end_time" value="<{if $data.endtime}><{$data.endtime|date_format:$date_format_ymd}><{/if}>" class="textinput w80" /></td>
                        </tr>
                        <tr>
                            <th>����</th>
                            <td><input type="text" name="order" value="<{$data.displayorder}>" class="textinput w60"  onkeyup="value=value.replace(/[^\d]/g,'')" /></td>
                        </tr>
                        <{*
                        <tr>
                            <th>�Ƽ���</th>
                            <td>
                                <input type="radio" id="pass_yes" name="recommend" value="1"<{if $data.good eq 1}> checked="checked"<{/if}>/>
                                <label class="hand" for="pass_yes">��</label>
                                <input type="radio" id="pass_no" name="recommend" value="0"<{if $data.good eq 0}> checked="checked"<{/if}>/>
                                <label class="hand" for="pass_no">��</label>
                            </td>
                        </tr>
                        *}>
                        <tr>
                            <th style="vertical-align:top;">��ע��</th>
                            <td>
                                <textarea class="w270" name="remark"><{$data.remark}></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th  style="vertical-align:top;">���ࣺ</th>
                            <td>                               
                                <select id="alltopic" name="class_id">
                                    <option value="">��ѡ�񡭡�</option>
                                    <{foreach from = $class_list item = i}>
                                        <option<{if $data.class eq $i.classid}> selected="selected"<{/if}> value="<{$i.classid}>"><{$i.classname}></option>
                                    <{/foreach}>
                                </select>
                            </td>
                        </tr>                        
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="�ύ" /></a> �� <a href="?c=cool_site&a=index&classid=<{$data.class}>">ȡ��</a>
                    </div>
                </div>
                </form>
            </div><!--/ con-->
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<link href="static/datapicker/css/jquery-ui-1.7.1.custom.css" rel="stylesheet" type="text/css"  />
<script type="text/javascript" src="static/datapicker/ui.core.js"></script>
<script type="text/javascript" src="static/datapicker/jquery-ui-1.7.1.custom.min.js"></script>
<script type="text/javascript" src="static/qrx/qrxpcom.js"></script>
<script type="text/javascript" src="static/qrx/qrcpicker.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#start_time").datepicker();
	$("#end_time").datepicker();

	var colorstr = "";
	colorstr = document.getElementById("js_test_input").value;
	var cp = new QrColorPicker(colorstr);
	cp.onChange = function(color){
		document.getElementById("js_test_link").style.color = color;
		document.getElementById("js_test_input").value = color;
	}
	document.getElementById("js_link_color").innerHTML = cp.getHTML();
});
</script>
<{include file=footer.tpl}>
