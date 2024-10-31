jQuery(document).ready( function($)
{
  $('.available-theme').hover(
    function(){
      $(this).children('p.description').css({'max-height':'800px'});
      $(this).children('p:last').css({'max-height':'800px'});
    },
    function(){
      $(this).children('p.description').css({'max-height':'48px'});
      $(this).children('p:last').css({'max-height':'16px'});
  });

});