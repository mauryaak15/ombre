/*Setting user menu to log_in_or_out (included in footer.php)*/
if(user_logged_in==1){
  $("#log_in_menu").addClass("hide");
}else{
  $("#log_in_menu_show").addClass("hide");
}
