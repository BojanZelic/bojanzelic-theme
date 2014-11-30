jQuery(document).ready(function($) {

  $.material.init();

  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });

  //add toggled class if on mobile

});