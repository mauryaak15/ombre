/*Displaying color of product according to availability (included in producct_info.php) */

var i = 0;
var color_length = 0;
color_length = color_name.length;
while(i<=color_length){
	$('label[for="'+color_name[i]+'"]').css({"background-color":""+color_name[i]+"","cursor":"pointer"});
	++i;
}
i=0;
while(i<=color_length){
  if(color_qty[i]==0){
    $('label[for="'+color_name[i]+'"]').attr("title","Not In Store").addClass("not-available").css({"cursor":"default"});
    $('#'+color_name[i]).attr("disabled","disabled");
  }
  ++i;
}
