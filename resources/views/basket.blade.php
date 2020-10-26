@extends('layouts.template')

@section('title', 'Your Basket')

@section('main')
  <h1>Basket</h1>
  @if( Cart::getTotalQty() == 0)
    <div class="alert alert-primary">
      Your basket is empty.
    </div>
  @else
    @guest()
      <div class="alert alert-primary">
        You must be <a href="/login"><b>logged in</b></a> to checkout
      </div>
    @endguest
    <div class="table-responsive">
      <table class="table">
        <thead>
        <tr>
          <th class="width-50">Qty</th>
          <th class="width-80">Price</th>
          <th class="width-80"></th>
          <th>Record</th>
          <th class="width-120"></th>
        </tr>
        </thead>
        <tbody>
        @foreach(Cart::getRecords() as $record)
          <tr>
            <td>{{ $record['qty'] }}</td>
            <td>€&nbsp;{{ $record['price'] }}</td>
            <td>
              <img class="img-thumbnail cover" src="asset('/assets/vinyl.png')"
                data-src="{{ $record['cover'] }}"
                alt="{{ $record['title'] }}"
                style="width: 100px;">
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
            <p><a href="/basket/empty" class="btn btn-sm btn-outline-danger">Empty your basket</a></p>
          </td>
          <td>
            <p><b>Total</b>: €&nbsp;{{ Cart::getTotalPrice() }}</p>
            @auth()
              <p><a href="/user/checkout" class="btn btn-sm btn-outline-success">Checkout</a></p>
            @endauth
        </tr>
        </tbody>
      </table>
    </div>
  @endif

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