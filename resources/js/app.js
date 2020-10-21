require('./bootstrap');

// Make 'VinylShop' accessible inside the HTML pages
import VinylShop from "./vinylShop";
window.VinylShop = VinylShop;

// Run the hello() function
VinylShop.hello();

$(function(){
  $('[required]').each(function () {
    $(this).closest('.form-group')
            .find('label')
            .append('<sup class="text-danger mx-1">*</sup>');
  });

  // Dar a los íconos de Font Awesome un ancho fijo y un margen derecho
  $('nav i.fas').addClass('fa-fw mr-1');

  // Habilitar la información sobre herramientas de Bootstrap
  $('body').tooltip({
      selector: '[data-toggle="tooltip"]',
      html : true,
  }).on('click', '[data-toggle="tooltip"]', function () {
      // hide tooltip when you click on it
      $(this).tooltip('hide');
  });
});