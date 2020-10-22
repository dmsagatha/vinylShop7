@extends('layouts.template')

@section('title', 'Crear canción')

@section('main')
  <h1>Crear una nueva canción</h1>

  <form action="/admin/records" method="post">
      @include('admin.records._form')
  </form>
@endsection

@section('script_after')
  @include('admin.records.script')
@endsection