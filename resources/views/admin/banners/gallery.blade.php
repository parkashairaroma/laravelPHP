{!! Form::open(['method' => 'post', 'id' => 'gallery-modal-form', 'enctype' => 'multipart/form-data']) !!}

<!-- Gallery Modal -->
<section class="gallery-modal">
    <div class="actionbar">
        <div class="error"><span class="message"></span></div>
        <div class="button"><span class="btn btn-success btn-file">Upload New Image {!! Form::file('gallery-modal-fileupload', ['id' => 'gallery-modal-fileupload']) !!}</span></div>
    </div>
    <div class="images">
      @foreach ($images as $image => $attr)
      <div class="image" data-hash="{{ $image }}" style="background: url(/{{ $path }}/{{ $image }}) 50%/110% no-repeat">
          <div class="actions">
              <div class="insertimage tip" title="Insert image into post"><i class="fa fa-check"></i></div>
              <div class="removeimage tip" title="Delete the image"><i class="fa fa-times"></i></div>
          </div>
      </div>
      @endforeach
    </div>
</section>

{!! Form::close() !!}

<script>

$(document).ready( function() {

  var path = '/images/banners/';
  var url = '/admin/api/banners/gallery';

  $('.tip').tooltipster({
    theme: 'tooltip-theme' 
  });

  {{-- 
    // insert image
  --}}
  $('.insertimage').click(function() {

    var file  =  path + $(this).closest('.image').data('hash');

    $('.carousel').css('background', 'url(' + file + ') 50%/110% no-repeat');
    $('#ban_image').val(file);

    $('#gallery').dialog('close')
  });

  {{--  
    // remove image
  --}}
  $('.removeimage').click(function() {
    
      if(! confirm('Delete the image?')) return false;

      var filename  =  $(this).closest('.image').data('hash');

      $.ajax({
        url: url + '/delete/' + filename,
        type: "GET",
      }).done(function( data ) {
        $('#gallery').load(url);
      });
  });

  {{-- 
    // upload new image 
  --}}
  $('input[type=file]').on('change', uploadFiles);

  function uploadFiles() {

    debugger;
      var data = new FormData($("#gallery-modal-form")[0]);

      $.ajax({
        url: url,
        type: "POST",
        data: data,
        dataType: 'json',
        enctype: 'multipart/form-data',
        processData: false,  
        contentType: false   
      }).done(function(response) {
        switch (response.status) {
          case 'fail':
            $('#gallery-modal-error').html('Failed to upload file');
          break;
          case 'success':
            $('#gallery').load(url);
          break;
        }
      });
  }
});
</script>