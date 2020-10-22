@extends('layouts.template')

@section('title', 'Géneros Musicales')

@section('main')
  <h1>Géneros Musicales</h1>

  <p>
    <a href="#!" class="btn btn-outline-success" id="btn-create">
      <i class="fas fa-plus-circle mr-1"></i>Crear un nuevo género
    </a>
  </p>

  <div class="table-responsive">
    <table class="table table-hover">
      <thead class="thead-dark">
        <tr>
          <th>#</th>
          <th>Género</th>
          <th>Discos por Géneros</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>     
      </tbody>
    </table>
  </div>

  @include('admin.genres.modal')
@endsection

@section('script_after')
  <script>
    $(function () {
      loadTable();

      $('tbody').on('click', '.btn-delete', function () {
        // Get data attributes from td tag
        let id = $(this).closest('td').data('id');
        let name = $(this).closest('td').data('name');
        let records = $(this).closest('td').data('records');
        // Set some values for Noty
        let text = `<p>Eliminar el género musical <b>${name}</b>?</p>`;
        let type = 'warning';
        let btnText = 'Eliminar género';
        let btnClass = 'btn-success';
        // If records not 0, overwrite values for Noty
        if (records > 0) {
          text += `<p>ATENCIÓN: Va a eliminar los ${records} registros al mismo tiempo!</p>`;
          btnText = `Eliminar género + ${records} registros`;
          btnClass = 'btn-danger';
          type = 'error';
        }
        // Show Noty
        let modal = new Noty({
          type: type,
          text: text,
          buttons: [
            Noty.button(btnText, `btn ${btnClass}`, function () {
              // Eliminar género y cerrar el modal
              deleteGenre(id);
              modal.close();
            }),
            Noty.button('Cancelar', 'btn btn-secondary ml-2', function () {
              modal.close();
            })
          ]
        }).show();
      });

      $('#btn-create').click(function () {
        // Update the modal
        $('.modal-title').text(`New genre`);
        $('form').attr('action', `/admin/genres`);
        $('#name').val('');
        $('input[name="_method"]').val('post');
        // Show the modal
        $('#modal-genre').modal('show');
      });

      $('tbody').on('click', '.btn-edit', function () {
          // Get data attributes from td tag
          let id = $(this).closest('td').data('id');
          let name = $(this).closest('td').data('name');
          // Actulizar el modal
          $('.modal-title').text(`Editar ${name}`);
          $('form').attr('action', `/admin/genres/${id}`);
          $('#name').val(name);
          $('input[name="_method"]').val('put');
          // Mostrar el modal
          $('#modal-genre').modal('show');
      });

      $('#modal-genre form').submit(function (e) {
          // Don't submit the form
          e.preventDefault();
          // Get the action property (the URL to submit)
          let action = $(this).attr('action');
          // Serialize the form and send it as a parameter with the post
          let pars = $(this).serialize();
          console.log(pars);
          // Post the data to the URL
          $.post(action, pars, 'json')
              .done(function (data) {
                  console.log(data);
                  // show success message
                  VinylShop.toast({
                      type: data.type,
                      text: data.text
                  });
                  // Hide the modal
                  $('#modal-genre').modal('hide');
                  // Rebuild the table
                  loadTable();
              })
              .fail(function (e) {
                  console.log('error', e);
                  // e.responseJSON.errors contains an array of all the validation errors
                  console.log('error message', e.responseJSON.errors);
                  // Loop over the e.responseJSON.errors array and create an ul list with all the error messages
                  let msg = '<ul>';
                  $.each(e.responseJSON.errors, function (key, value) {
                      msg += `<li>${value}</li>`;
                  });
                  msg += '</ul>';
                  // show the errors
                  VinylShop.toast({
                      type: data.type,
                      text: data.text
                  });
          });
      });
    });

    // Eliminar un género musical
    function deleteGenre(id) {
      // Eliminar el género de la base de datos
      let pars = {
          '_token': '{{ csrf_token() }}',
          '_method': 'delete'
      };
      $.post(`/admin/genres/${id}`, pars, 'json')
        .done(function (data) {
            console.log('data', data);

            // Mostrar toast
            VinylShop.toast({
                type: data.type,    // Opcional porque por defecto el tipo es 'success'
                text: data.text
            });
            /* new Noty({
                type: data.type,
                text: data.text,
                // Sobrescribir la configuración predeterminada de Noty
                layout: 'topRight',
                timeout: 3000,
                modal: false,
            }).show(); */
            // Reconstruir la tabla
            loadTable();
        })
        .fail(function (e) {
            console.log('error', e);
        });
    }

    // Cargando los géneros musicales con AJAX
    function loadTable() {
      $.getJSON('/admin/genres/qryGenres')
        .done(function (data) {
          console.log('data', data);
          // Limpiar tbody tag
          $('tbody').empty();
          // Recorrer cada elemento de la matriz
          $.each(data, function (key, value) {
            let tr = `<tr>
                 <td>${value.id}</td>
                 <td>${value.name}</td>
                 <td>${value.records_count}</td>
                 <td data-id="${value.id}"
                   data-records="${value.records_count}"
                   data-name="${value.name}">
                  <div class="btn-group btn-group-sm">
                    <a href="#!" class="btn btn-outline-success btn-edit">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="#!" class="btn btn-outline-danger btn-delete">
                      <i class="fas fa-trash"></i>
                    </a>
                  </div>
                 </td>
               </tr>`;
            // Agregar fila a tbody
            $('tbody').append(tr);
          });
        })
        .fail(function (e) {
          console.log('error', e);
        })
    }
  </script>
@endsection