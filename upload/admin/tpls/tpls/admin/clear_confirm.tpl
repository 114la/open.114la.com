<{include file=header.tpl}>
<div class="wrap">
    <div class="container">
        <div id="main">
            <div class="con">
                <br/>
                <form id="Delete" name="Delete" action="?c=clear&a=delete" method="post">
                    <input type="hidden" name="action" value="delete"/>
                    <div class="tips warn-ico">
                   	 <strong>����</strong>���ù��ܽ�ɾ��<strong>����ϵͳ���ݿ�����ݺ����ɵľ�̬ҳ�棡</strong>&nbsp;&nbsp;&nbsp;<input type="button" onclick="del()" value="ɾ ��"/>
                     <br/><strong>��վ����</strong>��<strong>��վ�ֲ�</strong>��<strong>��ҳ����</strong>���ݽ��ᱣ��������<strong>��ַ����</strong>���޸ġ�
                     <script type="text/javascript">
					 function del(){
						clean = confirm("ȷ��Ҫɾ����") ;
						if (clean) {
							document.Delete.submit();
						}
					 }
                     </script>
                     
                    </div>
                </form>
                <br/>
            </div><!--/ con-->
        </div>    
    </div><!--/ container-->
</div><!--/ wrap-->
<{include file=footer.tpl}>