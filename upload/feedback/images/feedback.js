
function inputFocus(obj){
	obj.style.border = "1px solid #6699dd"
	obj.style.background = "#FFFBE5"
}
function inputBlur(obj){
	obj.style.border = "1px solid #AEAEAE"
	obj.style.background = "#ffffff"
}
function displaySpareNumber(_this,size)
{
	var spareNumber=document.getElementById("spareNumber");	
	var len=_this.value.replace(/[^\x00-\xff]/gi,'xx').length/2;
	var snum=Math.floor(parseInt(size)-len);		
	spareNumber.value=snum;
	if(snum<0)
	{
		if(_this.value.length!=len)
		{
			if((len-_this.value.length)>(size/2))
			{
				_this.value=_this.value.substring(0,size/2);
			}
			else
			{
				_this.value=_this.value.substring(0,size-(len-_this.value.length));
			}
		}
		else
		{
			_this.value=_this.value.substring(0,size);				
		}
		spareNumber.value=0;
		return;			
	}		
}
$(document).ready(function() {
	$('#submit-btn').click(function() {
		$('#messageBox').html('<img src="images/loading.gif" />');
		$.post('feedback.php', {username: $('#name').val(), email: $('#email').val(), content: $('#feedback').val()}, function(response) {
			var data = eval("("+response+")");			
			$('#messageBox').html(data.message);
			if (data.code == 3)
			{
				$('#name').val('');
				$('#email').val('');
				$('#feedback').val('');
			}
		});
	});
});