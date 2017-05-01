//ALl product slider on index page

$(document).ready(function() {

  var owl = $("#product-slider");

  owl.owlCarousel({
      items : 4, //4 items above 1000px browser width
      itemsDesktop : [1000,4], //4 items between 1000px and 901px
      itemsDesktopSmall : [900,3], // betweem 900px and 601px
      itemsTablet: [600,2], //2 items between 600 and 0
      itemsMobile : false, // itemsMobile disabled - inherit from itemsTablet option
      navigation : true
  });
});
