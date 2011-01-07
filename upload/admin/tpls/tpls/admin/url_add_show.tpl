<{include file="header.tpl"}>
<div class="wrap">
    <div class="container">
        
        <div id="main">
            
            <div class="con box-green">
                <div class="box-header">
                    <h4>申请收录站点信息</h4>
                </div>
                
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120" >网站名称：</th>
                            <td><{$data.name}></td>
                        </tr>
                        <tr>
                            <th>网站网址：</th>
                            <td><{$data.siteurl}></td>
                        </tr>
                        <tr>
                            <th>网站简介：</th>
                            <td><{$data.jianjie|nl2br}></td>
                        </tr>
                        <tr>
                            <th>网站访问量：</th>
                            <td><{$data.pv}></td>
                        </tr>
                        <tr>
                            <th>网站分类：</th>
                            <td><{$data.class}></td>
                        </tr>
                        <tr>
                            <th>网站备案信息：</th>
                            <td><{$data.icp}></td>
                        </tr>
                        <tr>
                            <th>建站时间：</th>
                            <td><{$data.sitetime}></td>
                        </tr>
                        <tr>
                            <th>联系人：</th>
                            <td><{$data.lianxiren}></td>
                        </tr>
                        <tr>
                            <th>通讯地址：</th>
                            <td><{$data.address}></td>
                        </tr>
                        <tr>
                            <th>腾讯QQ：</th>
                            <td><{$data.qq}></td>
                        </tr>
                        <tr>
                            <th>手机号码：</th>
                            <td><{$data.mobile}></td>
                        </tr>
                        <tr>
                            <th>固定电话：</th>
                            <td><{$data.tel}></td>
                        </tr>
                        <tr>
                            <th>电子邮件：</th>
                            <td><{$data.email}></td>
                        </tr>
                        <tr>
                            <th>友情链接添加：</th>
                            <td><{if $data.sharelink eq 1}>是<{else}>否<{/if}></td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                        是否通过审核：<input type="radio" name="pass" id="pass_yes" /><label for="pass_yes" class="hand pr5"> 是</label> <input type="radio" name="pass" id="pass_no" /><label class="hand" for="pass_no"> 否</label>
                    </div>
                    <script type="text/javascript">
                    $(document).ready(function(){
                        $('#pass_yes').click(function(){
                            $('#pass_yes_wrap').show();
                            $('#pass_no_wrap').hide();
                        });
                        $('#pass_no').click(function(){
                        	$('#pass_no_wrap').show();
                            $('#pass_yes_wrap').hide();
                        });
                    });
                    </script>
                </div>
            </div><!--/ con-->
            <div class="con box-green" id="pass_yes_wrap" style="display:none;">
                <form action="?c=url_add&a=pass" method="post">
                <input type="hidden" name="id" value="<{$data.id}>"/>
                <input type="hidden" name="pass" value="yes"/>
                <input type="hidden" name="referer" value="<{$back}>"/>
                <div class="box-header">
                    <h4>通过审核加入数据库</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120">网站名称：</th>
                            <td><input style="color:<{$data.namecolor|default:'#000'}>;" type="text" id="js_test_link" name="site_name" value="<{$data.name}>" class="textinput w270" /><span style="margin-left:10px;">链接颜色：</span><span id="js_link_color" style="margin-right:10px;"></span><input id="js_test_input" name="color" type="hidden" value="<{$data.namecolor}>" /></td>
                        </tr>
                        <tr>
                            <th>网站网址：</th>
                            <td><input type="text" name="site_url" value="<{$data.siteurl}>" class="textinput w270" /></td>
                        </tr>
                        <tr>
                            <th>开始时间：</th>
                            <td><input type="text" id="start_time" name="start_time" value="<{$data.start_time}>" class="textinput w80" /></td>
                        </tr>
                        <tr>
                            <th>结束时间：</th>
                            <td><input type="text" id="end_time" name="end_time" value="<{$data.end_time}>" class="textinput w80" /></td>
                        </tr>
                        <tr>
                            <th>网站排序：</th>
                            <td><input type="text" name="displayorder" value="<{$data.displayorder}>" class="textinput w60" /></td>
                        </tr>
                        <tr>
                            <th>推荐：</th>
                            <td>
                                <input type="radio" id="pass_yes" name="recommend" value="1"<{if $data.recommend eq 1}> checked="checked"<{/if}>/>
                                <label class="hand" for="pass_yes">是</label>
                                <input type="radio" id="pass_no" name="recommend" value="0"<{if $data.recommend eq 0}> checked="checked"<{/if}>/>
                                <label class="hand" for="pass_no">否</label>
                            </td>
                        </tr>
                        <tr>
                            <th  style="vertical-align:top;">您选择的分类是：</th>
                            <td>
                                <div id="classSearch" class="fl ml5" style="_margin-top:-6px;">
                                    <input type="text" id="tool_kw" autocomplete="off" onclick="(this.value == '快速搜索分类') ? this.value='' :''" onblur="(this.value == '') ? this.value='快速搜索分类' :''" onmouseover="this.select()" value="快速搜索分类" class="textinput gray9 w270 mt5" />
                                </div>
                                <div style="clear:both"></div>
                                <input id="js_submit_classid" type="hidden" name="classid"  value="<{$class_id}>" />
                                <div id="cate" style="height:30px; line-height:30px;">您选择的分类：<span id="js_link_text_span"></span></div>
                                <div id="cate_list">
                                    <table>
                                        <tr id="js_cate_list">
                                            <td index="0">
                                                <ol>
                                                <{foreach from=$class_list item=class}>
                                                    <li classid="<{$class.classid}>"><{$class.classname}></li>
                                                <{/foreach}>
                                                </ol>
                                            </td>
                                        </tr>
                                    </table>
                                </div> 
                                <script type="text/javascript" src="static/js/cate_list_manager.js"></script>
                                <script type="text/javascript">
                                    CateListManager.Init();
                                    <{if $class_id_list <> ''}>
                                    CateListManager.SelectClass('<{$class_id_list}>');	//------------------加选中列表
                                    <{/if}>
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <th style="vertical-align:top;">审核通过理由：</th>
                            <td>
                                <textarea name="shenhe" class="w270"><{$data.shenhe}></textarea>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="确定收录" /> 或 <a href="<{$back}>">取消</a>
                    </div>
                </div>
                </form>
            </div><!--/ con-->
            <div class="con box-green" id="pass_no_wrap" style="display:none;">
                <form action="?c=url_add&a=pass" method="post">
                <input type="hidden" name="id" value="<{$data.id}>"/>
                <input type="hidden" name="pass" value="no"/>
                <input type="hidden" name="referer" value="<{$back}>"/>
                <div class="box-header">
                    <h4>审核不通过理由</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th style="vertical-align:top;" class="w120">审核不通过理由：</th>
                            <td>
                                <textarea name="shenhe" class="w270"><{$data.shenhe}></textarea>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="确定" /> 或 <a href="<{$back}>">取消</a>
                    </div>
                </div>
                </form>
            </div><!--/ con-->
        </div>    
    </div><!--/ container-->
    </div><!--/ wrap-->
<div id="js_search_msg" class="js_search_msg" style="display:none;"></div>
<style type="text/css">
	.js_search_msg{ position:absolute; background:#fff; border:1px solid #CEDEAE;}
	.js_search_msg li{ padding:3px 5px; cursor:pointer;}
	.js_search_msg li.active{ background:#EBF4D8}
</style>
<script type="text/javascript" src="static/js/textboxdrop.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".admin-tb").find("input[rel='del']").each(function(i){
			$(this).bind("click",function(){
				$(".admin-tb").find("input[rel='del']").each(function(i){
					var tr = $(this).parent().parent();
					if(this.checked){
						tr.addClass("checked");
					}
					else{
						tr.removeClass("checked");
					}
				})
				
			})
		});					   
		
		var t = new TextBoxDrop("tool_kw","js_search_msg");
		t.SetEnterHandler (function(ele){
			CateListManager.SelectClass($(ele).attr("rel"));
		});
		t.DefaultKey = "id_list";
		t.SetAjaxMethod($.get);
		t.Url('?c=class&a=search&k=');
		t.SetContentStyle(function(intput,contentbox){
			var inputBox = $(intput);
			if($.browser.ie){
				contentbox.style.left = inputBox.offset().left;
				contentbox.style.top = inputBox.offset().top + 23;
			}
			else{
				$(contentbox).css({
					top : inputBox.offset().top + 23,
					left: inputBox.offset().left
				});
			}
		});
		t.DisplayContentHandler(function(input,contentbox){						   
			if($(contentbox).width() < $(input).outerWidth()){
				$(contentbox).width($(input).outerWidth());
			}
		});
	});
</script>
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
<{include file="footer.tpl"}>