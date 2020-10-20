@extends('layouts.template')

@section('main')
  <h1>Contacto</h1>

  @include('shared.alert')

  {{-- @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif --}}

  @if (!session()->has('success'))
    <form action="/contact-us" method="post">
      @csrf
      
      <div class="form-group">
        <label for="name">Nombre</label>
        <input type="text" name="name" id="name" 
            class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}"
            placeholder="Su nombre"
            required
            value="{{ old('name') }}">
        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
      </div>
      <div class="form-group">
        <label for="email">Correo electrónico</label>
        <input type="email" name="email" id="email" 
            class="form-control {{ $errors->first('email') ? 'is-invalid' : '' }}"
            placeholder="Su correo electrónico"
            required
            value="{{ old('email') }}">
        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
      </div>
      <div class="form-group">
        <label for="message">Mensaje</label>
        <textarea name="message" id="message" rows="5" 
            class="form-control {{ $errors->first('message') ? 'is-invalid' : '' }}"
            placeholder="Su mensaje"
            required
            minlength="10">{{ old('message') }}</textarea>
        <div class="invalid-feedback">{{ $errors->first('message') }}</div>
      </div>

      <button type="submit" class="btn btn-success">Enviar mensaje</button>
    </form>
  @endif
@endsection