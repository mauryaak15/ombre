/*Variable declared in add_product.php
  Selecting options in select dropdown and disabling the fields
*/

if(new_exist!=''){
  if(new_exist=='exist'){
    $("input,textarea").not('input[type="file"],input[name="product_qty"],input[name="color"]').prop("readonly","readonly");
    $("select").not("select[name='size']").prop("disabled","disabled");
    $('select[name="category"] option[value='+cat_id+']').prop("selected","selected");
    $('select[name="brand"] option[value='+brand_id+']').prop("selected","selected");
    $("input[name='brand']").removeAttr("disabled").val(cat_id);  //Hidden field beacuse there is no readonly property for select and disabled select are not submitted
    $("input[name='category']").removeAttr("disabled").val(brand_id);
  }
  if(existing_size_color=='color'){
    $("input[name='color']").prop("readonly","readonly");
  }else if(existing_size_color=='size'){
    $("select[name='size'] option[value="+size+"]").prop("selected","selected");
    $("select[name='size']").prop("disabled","disabled");
    $("input[name='size']").removeAttr("disabled").val(size);
  }
}
