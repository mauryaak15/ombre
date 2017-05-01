/* Side navigation (included in header.php)*/

  var clicked = false;
  function openNav() {
        if(!clicked){
          $('#mySidenav').css({"width":"250px"});
          clicked = true;
          console.log(clicked+" if");
          return;
        }else{
          $('#mySidenav').css({"width":"0px"});
          clicked = false;
          console.log(clicked+" else");
          return;
        }
  }

  function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
      clicked = false;
      console.log(clicked+" close");
      return;
  }
