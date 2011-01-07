<{include file='header.tpl'}>

<body id="main_page">

<div class="wrap">
    <div class="container">
        
        <div id="main">
            
            
            <div class="con box-green">
                <form action="<{$sys.subform}>" method="post" enctype="multipart/form-data">
<div class="box-header">
                    <h4>修改用户权限: <{$data.name}></h4>
                </div>
                <style type="text/css" >
                	.table-font td { width:100px;}
                </style>
                <div class="box-header">
                    <h4>
                        <table class="table-font" style="width:800px; margin-left:5px;">
                            <tr>
                           	  <td><input type="checkbox" id="checkbox_0" rel="0" onClick="checkSameRel(this);" /> <label for="checkbox_0">首页管理</label></td>
                                <td><input type="checkbox" id="checkbox_1" rel="1" onClick="checkSameRel(this);" /> <label for="checkbox_1">系统管理</label></td>
                                <td><input type="checkbox" id="checkbox_2" rel="2" onClick="checkSameRel(this);" /> <label for="checkbox_2">网址管理</label></td>
                                <td><input type="checkbox" id="checkbox_7" rel="7" onClick="checkSameRel(this);" /> <label for="checkbox_7">专题管理</label></td>
                                <td><input type="checkbox" id="checkbox_3" rel="3" onClick="checkSameRel(this);" /> <label for="checkbox_3">广告管理</label></td>
                                <td><input type="checkbox" id="checkbox_4" rel="4" onClick="checkSameRel(this);" /> <label for="checkbox_4">数据管理</label></td>
                                <td><input type="checkbox" id="checkbox_5" rel="5" onClick="checkSameRel(this);" /> <label for="checkbox_5">模板管理</label></td>
                              <td><input type="checkbox" id="checkbox_6" rel="6" onClick="checkSameRel(this);" /> <label for="checkbox_6">静态生成</label></td>
                            </tr>
                        </table>
                    </h4>
                </div>
                <script type="text/javascript">
                	var checkSameRel = function(ele){
						$("#js_item_table").find("input[rel='"+$(ele).attr("rel")+"']").each(function(i){
							this.checked = ele.checked;
						});
					}
                </script>
                <div class="box-content">
                    <table class="table-font" style="width:800px;" id="js_item_table">
                        <tr>
	                        <td><label><input rel="0" name="auth[member114laurl_add114lafeedback]" type="checkbox" id="checkbox_5" value="1" <{if $auth.member114laurl_add114lafeedback}> checked <{/if}> />常用选项</label>
                            </td>
	                        <td><label><input rel="1" name="auth[config114la]" type="checkbox" id="checkbox_5" value="1" <{if $auth.config114la}> checked <{/if}> />基本设置</label></td>
                            <td><input rel="2" name="auth[famous_nav114lafamous_loop_playfamous_nav_tab114laindex_site114laindex_tool114lamztopl114larecycler]" type="checkbox" id="checkbox_5" value="1" <{if $auth.famous_nav114lafamous_loop_playfamous_nav_tab114laindex_site114laindex_tool114lamztop114larecycler}> checked <{/if}> />首页管理</td>
                            <td><input rel="7" name="auth[zhuanti114lazhuanti_class]" type="checkbox" id="checkbox_5" value="1" <{if $auth.zhuanti114lazhuanti_class}> checked <{/if}> />专题管理</td>
                            <td><input rel="3" name="auth[advise_index114lakey]" type="checkbox" id="checkbox_5" value="1" <{if $auth.advise_index114lakey}> checked <{/if}> />广告设置</td>
                            <td><input rel="4" name="auth[backup114larestore114larepair114laclear114lamysites]" type="checkbox" id="checkbox_5" value="1" <{if $auth.backup114larestore114larepair114laclear114lamysites}> checked <{/if}> />数据管理</td>
                            <td><input rel="5" name="auth[template_manage]" type="checkbox" id="checkbox_5" value="1" <{if $auth.template_manage}> checked <{/if}> />模板管理</td>
                            <td><input rel="6" name="auth[make_html114la]" type="checkbox" id="checkbox_5" value="1" <{if $auth.make_html114la}> checked <{/if}> />静态生成</td>
                            
                        </tr>
                        <tr>
                        	<td><label><input rel="0" name="auth[header114lamenu114lawelcome114laframe114lalogin]" type="checkbox" id="checkbox_5" value="1" <{if $auth.header114lamenu114lawelcome114laframe}> checked <{/if}> />导航显示</label></td>
                        	<td><label><input rel="1" name="auth[security114la]" type="checkbox" id="checkbox_5" value="1" <{if $auth.security114la}> checked <{/if}> />安全</label></td>
                            <td><input rel="2" name="auth[site_manage]" type="checkbox" id="checkbox_5" value="1" <{if $auth.site_manage}> checked <{/if}> />内页管理</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td> </td>
                        </tr>
                        <tr>
                        	<td></td>
                        	<td><label><input rel="1" name="auth[plan]" type="checkbox" id="checkbox_5" value="1" <{if $auth.plan}> checked <{/if}> />计划任务</label></td>
                            <td><input rel="2" name="auth[class]" type="checkbox" id="checkbox_5" value="1" <{if $auth.class}> checked <{/if}> />分类管理</td>
                            <td>&nbsp;</td>
                          <td>&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td> </td>
                        </tr>
                        <tr>
                        <td> </td>
                        <td><label><input rel="1" name="auth[log]" type="checkbox" id="checkbox_5" value="1" <{if $auth.log}> checked <{/if}> />管理员日志</label></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td> </td>
                            
                            <td></td>
                            <td></td>
                          <td> </td>
                        </tr>
                        <tr>
                        	<td></td>
                        	<td>&nbsp;</td>
                            <td>&nbsp;</td>
                          <td>&nbsp;</td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td> </td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="确定" /> 或 <a href="<{$sys.goback}>">取消</a>
                      <input name="step" type="hidden" id="step" value="2">
                      <input name="name" type="hidden" id="name" value="<{$data.name}>">
                    </div>
                </div>
                </form>
            </div><!--/ con-->
            
            
            
        </div>    
    </div><!--/ container-->

</div>
<{include file='footer.tpl'}>
