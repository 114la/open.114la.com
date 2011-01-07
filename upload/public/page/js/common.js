var search_config = {
	s115: {
            action: "http://115.com/s",
            name: "q",
            btn: "115搜索",
            img: ["115.com","/static/images/s/115.gif"],
            url: "http://115.com/",
            params: {
				ie:'gbk'
			}
    },
	baidu:{
		action:"http://www.baidu.com/s",
		name:"wd",
		url:"http://www.baidu.com/index.php?tn=ylmf_4_pg&ch=7",
		img:["百度","/static/images/s/baidu.gif"],
		btn:"百度一下",
		params: {
		    tn: 'ylmf_4_pg',
		    ch: '7'
		}
	},
	google:{
		action:"http://www.google.com.hk/search",
		name:"q",
		url:"http://www.google.com.hk/webhp?prog=aff&client=pub-0194889602661524&channel=5676023677",
		img:["谷歌","/static/images/s/google.gif"],
		btn:"Google 搜索",
		params: {
			client:'pub-0194889602661524',
			channel :'2000040001',
			forid :'1',
			prog :'aff',
			hl :'zh-CN',
			source :'sdo_sb_html',
			ie:'gb2312'
		}
	},
	taobao: {
	    action: "http://search8.taobao.com/browse/search_auction.htm",
	    name: "q",
	    btn: "淘宝搜索",
	    img: ["淘宝网","http://www.114la.com/static/images/s/taobao.gif"],
	    url: "http://pindao.huoban.taobao.com/channel/onSale.htm?pid=mm_11140156_2208468_8968719&mode=86",
	    params: {
	        pid: "mm_11140156_2208468_8968719",
	        mode: "86",
	        commend: "all",
	        search_type: "action",
	        user_action: "initiative",
	        f: "D9_5_1",
	        at_topsearch: "1",
	        sid: "(05ba391dbdcada4634d4077c189eeef7)",
	        sort: "",
	        spercent: "0"
	    }
	}
}

var SearchBox = (function(){
	var HiddenParams = [$("#searchForm").el.tn,$("#searchForm").el.ch];	
	function Set(searchItem){
		$("#searchForm").el.action = searchItem.action;
        $("#searchForm .label img").el.src = searchItem.img[1];
        $("#searchForm .label img").el.setAttribute("alt", searchItem.img[0]);
        $("#searchForm .text").el.name = searchItem.name;
        $("#searchForm .submit").el.value = searchItem.btn;
        $("#searchForm .label").el.href = searchItem.url;
		
		function removeParams(inputArr){
	        for (var i = 0, len = inputArr.length; i < len; i++) {
	            $("#searchForm").remove(inputArr[i]);
	        }
	        return [];
	    }

		if (HiddenParams.length > 0) {
	        HiddenParams = removeParams(HiddenParams);
	    }
		
		for (var item in searchItem.params) {
	        $("#searchForm").create("input", {
	            name: item,
	            value: searchItem.params[item],
	            type: "hidden"
	        }, function(el){
	            HiddenParams.push(el);
	            this.append(el);
	        })
	    }//创建需要的参数，并保存数组中
    }
    return {
    	set:Set
    }
    
})();

$(".searchform .ctrl label").on("click",function(){
	var radio_item = this.firstChild;
	if(radio_item.checked){
		SearchBox.set(search_config[radio_item.value]);
		 $(".searchform .text").el.focus();
	}
});



function DOMReady(f){
  if (/(?!.*?compatible|.*?webkit)^mozilla|opera/i.test(navigator.userAgent)){ // Feeling dirty yet?
    document.addEventListener("DOMContentLoaded", f, false);
  }  else {
    window.setTimeout(f,0);
  }
}

DOMReady(function(){
	$("#ctrl_form").el.reset();
	if(window.location.hash || window.location.hash ==''){
		
	}else{
		$(".searchform .text").el.focus();
	}
});