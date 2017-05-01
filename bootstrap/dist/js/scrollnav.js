/*Making top nav fixed and scrolling (included in header.php)*/
  window.onscroll = myfunction;
      function myfunction(){
          if(document.body.scrollTop > $(".scrollnav").position().top || document.documentElement.scrollTop > $(".scrollnav").position().top){
              //document.getElementById("fixednav").classList.add("navbar-fixed-top","padding-left-zero");

              $("#fixednav").addClass("navbar-fixed-top",100000000);
              $(".header + .container").css({"padding-top":"75px"});
              $(".header + .container-fluid").css({"padding-top":"75px"});
              $(".navbar-right").css({"margin-right":"8px"});

          }
          else{
              //document.getElementById("fixednav").classList.remove("navbar-fixed-top","padding-left-zero");

              $("#fixednav").removeClass("navbar-fixed-top",100000000);
              $(".header + .container").css({"padding-top":"0px"});
              $(".header + .container-fluid").css({"padding-top":"0px"});
              $(".navbar-right").css({"margin-right":"-8px"});

          }
      }



// Add slideDown animation to Bootstrap dropdown when expanding.
$('.dropdown').on('show.bs.dropdown', function() {
  $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
});

// Add slideUp animation to Bootstrap dropdown when collapsing.
$('.dropdown').on('hide.bs.dropdown', function(e){
        e.preventDefault();
        $(this).find('.dropdown-menu').first().stop(true, true).slideUp(400, function(){
            //On Complete, we reset all active dropdown classes and attributes
            //This fixes the visual bug associated with the open class being removed too fast
            $('.dropdown').removeClass('open');
            $('.dropdown').find('.dropdown-toggle').attr('aria-expanded','false');
        });
    });
