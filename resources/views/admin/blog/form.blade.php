 @extends('admin.layouts.control')

@section('content')

<section class="blogs page">

@if (isset($blog)) 
	{!! Form::model($blog, ['method' => 'post', 'id' => 'form']) !!}
@else
	{!! Form::open(['method' => 'post', 'id' => 'form']) !!} 
@endif

    <div class="actionbar">
        <div class="header"><h3>Blog Post</h3></div>
        <div class="button">
			<span class="btn-group pull-right">
			  <button type="button" class="btn btn-success btn-sm" id="save"><i class="fa fa-save"></i> Action</button>
			  <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    <i class="fa fa-caret-down"></i>
			    <span class="sr-only">Toggle Dropdown</span>
			  </button>
			  <ul class="dropdown-menu">

			  	@if (in_array('admin_user', $authRoles) && isset($blog) && in_array($blog->blg_approved, [blogStatus('draft'), blogStatus('submitted')]))
			    	<li><a href="#" id="save-approve">Approve</a></li>
			    @endif

			  	@if (in_array('admin_user', $authRoles) && isset($blog) && in_array($blog->blg_approved, [blogStatus('approved')]))
			    	<li><a href="#" id="save-approve">Apply Changes</a></li>
			    @endif

			    @if (! in_array('admin_user', $authRoles) && isset($blog) && !in_array($blog->blg_approved, [blogStatus('submitted'), blogStatus('approved')]))
			    	<li><a href="#" id="save-request">Submit for approval</a></li>
			    @endif

			    @if (isset($blog) && !in_array($blog->blg_approved, [blogStatus('draft')]))
			    	<li><a href="#" id="save-draft">Save as draft</a></li>
			    @endif

			    @if (isset($options['newPost']))
			  		@if (in_array('admin_user', $authRoles))
				    	<li><a href="#" id="save-approve">Approve</a></li>
				    @else
				    	<li><a href="#" id="save-request">Submit for approval</a></li>
				    	<li><a href="#" id="save-draft">Save as draft</a></li>
				    @endif
			    @endif
			    
			    <li><a href="#" id="save-discard">Discard changes</a></li>
			  </ul>
			</span>
  			<span class="status pull-right">
  				{!! Form::hidden('blg_status', 'false', null) !!}
	  			{!! Form::checkbox('blg_status', 'true', null, ['id' => 'blg_status']) !!}
  			</span>
  			<span class="approvals pull-right">
  			  	@if (isset($blog)) 
  			  		{!! Form::hidden('blg_approved', null, ['id' => 'blg_approved']) !!}
	  				<button class="btn btn-{{ $approvalColours[$blog->blg_approved] }} btn-sm" disabled>{{ $approvalNames[$blog->blg_approved] }}</button>
	  			@else
	  				{!! Form::hidden('blg_approved', 0, ['id' => 'blg_approved']) !!}
	  			@endif
  			</span>
			{!! Form::hidden('blg_hero', null, ['id' => 'blg_hero','class' => 'form-control']) !!}
        </div>
    </div>

	<div class="block-flex">
		<div class="block-hero">
	        <div class="hero {!! $errors->first('blg_hero', 'missing-field') !!}">
	        	@if (isset($blog) && Request::old('blg_hero') == null) 
	        		<div id="hero-placeholder" class="hero-placeholder" style="background: url('{{ $blog->blg_hero }}') 50%/125% no-repeat"></div>
	        	@elseif (Request::old('blg_hero'))  
	        		<div id="hero-placeholder" class="hero-placeholder" style="background: url('{{ Request::old('blg_hero') }}') 50%/125% no-repeat"></div>
	        	@else 
	        		<div id="hero-placeholder" class="hero-placeholder"></div>
	        	@endif
	        </div>
		</div>
		<div class="block-fields">
	        	<div class="block-row block-flex {!! $errors->first('blg_title', 'missing-field') !!}">
			    	<div class="block-2 field-label"><label>Title</label></div>
			    	<div class="block-10">
			    	{!! Form::text('blg_title', null, ['id' => 'blg_title', 'class' => 'form-control']) !!}
			    	{!! $errors->first('blg_title', '<span class="field-message">:message</span>') !!}
			    	</div>
			    </div>
	        	<div class="block-row block-flex {!! $errors->first('blg_slug', 'missing-field') !!}">
			    	<div class="block-2 field-label"><label>Slug</label></div>
			    	<div class="block-10"> 
			            <div class="input-group">
							<span class="input-group-addon tip" title="Slug Lock">
								@if (in_array('admin_user', $authRoles))
									{!! Form::hidden('blg_slug_locked', null) !!}
									{!! Form::checkbox('blg_slug_locked', 'true', null, ['id' => 'blg_slug_locked']) !!}
								@else 
									@if (isset($blog) && $blog->blg_slug_locked)
										<i class="fa fa-lock"></i>
									@else
										<i class="fa fa-unlock"></i>
									@endif
								@endif
							</span>
							@if (isset($blog) && $blog->blg_slug_locked)
								{!! Form::text('blg_slug', null, ['id' => 'blg_slug', 'readonly' => 'true', 'class' => 'form-control']) !!}
							@else
				            	{!! Form::text('blg_slug', null, ['id' => 'blg_slug', 'class' => 'form-control']) !!}
							@endif
			            </div>
			            {!! $errors->first('blg_slug', '<span class="field-message">:message</span>') !!}
        			</div>
			    </div>
	        	<div class="block-row block-flex {!! $errors->first('blg_date', 'missing-field') !!}">
			    	<div class="block-2 field-label"><label>Date</label></div>
			    	<div class="block-10">
						<div class="input-group date">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							{!! Form::text('blg_date', isset($options['defaultDate']) ? $options['defaultDate'] : null, ['id' => 'blg_date', 'class' => 'form-control']) !!}
						</div>
        			</div>
			    </div>
	        	<div class="block-row block-flex {!! $errors->first('blg_tags', 'missing-field') !!}">
			    	<div class="block-2 field-label"><label>Tags</label></div>
			    	<div class="block-10">
			    		{!! Form::select('blg_tags[]', $tagsList, null, ['multiple' => 'multiple', 'id' => 'blg_tags', 'style' => 'display: none', 'class' => 'form-control']) !!}
        				{!! $errors->first('blg_tags', '<span class="field-message">:message</span>') !!}
        			</div>
			    </div>
		</div>
	</div>
	<div class="block-flex">
		<div class="block-content">
		    <div class="content {!! $errors->first('blg_content', 'missing-field') !!}">
		  		<div id="block-container" class="block-container">
		  			@if (isset($blog) && Request::old('blg_content') == null) 
		  				{!! $blog->blg_content !!} 
		  			@else 
		  				{!! Request::old('blg_content') !!} 
		  			@endif
		  		</div>
		    </div>
		</div>
		<div class="block-buttons">
	   		<div id="blocks" class="blocks">
	   			<ul>
	  				<li><a class="btn btn-success add-block" data-block-type="paragraph">Paragraph</a></li>
	  				<li><a class="btn btn-success add-block" data-block-type="quote">Quote</a></li>
	  				<li><a class="btn btn-success add-block" data-block-type="video">Video</a></li>
	   				<li><a class="btn btn-success add-block" data-block-type="image">Image</a></li>
	  			</ul>
	  		</div>
		</div>
	</div>
    <div id="gallery-dialog"></div>
	<div id="video-dialog"></div>
	<div id="link-dialog"></div>

{{ Form::hidden('blg_content', null, ['id' => 'blg_content']) }}
{!! Form::close() !!}

</section>

{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/js/bootstrap-switch.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.4/js/bootstrap-select.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js') !!}

<script>

$(function() {

	if (! $('#blg_hero').val()) {
		var hero = '/images/static/blog-image-placeholder.jpg';
   		$('#blg_hero').val(hero);
    	$('#hero-placeholder').css('background', 'url(' + hero + ')  50%/125% no-repeat');
    }

	if (! $('#blg_content').val()) {
		addBlock('summary');
		addBlock('paragraph');
	}

    $('#blg_status').bootstrapToggle({
        size: 'small',
        on: '<i class="fa fa-check"></i> {{ $statusNames[true] }}',
        off: '<i class="fa fa-times"></i> {{ $statusNames[false] }}',
        onstyle: "success",
        offstyle: "default",
    });

    $('#blg_slug_locked').bootstrapToggle({
        size: 'mini',
        on: '<i class="fa fa-lock"></i>',
        off: '<i class="fa fa-unlock"></i>',
        onstyle: "success",
        offstyle: "default",
    })

	/**
	* display error dialog if fields empty
	*/
	if ($('.missing-field').length) {
		msgBox('Fields marked in red are incomplete.', false);
	}

    $( "#block-container" ).sortable({
    	handle: ".sort",
    	stop: function( event, ui ) {
			prepareContent();
		}
    });

	$(".input-group.date").datepicker({ 
		autoclose: true,
		format: 'yyyy-mm-dd'
	});

	$('select').selectpicker();

	$('.page')
    .on('change', '#blg_slug_locked', function () {
		$(this).parents('.input-group').find('#blg_slug').prop("readonly", $(this).is(":checked"));
	})
    .on('click', '#hero-placeholder', function () {
	   	openGalleryDialog('/admin/api/blog/gallery', $(this));
	})
	.on('keyup', '#blg_title', function() {
		if (! $('#blg_slug').attr('readonly')) {
			$('#blg_slug').val(slugGenerator($(this).val()));
		}
	})
	.on('click', '#save-approve', function() {
		prepareContent();
		$('#blg_approved').val('2');
		$('#form').submit();
	})
	.on('click', '#save-request', function() {
		prepareContent();
		$('#blg_approved').val('1');	
		$('#form').submit();
	})
	.on('click', '#save-draft', function () {
		prepareContent();
		$('#blg_approved').val('0');	
		$('#form').submit();
	})
	.on('click', '#save-discard', function() {
		if (! confirm('Are you sure?')) return false;
		location.href='/admin/blog';
	});


    $('#block-container')   
	.on('mouseup', '.text-block p', function() {
		closeElement('.text-actions');
		var html = '<span class="text-actions"><i class="fa fa-bold bold"></i><i class="fa fa-italic italic"></i><i class="fa fa-link link"></i></span>';
   		$(this).parent().append(html);
    })
    .on('click', '.delete', function () {
    	if (! confirm('Are you sure?')) return false;
    	$(this).parents('.block').remove();
    })
    .on('mousedown', '.image-block div', function () {
    	openGalleryDialog('/admin/api/blog/gallery', $(this));
    })
    .on('mousedown', '.video-block div', function () {
       openVideoDialog($(this));
    })
    .on('mousedown', '.link', function () {
		openLinkDialog();
    	return false; 
    })
    .on('paste', '.block p, .block footer', function (e) {
    	e.preventDefault();
    	var text = e.originalEvent.clipboardData.getData('text/plain').replace(/<[^>]+>/ig,'');
    	document.execCommand('insertHTML', false, text);
	}) 
    .on('keydown', 'p[contenteditable], footer[contenteditable]', function (e) {
	   	if (e.keyCode === 13) {
	    	document.execCommand('insertHTML', true, '<br /><br />');
	    	return false;
	    }
	})
    .on('click', 'blockquote > *', function () {
		$(this).attr('contenteditable', 'true');
		$(this).focus();
	})
    .on('mousedown', '.text-block p', function () {
		$('.text-block p').attr('contenteditable', 'false');
		$(this).attr('contenteditable', 'true');
		$(this).focus();
	})
	.on('mouseenter', '#quote, #paragraph, #image, #video', function () {
		var html = '<span class="block-actions"><i class="fa fa-sort sort"></i><i class="fa fa-times delete"></i></span>';
   		$(this).append(html);
    })
	.on('mouseenter', '#summary', function () {
		var html = '<span class="block-actions"><i class="fa fa-sort sort"></i></span>';
   		$(this).append(html);
    })
    .on('mouseleave', '.block', function () {
    	$('.block-actions').remove();
    })
    .on('mousedown', '.bold', function() {
	    document.execCommand('bold', false, null);
    })
    .on('mousedown', '.italic', function() {
	    document.execCommand('italic', false, null);
    });

	/**	
	* Insert block menu
	*/
	$('#blocks').on('click', '.add-block', function() {
		var blockType = $(this).data('block-type');
		addBlock(blockType);
	});
});


function addBlock(blockType) 
{
	var id = makeid();
	
	switch (blockType) {
	    case 'summary':
	        var html = '<div id="summary" class="block text-block">' +
	        		   '  <p>Summary</p>' +
	        		   '</div>';
	    break;
	    case 'quote':
	       	var html = '<div id="quote" class="block content-block">' +
	       			   '  <blockquote>' +
	       			   '    <p>Quote</p>' +
	       			   '    <footer>Signature</footer>' +
	       			   '  </blockquote>' +
	       			   '</div>';
	    break;
	    case 'paragraph':
	       	var html = '<div id="paragraph" class="block text-block">' +
	       			   '  <p>Paragraph</p>' +
	       			   '</div>';
	    break;
	    case 'video':
	       	var html = '<div id="video" class="block video-block">' +
	       			   '  <div id="' + id + '"><i class="fa fa-upload"></i> Click to insert video</div>' +
	       			   '</div>';
	    break;
	    case 'image':
	        var html = '<div id="image" class="block image-block">' +
	        		   '  <div id="' + id + '"><i class="fa fa-upload"></i> Click to insert image</div>' +
	        		   '</div>';
	    break;
	}
	$('#block-container').append(html);
	prepareContent();
}

function clearHtml() 
{
	/* clean unwanted attributes */
	$('.block-actions').remove();
	$('.text-actions').remove();
	$('#block-container p, #block-container footer').removeAttr('contenteditable');
	$('#block-container p, #block-container footer, #block-container span').removeAttr('style');
}

function prepareContent() 
{
	clearHtml();
	/* set content of textarea */
	var html = $.trim($('#block-container').html());
	$('#blg_content').val(html);
} 

function slugGenerator(value) 
{
	return value.toLowerCase().replace(/-+/g, '').replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
}

function openLinkDialog() 
{
	var src = prompt('Write the URL here','http:\/\/');

	if(src && src !='' && src != 'http://') {
		document.execCommand('createLink', false, src); 
	}
}

function openVideoDialog(obj) 
{
	var elem = '#video-dialog';

	var url = obj.find('iframe').attr('src');
	var id = obj.attr('id');

	if (! url) { url = '' };

	$(elem).data('id', id).dialog({     
		open: function () {

			$(elem).empty();
			$(elem).append('<h5>Please use URL only. <br /> i.e https://www.youtube.com/watch?v=xxxxxxx.</h5>');
			$(elem).append('<input type="text" id="httpurl" class="form-control" placeholder="Video Link" value="' + url + '">');
			$(elem).append('<button type="button" class="btn btn-success insert">Submit</button>');

			$(elem).on('click', '.insert', function () {

				var src = $('#httpurl').val();

				var youtubePattern = /(?:http?s?:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:v\/)?(?:watch\?v=)?(.+)/g;
				var vimeoPattern = /(?:http?s?:\/\/)?(?:www\.)?(?:vimeo\.com)\/?(.+)/g;

				if (src.match(youtubePattern)) {
					var embeddableSrc = src.replace(youtubePattern, 'https://www.youtube.com/embed/$1');
				}
				if (src.match(vimeoPattern)) {
					var embeddableSrc = src.replace(vimeoPattern, 'https://player.vimeo.com/video/$1');
				}

				if (embeddableSrc) {
					var html = '<div class="video-container">' +
						   	   '  <iframe src="' + embeddableSrc + '" width="500" height="281" frameborder="0" allowfullscreen></iframe>' +
						   	   '</div>';
					$('#' + id).html(html);
		     		$(elem).dialog('close');
				} else {
					msgBox('Please use URL only. <br /> i.e https://www.youtube.com/watch?v=xxxxxxx.', false);
				}
				
			});
		},  
		width: 400,
		height: 150,
		title: 'Video',
        resizable: false
	});
}

	
/* LOCAL context menu for converting blogs */
@if (in_array('manage_websites', $authRoles))

    $.contextMenu({
        selector: '#block-container p, #block-container blockquote', 
        callback: function(key, options) {
            action(key, $(this));
        },
        items: {
            "summary": {name: "Summary"},
           	"paragraph": {name: "Paragraph"},
           	"quote": {name: "Quote"},
            "video": {name: "Video"},
            "image": {name: "Image"},
        }
    });

    function action(key, obj) {

    	var id = makeid();

		switch (key) {
		    case 'summary':
		        var html = '<div id="summary" class="block text-block"><p>' + obj.html() + '</p></div>';
		        break;
		    case 'paragraph':
		       	var html = '<div id="paragraph" class="block text-block"><p>' + obj.html() + '</p></div>';
		        break;
	    	case 'quote':
	       		var html = '<div id="quote" class="block content-block"><blockquote><p>' + obj.find('p').text() + '&nbsp;</p><footer>' + obj.find('footer').html() + '&nbsp;</footer></blockquote></div>';
	        break;
		    case 'video':
		       	var html = '<div id="video" class="block video-block"><div id="' + id + '" class="video-container"><iframe src="' + obj.find('iframe').attr('src') + '" width="500" height="281" frameborder="0" allowfullscreen=""></iframe></div></div>';
		        break;
		    case 'image':
		        var html = '<div id="image" class="block image-block"><div id="' + id + '">' + obj.html() + '</div></div>';
		        break;
		}
        obj.replaceWith(html);
    };
@endif

</script>
@stop