@extends('layouts.template')

@section('title', 'Shop')

@section('main')
  <h1>Tienda</h1>
  
  <form method="get" action="/shop" id="searchForm">
    <div class="row">
      <div class="col-sm-6 mb-2">
        <input type="text" class="form-control" name="artist" id="artist"
           value="" placeholder="Filtro para Artista o Canción">
      </div>
      <div class="col-sm-4 mb-2">
        <select class="form-control" name="genre_id" id="genre_id">
          <option value="%">Géneros musicales</option>
          @foreach($genres as $genre)
            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-sm-2 mb-2">
        <button type="submit" class="btn btn-success btn-block">Buscar. . .</button>
      </div>
    </div>
  </form>
  <hr>

  {{ $records->links() }}

  <div class="row">
    @foreach($records as $record)
      <div class="col-sm-6 col-md-4 col-lg-3 mb-3">
        <div class="card">
          <img class="card-img-top" src="{{ $record->cover }}" alt="{{ $record->artist }} - {{ $record->title }}">

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