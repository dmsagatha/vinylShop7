@extends('layouts.template')

@section('main')
  <h3 class="text-center my-5">404 | <span class="text-black-50">Página no encontrada</span></h3>
  <p class="text-center my-5">
    <a href="/" class="btn btn-outline-secondary btn-sm mr-2">
      <i class="fas fa-home mr-1"></i>Inicio
    </a>
    <a href="#!" class="btn btn-outline-secondary btn-sm ml-2" id="back">
      <i class="fas fa-undo mr-1"></i>Volver
    </a>
  </p>
@endsection

@section('script_after')
  <script>
    // Go back to the previous page
    $('#back').click(function () {
       window.history.back();
    });
    
    // Remove the right navigation
    $('nav .ml-auto').hide();
  </script>
@endsection