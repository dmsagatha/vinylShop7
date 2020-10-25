@extends('layouts.template')

@section('title', 'Su compras')

@section('main')
  <h1>Carro de Compras</h1>

  @if( Cart::getTotalQty() == 0)
    <div class="alert alert-primary">
      Su carro esta vacío.
    </div>
  @else
    @guest()
      <div class="alert alert-primary">
        Usted debe haber iniciado <a href="/login"><b>sesión</b></a> para pagar.
      </div>
    @endguest
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th class="width-50">Qty</th>
            <th class="width-80">Price</th>
            <th class="width-80"></th>
            <th>Canción</th>
            <th class="width-120"></th>
          </tr>
        </thead>
        <tbody>
          @foreach(Cart::getRecords() as $record)
            <tr>
              <td>{{ $record['qty'] }}</td>
              <td>€&nbsp;{{ $record['price'] }}</td>
              <td>
                <img class="img-thumbnail cover" src="{{ asset('/assets/vinyl.png') }}"
                    data-src="{{ $record['cover'] }}"
                    alt="{{ $record['title'] }}"
                    style="width: 100px">
              </td>
              <td>
                {{ $record['artist'] . ' - ' . $record['title']  }}
              </td>
              <td>
                <div class="btn-group btn-group-sm">
                  <a href="/basket/delete/{{ $record['id'] }}" class="btn btn-outline-secondary">-1</a>
                  <a href="/basket/add/{{ $record['id'] }}" class="btn btn-outline-secondary">+1</a>
                </div>
              </td>
            </tr>
          @endforeach
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>
              <p><a href="/basket/empty" class="btn btn-sm btn-outline-danger">Vaciar su carro de compras</a></p>
            </td>
            <td>
              <p><b>Total</b>: €&nbsp;{{ Cart::getTotalPrice() }}</p>
              @auth()
                <p>
                  <a href="/user/checkout" class="btn btn-sm btn-outline-success">Pagar</a>
                </p>
              @endauth
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  @endif

{{--   <table class="table">
    <thead>
    <tr>
      <th>#</th>
      <th>Artist - Album</th>
      <th>Action</th>
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
  
  <a href="/basket/empty" class="btn btn-sm btn-outline-danger">Empty basket</a>
 --}}
  <h2 class="mt-5">What's inside my basket?</h2>
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

@section('script_after')
  <script>
    $(function () {
        $('.cover').each(function () {
          $(this).attr('src', $(this).data('src'));
        });
        $('tbody tr:not(:last-child) td').addClass('align-middle');
    });
  </script>
@endsection