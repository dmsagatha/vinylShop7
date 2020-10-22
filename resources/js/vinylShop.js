let VinylShop = (function () {

  function hello() {
    console.log('El JavaScript de la Tienda de Vinilos funciona! 🙂');
  }

  /**
   * Show a Noty toast.
   * @param {object} obj
   * @param {string} [obj.type='success'] - background color ('success' | 'error '| 'info' | 'warning')
   * @param {string} [obj.text='...'] - text message
   */
  function toast(obj) {
    let toastObj = obj || {};   // if no object specified, create a new empty object
    new Noty({
        layout: 'topRight',
        timeout: 3000,
        modal: false,
        type: toastObj.type || 'success',   // if no type specified, use 'success'
        text: toastObj.text || '...',        // if no text specified, use '...'
    }).show();
  }

  // Devuelve todas las funciones que están disponibles públicamente. Ej: VinylShop.hello ()
  return {
    hello: hello,
    toast: toast,
  };


  $(function() {
    $('.btn.disabled').parent().css('cursor', 'not-allowed');
  }
})();

export default VinylShop;