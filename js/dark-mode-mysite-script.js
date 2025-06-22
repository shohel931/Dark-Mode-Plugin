jQuery(document).ready(function($){
  $('#dmms_toggle_button').click(function(){
    $('body').toggleClass('dark-mode');
    $('body').toggleClass('light-mode');
    $('body').toggleClass('dmms-style1 dmms-style2 dmms-style3');
  });
});


document.addEventListener('DOMContentLoaded', function(){
  const toggleBtn = document.getElementById('#dmms-toggle-button');
  if (!toggleBtn) return;

  if (localStorage.getItem('dark-mode') === 'enabled') {
    document.body.classList.add('dark-mode');
  }


  toggleBtn.addEventListener('click', function(){
    document.body.classList.toggle('dark-mode');
    if (document.body.classList.contains('dark-mode')) {
      localStorage.setItem('dark-mode', 'enabled');
    } else {
      localStorage.setItem('dark-mode', 'disabled');
    }
  });
});


