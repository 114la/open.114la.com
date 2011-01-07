function saving(obj){	
	obj.value = "±£¥Ê÷–...";
	if(obj.disabled==true){
		obj.disabled=false;
		
	}else{
		obj.disabled = "true";
	}
}


$(document).ready(function(){
	if ($.browser.msie && $.browser.version=="6.0"){
		if($("tr")){
			$("tr").bind("mouseover",function(){
				$(this).addClass("hover");
				
			})
			$("tr").bind("mouseout",function(){
				$(this).removeClass("hover");
				
			})
			
		}	
	}

});