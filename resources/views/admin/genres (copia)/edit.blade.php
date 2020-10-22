@extends('layouts.template')

@section('title', 'Editar Género')

@section('main')
  <h1>Editar Género: {{ $genre->name }}</h1>

  <form action="/admin/genres/{{ $genre->id }}" method="post">
    @method('put')
    
    @include('admin.genres._form')
  </form>
@endsection