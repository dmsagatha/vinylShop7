@extends('layouts.template')

@section('title', 'Su canasta')

@section('main')
  <h1>Canasta</h1>

  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Artista - Albúm</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach($records as $record)
        <tr>
          <td>{{ $record->id }}</td>
          <td>{{ $record->artist }} - {{ $record->title }}</td>
          <td>
            <div class="btn-group btn-group-sm">
              <a href="/basket/add/{{ $record->id }}" class="btn btn-outline-success">+1</a>
              <a href="/basket/delete/{{ $record->id }}" class="btn btn-outline-danger">-1</a>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <a href="/basket/empty" class="btn btn-sm btn-outline-danger">Vaciar la canasta</a>

  <h2 class="mt-5">¿Qué hay dentro de mi canasta?</h2>
  <hr>
  <h4>Cart::getCart():</h4>
  <pre>{{ json_encode(Cart::getCart(), JSON_PRETTY_PRINT) }}</pre>
  <hr>
  <h4>Cart::getRecords():</h4>
  <pre>{{ json_encode(Cart::getRecords(), JSON_PRETTY_PRINT) }}</pre>
  <hr>
  <h4>Cart::getOneRecord(6):</h4>
  <pre>{{ json_encode(Cart::getOneRecord(6), JSON_PRETTY_PRINT) }}</pre>
  <hr>
  <p><b>Cart::getKeys()</b>: {{ json_encode(Cart::getKeys()) }}</p>
  <p><b>Cart::getTotalPrice()</b>: {{ json_encode(Cart::getTotalPrice()) }}</p>
  <p><b>Cart::getTotalQty()</b>: {{ json_encode(Cart::getTotalQty()) }}</p>
@endsection