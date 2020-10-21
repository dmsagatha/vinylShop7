@extends('layouts.template')

@section('title', 'Crear un nuevo género')

@section('main')
  <h1>Crear un género musical</h1>

  <form action="/admin/genres" method="post">
    @include('admin.genres._form')
  </form>
@endsection