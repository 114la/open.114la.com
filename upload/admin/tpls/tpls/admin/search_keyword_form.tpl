<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        <div id="main">
            <div class="con box-green">
                <form action="<{$sys.subform}>" method="post">
                <{if $data.id}><input type="hidden" name="form[id]" value="<{$data.id}>"/><{/if}>
                <input type="hidden" name="referer" value="<{$sys.goback}>"/>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th  style="vertical-align:top;">分类：</th>
                            <td>
                                <select name=form[class]>
                                    <{html_options options=$options selected=$data.class}>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th class="w120">关键字名称：</th>
                            <td><input style="color:<{$data.namecolor|default:'#000'}>;" type="text" id="js_test_link" name="form[name]" value="<{$data.name}>" class="textinput w270" /><span style="margin-left:10px;">链接颜色：</span><span id="js_link_color" style="margin-right:10px;"></span><input id="js_test_input" name="form[namecolor]" type="hidden" value="<{$data.namecolor}>" /></td>
                        </tr>
                        <tr>
                            <th>关键字网址：</th>
                            <td><input type="text" name="form[url]" value="<{$data.url}>" class="textinput w270" /></td>
                        </tr>
                        <tr>
                            <th>开始时间：</th>
                            <td><input type="text" id="start_time" name="form[starttime]" value="<{if $data.starttime}><{$data.starttime|date_format:$date_format_ymd}><{/if}>" class="textinput w80" /></td>
                        </tr>
                        <tr>
                            <th>结束时间：</th>
                            <td><input type="text" id="end_time" name="form[endtime]" value="<{if $data.endtime}><{$data.endtime|date_format:$date_format_ymd}><{/if}>" class="textinput w80" /></td>
                        </tr>
                        <tr>
                            <th>排序：</th>
                            <td><input type="text" name="form[sort]" value="<{$data.sort}>" class="textinput w60"   onkeyup="value=value.replace(/[^\d]/g,'')" /></td>
                        </tr>
                        <{*
                        <tr>
                            <th>首页显示：</th>
                            <td>
                                <input type="radio" id="pass_yes" name="inindex" value="1"<{if $data.inindex eq 1}> checked="checked"<{/if}>/>
                                <label class="hand" for="pass_yes">是</label>
                                <input type="radio" id="pass_no" name="inindex" value="0"<{if $data.inindex eq 0}> checked="checked"<{/if}>/>
                                <label class="hand" for="pass_no">否</label>
                            </td>
                        </tr>
                        *}>
                        <tr>
                            <th style="vertical-align:top;">备注：</th>
                            <td>
                                <textarea class="w270" name="form[remarks]"><{$data.remarks}></textarea>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="提交" /></a>
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

