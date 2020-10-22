<!-- Modal -->
<div class="modal fade" id="modal-genre" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">modal-genre-title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          @method('')
          @csrf

          <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name"
                 class="form-control"
                 placeholder="Nombre"
                 minlength="3"
                 required
                 value="">
            <div class="invalid-feedback"></div>
          </div>
          <button type="submit" class="btn btn-success">Guardar género</button>
        </form>
      </div>
    </div>
  </div>
</div>