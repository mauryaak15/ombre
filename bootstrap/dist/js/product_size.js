/*Displaying size of product according to availability (included in producct_info.php) */

//Total product sizes display

if(!$('input[name="product_color"]').prop("checked")){

	if(xs==''){
		$("label[for='xs']").addClass("size_not_available").attr("title","Not In Store");
		$("input[id='xs']").attr("disabled","disabled");
	}
	if(s==''){
		$("label[for='s']").addClass("size_not_available").attr("title","Not In Store");
		$("input[id='s']").attr("disabled","disabled");
	}
	if(m==''){
		$("label[for='m']").addClass("size_not_available").attr("title","Not In Store");
		$("input[id='m']").attr("disabled","disabled");
	}
	if(l==''){
		$("label[for='l']").addClass("size_not_available").attr("title","Not In Store");
		$("input[id='l']").attr("disabled","disabled");
	}
	if(xl==''){
		$("label[for='xl']").addClass("size_not_available").attr("title","Not In Store");
		$("input[id='xl']").attr("disabled","disabled");
	}
	if(xxl==''){
		$("label[for='xxl']").addClass("size_not_available").attr("title","Not In Store");
		$("input[id='xxl']").attr("disabled","disabled");

	}
}


//Size according to selected color

$('input[name="product_color"]').change(function(){
			color_name = $(this).val();
			var xhttp;
	    if(window.XMLHttpRequest){
	      xhttp = new XMLHttpRequest();
	    }
	    else{
	      xhttp = new ActiveXObject("Microsoft.XMLHTTP");
	    }
	    xhttp.onreadystatechange = function(){
	      if(xhttp.readyState == 4 && xhttp.status == 200){
					color_sizes_arr = JSON.parse(xhttp.responseText);



					var i = 0;
					xs=s=l=m=xl=xxl=null;
					var color_sizes_arr_length = color_sizes_arr.length;
					while(i<color_sizes_arr_length){
						switch(color_sizes_arr[i]){
							case "XS": xs= color_sizes_arr[i];
							break;
							case "S": s= color_sizes_arr[i];
							break;
							case "M": m= color_sizes_arr[i];
							break;
							case "L": l= color_sizes_arr[i];
							break;
							case "XL": xl= color_sizes_arr[i];
							break;
							case "XXL": xxl= color_sizes_arr[i];
							break;
						}
						++i;
					}
					$("input[name='product_size']").prop("checked",false);
					$(".size").removeClass("size_not_available");
					$("input[name='product_size']").removeAttr("disabled","disabled");

					if(xs==null){
						$("label[for='xs']").addClass("size_not_available").attr("title","Not In Store");
						$("input[id='xs']").attr("disabled","disabled");
					}else{
						$("label[for='xs']").attr("title","extra small");
					}

					if(s==null){
						$("label[for='s']").addClass("size_not_available").attr("title","Not In Store");
						$("input[id='s']").attr("disabled","disabled");
					}else{
						$("label[for='s']").attr("title","small");
					}

					if(m==null){
						$("label[for='m']").addClass("size_not_available").attr("title","Not In Store");
						$("input[id='m']").attr("disabled","disabled");
					}else{
						$("label[for='m']").attr("title","medium");
					}

					if(l==null){
						$("label[for='l']").addClass("size_not_available").attr("title","Not In Store");
						$("input[id='l']").attr("disabled","disabled");
					}else{
						$("label[for='l']").attr("title","large");
					}

					if(xl==null){
						$("label[for='xl']").addClass("size_not_available").attr("title","Not In Store");
						$("input[id='xl']").attr("disabled","disabled");
					}else{
						$("label[for='xl']").attr("title","extra large");
					}

					if(xxl==null){
						$("label[for='xxl']").addClass("size_not_available").attr("title","Not In Store");
						$("input[id='xxl']").attr("disabled","disabled");
					}else{
						$("label[for='xxl']").attr("title","XXL");
					}

	      }
	    }
	    var parameters = 'product_color_name='+color_name+'&product_id='+product_id;
	    xhttp.open('POST','ajax_color_size_db_request.php',true);
	    xhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
			xhttp.setRequestHeader('Cache-Control','no-cache');  //Chrome on android
	    xhttp.send(parameters);


});
