@csrf

<div class="form-group">
  <label for="name">Nombre</label>
  <input type="text" name="name" id="name"
        class="form-control @error('name') is-invalid @enderror"
        placeholder="Nombre"
        minlength="3"
        required
        value="{{ old('name', $genre->name) }}">
  @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
    
  <button type="submit" class="btn btn-success">Guardar género</button>
</div>