@csrf

<div class="row">
  <div class="col-8">
    <div class="form-group">
      <label for="artist">Artista</label>
      <input type="text" name="artist" id="artist"
           class="form-control @error('artist') is-invalid @enderror"
           placeholder="Nombre del artista"
           required
           value="{{ old('artist', $record->artist) }}">
      @error('artist')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    <div class="form-group">
      <label for="title">Título</label>
      <input type="text" name="title" id="title"
           class="form-control @error('title') is-invalid @enderror"
           placeholder="Título de la canción"
           required
           value="{{ old('title', $record->title) }}">
      @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    <div class="form-group">
      <label for="title_mbid">ID Título MusicBrainz</label>
      <input type="text" name="title_mbid" id="title_mbid"
           class="form-control @error('title_mbid') is-invalid @enderror"
           placeholder="ID del título MusicBrainz (36 caracteres)"
           required minlength="36" maxlength="36"
           value="{{ old('title_mbid', $record->title_mbid) }}">
      @error('title_mbid')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    <div class="form-group">
      <label for="cover">URL de la portada</label>
      <input type="text" name="cover" id="cover"
           class="form-control @error('cover') is-invalid @enderror"
           placeholder="URL de la portada"
           value="{{ old('cover', $record->cover) }}">
      @error('cover')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    <div class="form-group">
      <label for="price">Precio</label>
      <input type="number" name="price" id="price"
           class="form-control @error('price') is-invalid @enderror"
           placeholder="Precio"
           required
           step="0.01"
           value="{{ old('price', $record->price) }}">
      @error('price')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    <div class="form-group">
      <label for="stock">Stock</label>
      <input type="number" name="stock" id="stock"
           class="form-control @error('stock') is-invalid @enderror"
           placeholder="Items de valores"
           required
           value="{{ old('stock', $record->stock) }}">
      @error('stock')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    <div class="form-group">
      <label for="genre_id">Género musical</label>
      <select name="genre_id" id="genre_id"
          class="custom-select @error('genre_id') is-invalid @enderror"
          required>
        <option value="">Seleccionar</option>
        @foreach($genres as $genre)
          <option value="{{ $genre->id }}"
            {{ (old('genre_id', $record->genre_id) ==  $genre->id ? 'selected' : '') }}>{{ ucfirst($genre->name) }}</option>
        @endforeach
      </select>
      @error('genre_id')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    <p>
      <button type="submit" id="submit" class="btn btn-success">Save record</button>
    </p>
  </div>
  <div class="col-4">
    <img src="/assets/vinyl.png" alt="cover" class="img-thumbnail" id="coverImage">
  </div>
</div>