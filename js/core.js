jQuery(document).ready(function($) {

  // Your JavaScript goes here

  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });

});