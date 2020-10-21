@extends('layouts.template')

@section('title', 'Géneros Musicales')

@section('main')
  <h1>Géneros Musicales</h1>

  @include('shared.alert')

  <p>
    <a href="/admin/genres/create" class="btn btn-outline-success">
      <i class="fas fa-plus-circle mr-1"></i>Crear un nuevo género
    </a>
  </p>
  <div class="table-responsive">
    <table class="table">
      <thead>
      <tr>
        <th>#</th>
        <th>Género</th>
        <th>Discos por Géneros</th>
        <th>Acciones</th>
      </tr>
      </thead>
      <tbody>
      @foreach($genres as $genre)
        <tr>
          <td>{{ $genre->id }}</td>
          <td>{{ $genre->name }}</td>
          <td>{{ $genre->records_count }}</td>
          <td>
            <form action="/admin/genres/{{ $genre->id }}" method="post">
              @csrf
              @method('delete')

              <div class="btn-group btn-group-sm">
                <a href="/admin/genres/{{ $genre->id }}/edit" class="btn btn-outline-success"
                   data-toggle="tooltip"
                   title="Editar {{ $genre->name }}">
                  <i class="fas fa-edit"></i>
                </a>
                <button type="button" class="btn btn-outline-danger deleteGenre"
                    data-toggle="tooltip"
                    data-records="{{ $genre->records_count }}"
                    data-names="{{ $genre->name }}"
                    title="Eliminar {{ $genre->name }}">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </div>
            </form>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection

@section('script_after')
  <script>
    $(function () {
      $('.deleteGenre').click(function () {
        let records = $(this).data('records');
        let msg = `Eliminar este género musical`;
        if (records > 0) {
            msg += `\nEl ${records} disco de este género musical también será eliminado!`
        }
        if(confirm(msg)) {
            $(this).closest('form').submit();
        }
      })
    });
  </script>
@endsection