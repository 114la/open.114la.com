<{include file=header.tpl}>

<body id="main_page">

<div class="wrap">
    <div class="container">
        
        <div id="main">
            
            
            <div class="con box-green">
                <form action="<{$sys.subform}>" method="post" enctype="multipart/form-data">      
                
                <div class="box-header">
                    <h4>�����վ</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120">��վ���ƣ�</th>
                            <td><input name="name" type="text" class="textinput w270" id="name" value="<{$data.name}>" /></td>
                        </tr>
                        <tr>
                            <th>��վ��ַ��</th>
                            <td><input name="url" type="text" class="textinput w270" id="url" value="<{$data.url}>" /></td>
                        </tr>
                        <tr>
                            <th>ʱ�䣺</th>
                            <td>
                            <input type="text" id="starttime" name="starttime" value="<{if $data.starttime}><{$data.starttime|date_format:$date_format_ymd}><{/if}>" class="textinput w80" />
                            &nbsp; �� 
                            <input type="text" id="endtime" name="endtime" value="<{if $data.endtime}><{$data.endtime|date_format:$date_format_ymd}><{/if}>" class="textinput w80" /></td>
                        </tr>
                        <tr>
                            <th>����</th>
                            <td><input name="displayorder" type="text" class="textinput w60" id="displayorder" value="<{$data.displayorder}>" /></td>
                        </tr>
                        <tr>
                            <th>���壺</th>
                            <td>
                                <span id="js_link_color" style="margin-right:10px;"></span>
                                Ч��Ԥ����<a href="#"  id="js_test_link" >��վ����</a>
                                
                                <input id="js_test_input" name="namecolor" type="hidden" value="<{$data.namecolor}>" />
                            </td>
                        </tr>
                        <tr>
                            <th style="vertical-align:top;">��ע��</th>
                            <td>
                                <textarea name="remark" class="w270" id="remark"><{$data.remark}></textarea>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="�ύ" /> �� <a href="<{$sys.goback}>">ȡ��</a>
                      <input name="step" type="hidden" id="step" value="2">
                      <input name="id" type="hidden" id="id" value="<{$smarty.request.id}>">
                    </div>
                </div>
                </form>
            </div><!--/ con-->
            
            
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->

<{include file=footer.tpl}>
<link href="static/datapicker/css/jquery-ui-1.7.1.custom.css" rel="stylesheet" type="text/css"  />
<script type="text/javascript" src="static/datapicker/ui.core.js"></script>
<script type="text/javascript" src="static/datapicker/jquery-ui-1.7.1.custom.min.js"></script>

<script type="text/javascript" src="static/qrx/qrxpcom.js"></script>
<script type="text/javascript" src="static/qrx/qrcpicker.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	$("#starttime").datepicker();
	$("#endtime").datepicker();
	
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