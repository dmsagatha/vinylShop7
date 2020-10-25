@extends('layouts.template')

@section('title', 'Tienda')

@section('main')
  <h1>Tienda</h1>
  
  <form method="get" action="/shop" id="searchForm">
    <div class="row">
      <div class="col-sm-6 mb-2">
        <input type="text" class="form-control" name="artist" id="artist"
           value="{{ request()->artist }}" placeholder="Filtro para Artista o Canción">
      </div>
      <div class="col-sm-4 mb-2">
        <select class="form-control" name="genre_id" id="genre_id">
          <option value="%">Géneros musicales</option>
          @foreach($genres as $genre)
            <option value="{{ $genre->id }}" 
              {{ (request()->genre_id ==  $genre->id ? 'selected' : '') }}
            >
              {{ $genre->name }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-sm-2 mb-2">
        <button type="submit" class="btn btn-success btn-block">Buscar. . .</button>
      </div>
    </div>
  </form>
  <hr>

  @if ($records->count() == 0)
    <div class="alert alert-danger alert-dismissible fade show">
      No existe ningún artista o álbum de <b>'{{ request()->artist }}'</b> para este género
      <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
      </button>
    </div>
  @endif

  {{ $records->links() }}

  <div class="row">
    @foreach($records as $record)
      <div class="col-sm-6 col-md-4 col-lg-3 mb-3">
        <div class="card h-100" data-id="{{ $record->id }}">
          <img class="card-img-top" src="{{ asset('/assets/vinyl.png') }}" data-src="{{ $record->cover }}" alt="{{ $record->artist }} - {{ $record->title }}">

          <div class="card-body">
            <h5 class="card-title">{{ $record->artist }}</h5>
            <p class="card-text">{{ $record->title }}</p>
            <a href="shop/{{ $record->id }}" class="btn btn-outline-info btn-sm btn-block">Mostrar Detalle</a>
          </div>

          <div class="card-footer d-flex justify-content-between">
            <p>{{ $record->genre->name }}</p>
            <p>
              € {{ number_format($record->price,2) }}
              <span class="ml-3 badge badge-success">{{ $record->stock }}</span>
            </p>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  
  {{ $records->links() }}
@endsection

@section('css_after')
  <style>
    .card {
      cursor: pointer;
    }
    .card .btn, form .btn {
      display: none;
    }
  </style>
@endsection

@section('script_after')
  <script>
    $(function () {
      // Obtener el ID de registro y redirigir a la página de detalles
      $('.card').click(function () {
          record_id = $(this).data('id');
          $(location).attr('href', `/shop/${record_id}`); //OR $(location).attr('href', '/shop/' + record_id);
      });
      // Reemplazar vinyl.png con la portada real
      $('.card img').each(function () {
          $(this).attr('src', $(this).data('src'));
      });
      // Adicionar sombra a la tarjeta al pasar el puntero
      $('.card').hover(function () {
          $(this).addClass('shadow');
      }, function () {
          $(this).removeClass('shadow');
      });
      // Enviar formulario al salir del campo de texto 'artist'
      $('#artist').blur(function () {
          $('#searchForm').submit();
      });
      // Enviar formulario al cambar la lista desplegable 'genre_id'
      $('#genre_id').change(function () {
          $('#searchForm').submit();
      });
    })
  </script>
@endsection