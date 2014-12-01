jQuery(document).ready(function($) {

  $.material.init();

  //fade header on scroll
  (function(){
    var h1 = $('.main-header-image').find('h1');
    changeScroll();
    $(window).scroll(changeScroll);

    function changeScroll(){
      var scrollVar = $(window).scrollTop();
      h1.css({'margin-top': .7*scrollVar, 'opacity':( 150-scrollVar )/100 });
    }
  })();

  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });

  //add toggled class if on mobile

});