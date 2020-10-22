<script>
  $(function () {
    let album_id, coverUrl;
    // Disable the submit button
    $('#submit').attr('disabled', true);
  
    // One every change inside the title_mbid or cover field, check if a valid cover image can be found
    $('#title_mbid, #cover').change(function () {
      album_id = $('#title_mbid').val();
      coverUrl = $('#cover').val();
      // If cover field is empty and the length of Title MusicBrainz ID is 36 characters
      if ($('#cover').val() == '' && album_id.length == 36) {
        // Update coverUrl
        coverUrl = `https://coverartarchive.org/release/${album_id}/front-250.jpg`;
        updateImage('MusicBrainz ID');
      }
      // If cover field is not empty
      if ($('#cover').val() != '') {
        updateImage('Cover URL');
      }
    });

    // Trigger change event (such that the search for a valid cover image automatically starts on edit page)
    $('#title_mbid').change();

    function updateImage(from) {
      $.get(coverUrl)
        .done(function () {
          // coverUrl exists: replace it and enable the submit button
          $('#coverImage').attr('src', coverUrl);
          // Enable submit button
          $('#submit').attr('disabled', false);
          // Show toast
          VinylShop.toast({
            type: 'success',
            text: `Portada encontrada vía ${from}!`
          });
        })
        .fail(function () {
          // coverUrl doesn't exist: set the cover back to vinyl.png and disable the submit button
          $('#coverImage').attr('src', '/assets/vinyl.png');
          // Disable submit button
          $('#submit').attr('disabled', true);
          // Show toast
          VinylShop.toast({
            type: 'error',
            text: `¡No se encontró ninguna portada a través de ${from}! <br> Utilice Google y agregue una URL válida (local) en el campo URL de portada.`
          });
        });
    }
  });
</script>