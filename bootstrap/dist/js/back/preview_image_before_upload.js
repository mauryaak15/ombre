// Script to preview image befor uploading 
function previewImage(event) {
      //console.log(event.target.files.length);
          if(event.target.files.length > 5){
            $('#product_image').val('');
            alert("You can upload maximum 5 images");
          }else{
            var i = 1;
            var file = event.target.files[i-1];
            $(".img_preview_div").html(""); //To clear the previous images if input is given again
            $.each(event.target.files, function(i, file) {
              var img = document.createElement("img");
              var img_div = document.createElement("div");
              img_div.id = "img_div"+i;
              img.id = "image"+i;
              var reader = new FileReader();
              reader.onload = function () {
                  img.src = reader.result;
              }
              reader.readAsDataURL(file);
              $(".img_preview_div").append(img_div);
              $("#img_div"+i).append(img);
              $("#image"+i).addClass("img-rounded").css({"width":"100%","height":"100%"});
              $("#img_div"+i).css({"width":"70px","overflow":"hidden","float":"left","margin-right":"5px","margin-bottom":"10px"});
              if(i==4){
                $("#img_div"+i).css({"margin-right":"0px","clear":"both"});
              }
              ++i;
          });
          }
  }
