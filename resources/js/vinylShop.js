let VinylShop = (function () {

  function hello() {
      console.log('El JavaScript de la Tienda de Vinilos funciona! 🙂');
  }

  return {
      hello: hello    // publicly available as: VinylShop.hello()
  };
})();

export default VinylShop;