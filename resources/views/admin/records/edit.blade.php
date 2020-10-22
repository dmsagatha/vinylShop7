@extends('layouts.template')

@section('title', "Editar cancion: $record->artist - $record->title")

@section('main')
  <h1>Actualizar canción</h1>

  <form action="/admin/records/{{ $record->id }}" method="post">
    @method('put')

    @include('admin.records._form')
  </form>
@endsection

@section('script_after')
  @include('admin.records.script')
@endsection