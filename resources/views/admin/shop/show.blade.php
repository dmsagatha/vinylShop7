@extends('layouts.template')

@section('title', 'Record')

@section('main')
  <h1>Artist - Record</h1>
  
  <div class="row">
    <div class="col-sm-4 text-center">
      <img class="img-thumbnail" id="cover" src="/assets/vinyl.png" data-src="" alt="">
      <p>
        <a href="#!" class="btn btn-sm  btn-block mt-3">
          <i class="fas fa-cart-plus mr-3"></i>Add to cart
        </a>
      </p>
      <p class="text-left">Genre: <br>
        Stock: <br>
        Price: € </p>
    </div>
    <div class="col-sm-8">
      <table class="table table-sm">
        <thead>
        <tr>
          <th>#</th>
          <th>Track</th>
          <th>Length</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
@endsection