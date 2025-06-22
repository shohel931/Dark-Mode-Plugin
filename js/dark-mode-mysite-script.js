jQuery(document).ready(function($){
  let currentStyle = dmms_data.default_style;

  // Console log for debug
  console.log('Current Default Style:', currentStyle);

  // Load dark mode based on localStorage or default style
  if (localStorage.getItem('dark-mode') === 'enabled') {
    $('body').addClass('dark-mode');
  } else if (localStorage.getItem('dark-mode') === null && currentStyle === 'dark') {
    $('body').addClass('dark-mode');
  }

  // Toggle on button click
  $('#dmms-toggle-button').click(function(){
    $('body').toggleClass('dark-mode');
    if ($('body').hasClass('dark-mode')) {
      localStorage.setItem('dark-mode', 'enabled');
    } else {
      localStorage.setItem('dark-mode', 'disabled');
    }
  });
});
