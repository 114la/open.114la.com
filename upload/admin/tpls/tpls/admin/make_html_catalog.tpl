<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        <div id="main">
            <div class="con box-green">
                <form action="?c=make_html&a=catalog" method="post">
                <div class="box-header">
                    <h4>选择要生成的分类</h4>
                </div>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120"  style="vertical-align:top;">您选择的分类是：</th>
                            <td>
                                <select id="class_id" name="class_id">
                                    <{$class_list}>
                                </select>
                                <span id="class_id_span" style="display:none;"><{$class_id}></span>
                                <script>
                                    document.getElementById("class_id").value = document.getElementById("class_id_span").innerHTML;
                                </script>
                                <div id="classSearch"   >
                                    <div class="fl">
                                    <input type="text" id="tool_kw" autocomplete="off" value="快速搜索分类" class="textinput gray9 w270 mt5" />
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner"><input type="submit" value="提交" /></div>
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
    .js_search_msg li.active{ background:#EBF4D8}}
</style>
<script type="text/javascript" src="static/js/textboxdrop.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var t = new TextBoxDrop("tool_kw","js_search_msg");
        t.SetEnterHandler (function(ele){
            document.getElementById("class_id").value = ele.getAttribute("rel");
        });
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
<{include file=footer.tpl}>