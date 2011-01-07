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
                            <th class="w120">搜索栏分类：</th>
                            <td>
                                <select name=form[class]>
                                    <{html_options options=$options selected=$data.class}>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th class="w120">是否显示：</th>
                            <td>
                                <input type="checkbox" name="form[is_show]" value=1 <{if $data.is_show}>checked<{/if}> />
                            </td>
                        </tr>
                        <tr>
                            <th class="w120">名称：</th>
                            <td><input type="text" name="form[search_select]" value="<{$data.search_select}>" class="textinput w270" /> radio按钮的名称</td>
                        </tr>
                        <tr>
                            <th>接口地址：</th>
                            <td><input type="text" name="form[action]" value="<{$data.action}>" class="textinput w270" /> 表单的action值</td>
                        </tr>
                        <tr>
                            <th>搜索字段名：</th>
                            <td><input type="text" name="form[name]" value="<{$data.name}>" class="textinput w270" /> 输入框的name</td>
                        </tr>
                        <tr>
                            <th>LOGO连接：</th>
                            <td><input type="text" name="form[url]" value="<{$data.url}>" class="textinput w270" /> 点搜索logo时跳转的地址</td>
                        </tr>
                        <tr>
                            <th>LOGO图片：</th>
                            <td><input type="text" name="form[img_url]" value="<{$data.img_url}>" class="textinput w270" /> 规格为105*35px，请使用绝对路径</td>
                        </tr>
                        <tr>
                            <th>LOGO描述：</th>
                            <td><input type="text" name="form[img_text]" value="<{$data.img_text}>" class="textinput w270" /> 搜索LOGO的图片alt描述</td>
                        </tr>
                        <tr>
                            <th>按钮文字：</th>
                            <td><input type="text" name="form[btn]" value="<{$data.btn}>" class="textinput w270" /> 搜索按钮上的文字</td>
                        </tr>
                        <tr>
                            <th>排序：</th>
                            <td><input type="text" name="form[sort]" value="<{$data.sort}>" class="textinput w60"  onkeyup="value=value.replace(/[^\d]/g,'')" /></td>
                        </tr>
                        <tr>
                            <th style="vertical-align:top;">补充参数：</th>
                            <td valign="top">
                            	<table>
                                <tr>
                                	<td valign="top"><textarea class="w270" style="height:120px;" name="form[params]"><{$data.params}></textarea> </td>
                                    <td valign="top">对隐藏的input，或额外参数补充，没有可不填，如:<br />
								<p style="color:red">
                                &lt;input type="hidden" name="tn" value="1" /&gt; <br />
								&lt;input type="hidden" name="ch" value="2" /&gt;
                                </p>则填写:
                                <p style="color:red"> tn:'1',<br />
ch:'2'</p> </td>
                                </tr>
                              
                                </table>
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
