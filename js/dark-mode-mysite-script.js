jQuery(document).ready(function($){
  $('#dmms_toggle_button').click(function(){
    $('body').toggleClass('dark-mode');
    $('body').toggleClass('light-mode');
  });
});


document.addEventListener('DOMContentLoaded', function(){
  const toggleBtn = document.getElementById('dark-mode-toggle');
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