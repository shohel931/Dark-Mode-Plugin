jQuery(document).ready(function($){
  $('#dmms_toggle_button').click(function(){
    $('body').toggleClass('dark-mode');
    $('body').toggleClass('light-mode');
  });
});