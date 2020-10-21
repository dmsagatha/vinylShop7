@extends('layouts.template')

@section('main')
  <h1>The Vinyl Shop</h1>
  <p>
    Bienvenido al sitio web de The Vinyl Shop, una gran tienda en línea con muchos discos de vinilo (clásicos).
  </p>
  
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{{ __('Dashboard') }}</div>

          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif

            {{ __('You are logged in!') }}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection