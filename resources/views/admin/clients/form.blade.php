@extends('admin.layouts.control')

@section('content')

<section class="clients page">

@if (isset($client)) 
    {!! Form::model($client, ['method' => 'post', 'id' => 'form']) !!}
@else
    {!! Form::open(['method' => 'post', 'id' => 'form']) !!} 
@endif

    <div class="actionbar">
        <div class="header">
            <h3>Create/Edit Client</h3></div>
        <div class="button">
            <div class="btn-group pull-right">
                <button type="button" class="btn btn-success btn-sm" id="save"><i class="fa fa-save"></i> Save</button>
                <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-caret-down"></i>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="#" id="save-publish">Save and publish</a></li>
                    <li><a href="#" id="save-draft">Save as draft</a></li>
                    <li><a href="#" id="discard">Discard changes</a></li>
                </ul>
            </div>
            <span class="status pull-right">
                {!! Form::hidden('clipagweb_is_enabled', 'false', null) !!}
                {!! Form::checkbox('clipagweb_is_enabled', 'true', null, ['id' => 'clipagweb_is_enabled']) !!}
            </span>
        	{!!Form::hidden('clt_cli_hero', null, ['id' => 'clt_cli_hero']) !!}
        </div>
    </div>
    <div class="block-hero">
        <div class="hero {!! $errors->first('clt_cli_hero', 'missing-field') !!}">
            @if (isset($client) && Request::old('clt_cli_hero') == null)
            <div id="hero-placeholder" class="hero-placeholder" style="background: url('{{ $client->clt_cli_hero }}') 50%/60% no-repeat"></div>
            @elseif (Request::old('clt_cli_hero'))
            <div id="hero-placeholder" class="hero-placeholder" style="background: url('{{ Request::old('clt_cli_hero') }}') 50%/60% no-repeat"></div>
            @else
            <div id="hero-placeholder" class="hero-placeholder"></div>
            @endif
        </div>
    </div>
    <br />
    <div class="block-fields">
        <div class="block-row block-flex {!! $errors->first('cli_name', 'missing-field') !!}">
            <div class="name block-2">
                <label>Name</label>
            </div>
            <div class="value block-10">{!! Form::text('cli_name', null, ['id' => 'cli_name', 'class' => 'form-control']) !!}</div>
        </div>
        <div class="block-row block-flex {!!$errors->first('cli_slug', 'missing-field') !!}">
            <div class="name block-2">
                <label>Slug</label>
            </div>
            <div class="value block-10">{!!Form::text('cli_slug', null, ['id' => 'cli_slug', 'class' => 'form-control']) !!}</div>
        </div>
        <div class="block-row block-flex {!!$errors->first('clt_cli_title', 'missing-field') !!}">
            <div class="name block-2">
                <label>Title</label>
            </div>
            <div class="value block-10">{!!Form::text('clt_cli_title', null, ['id' => 'clt_cli_title', 'class' => 'form-control']) !!}</div>
        </div>
        <div class="block-row block-flex">
            <div class="name block-2">
                <label>Tag_Description</label>
            </div>
            <div class="value block-10">{!!Form::text('clt_cli_tagdescription', null, ['id' => 'clt_cli_tagdescription', 'class' => 'form-control']) !!}</div>
        </div>
        <div class="block-row block-flex">
            <div class="name block-2">
                <label>Hero Image</label> 
<i class="fa fa-info-circle" rel="tooltip" title="This image appears on clients page on the top" id="blah"></i>
            </div>
            <div class="value block-10">
                <a id="hero-gallery">Gallery</a>
            </div>
        </div>

        <div class="block-row block-flex">
            <div class="name block-2">
                <label>Feature Image</label>  
                <i class="fa fa-info-circle" rel="tooltip" title="This image appears on page where we show clients list " id="blah"></i>
            </div>
            <div class="value block-10">
                <div class="block-row block-flex">
                    <div class="name block-2">
                        <a id="feature-gallery">Gallery</a>
                    </div>
                    <div class="value block-10">
                        {!!Form::hidden('clt_cli_feature', null, ['id' => 'clt_cli_feature']) !!}
                        <div class="block-hero">
                            <div class="hero">
                                @if (isset($client) && $client->clt_cli_feature)
                                <div id="feature-placeholder" class="hero-placeholder" style="background: url('{{ $client->clt_cli_feature }}') 50%/30% no-repeat"></div>
                                @else
                                <div id="feature-placeholder" class="hero-placeholder" style="background: url('') 50%/30% no-repeat"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="block-row block-flex {!! $errors->first('clt_cli_header', 'missing-field') !!}">
            <div class="name block-2">
                <label>Hero Header</label>
            </div>
            <div class="value block-10">{!! Form::text('clt_cli_header', null, ['id' => 'clt_cli_header', 'class' => 'form-control']) !!}</div>
        </div>
        <div class="block-row block-flex {!! $errors->first('clt_cli_text', 'missing-field') !!}">
            <div class="name block-2">
                <label>Hero Text</label>
            </div>
            <div class="value block-10">{!! Form::text('clt_cli_text', null, ['id' => 'clt_cli_text', 'class' => 'form-control']) !!}</div>
        </div>
        <div class="block-row block-flex {!! $errors->first('clt_cli_scentheader', 'missing-field') !!}">
            <div class="name block-2">
                <label>Scent Header</label>
            </div>
            <div class="value block-10">{!! Form::text('clt_cli_scentheader', null, ['id' => 'clt_cli_scentheader', 'class' => 'form-control']) !!}</div>
        </div>
        <div class="block-row block-flex {!! $errors->first('clt_cli_scenttext', 'missing-field') !!}">
            <div class="name block-2">
                <label>Scent Text</label>
            </div>
            <div class="value block-10 block-content">
                <div class="content {!!$errors->first('clt_cli_scenttext', 'missing-field') !!}">
                    <div id="block-container" class="block-container ui-sortable">
                        <div id="clt_cli_scenttextparagraph" name="clt_cli_scenttextparagraph" class="block text-block">
                            @if (isset($client) && $client->clt_cli_scenttext)
                                {!! $client->clt_cli_scenttext !!}
                            @else
                                <p></p>
                            @endif
                        </div>
                    </div>
                </div>
                </div>
        </div>

        <div class="block-row block-flex {!! $errors->first('clt_cli_video', 'missing-field') !!}">
            <div class="name block-2">
                <label>Video URL <i class="fa fa-info-circle" rel="tooltip" title="Please use URL only. i.e https://www.youtube.com/watch?v=xxxxxxx." id="blah"></i></label>
            </div>
            <div class="value block-10">{!! Form::text('clt_cli_video', null, ['id' => 'clt_cli_video', 'class' => 'form-control']) !!}</div>
        </div>

        <div class="block-row block-flex">
            <div class="name block-2">
                <label>Banner</label>
            </div>
            <div class="value block-10">
                <div class="block-row block-flex">
                    <div class="name block-2"><a id="banner-gallery">Gallery</a></div>
                    <div class="value block-10">
               {!!Form::hidden('clt_cli_banner', null, ['id' => 'clt_cli_banner']) !!}
                <div class="block-hero">
                    <div class="hero">
                        @if (isset($client) && $client->clt_cli_banner)
                        <div id="banner-placeholder" class="hero-placeholder" style="background: url('{{ $client->clt_cli_banner }}') 50%/30% no-repeat"></div>
                        @else
                        <div id="banner-placeholder" class="hero-placeholder" style="background: url('') 50%/30% no-repeat"></div>
                        @endif
                    </div>
                </div></div>
            </div>
                    
                    
                </div>
        </div>

        <div class="block-row block-flex {!! $errors->first('clt_cli_textinner', 'missing-field') !!}">
            <div class="name block-2">
                <label>Inner Text</label>
            </div>
            <div class="value block-10 block-content">
                <div class="content {!!$errors->first('clt_cli_textinner', 'missing-field') !!}">
                    <div id="block-container2" class="block-container ui-sortable">
                        <div id="clt_cli_textinnerparagraph" name="clt_cli_textinnerparagraph" class="block text-block">
                            @if (isset($client) && $client->clt_cli_textinner)
                                {!! $client->clt_cli_textinner !!}
                            @else
                            <p></p>
                            @endif
                        </div>
                            
                        </div>
                </div>
            </div>
        </div>

        <div class="block-row block-flex {!! $errors->first('clt_cli_quote', 'missing-field') !!}">
            <div class="name block-2">
                <label>Quote</label>
            </div>
            <div class="value block-10 block-content">
                <div class="content {!!$errors->first('clt_cli_quote', 'missing-field') !!}">
                    <div id="block-container3" class="block-container ui-sortable">
                        <div id="clt_cli_quoteparagraph" name="clt_cli_quoteparagraph" class="block text-block">
                            @if (isset($client) && $client->clt_cli_quote)
                            {!! $client->clt_cli_quote !!}
                            @else
                            <p></p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="block-row block-flex">
            <div class="name block-2">
                <label>Tile Image 1</label>
            </div>
            <div class="value block-10">
                <a id="tile1-gallery">Gallery</a>
            </div>
        </div>

        <div class="block-row block-flex">
            <div class="name block-2">
                <label>Tile Image 2</label>
            </div>
            <div class="value block-10">
                <a id="tile2-gallery">Gallery</a>
            </div>
        </div>

        <div class="block-hero">
            <div class="hero">
                <div class="block-row block-flex">
                    <div class="name block-2">
                        &nbsp;
                    </div>

                    <div class="value block-10">
                        <div class="block-row block-flex">
                            {!!Form::hidden('clt_cli_tile1', null, ['id' => 'clt_cli_tile1']) !!}
                            {!!Form::hidden('clt_cli_tile2', null, ['id' => 'clt_cli_tile2']) !!}
                            <div class="name block-6">
                                @if (isset($client) && $client->clt_cli_tile1)
                                <div id="tile1-placeholder" class="hero-placeholder" style="background: url('{{$client->clt_cli_tile1 }}') 50%/60% no-repeat; height:630px;"></div>
                                @else
                                <div id="tile1-placeholder" class="hero-placeholder" style="background: url('') 50%/60% no-repeat; height:630px;"></div>
                                @endif
                            </div>
                            <div class="name block-6">
                                @if (isset($client) && $client->clt_cli_tile2)
                                <div id="tile2-placeholder" class="hero-placeholder" style="background: url('{{$client->clt_cli_tile2 }}') 50%/60% no-repeat; height:630px;"></div>
                                @else
                                <div id="tile2-placeholder" class="hero-placeholder" style="background: url('') 50%/60% no-repeat; height:630px;"></div>
                                @endif
                            </div>
                        </div>

                    </div>

                    </div>
        </div>

    </div>
    
    <div id="gallery-dialog"></div>

        {{ Form::hidden('clt_cli_scenttextparagraph_content', null, ['id' => 'clt_cli_scenttextparagraph_content']) }}
        {{Form::hidden('clt_cli_textinnerparagraph_content', null, ['id' => 'clt_cli_textinnerparagraph_content']) }}
        {{ Form::hidden('clt_cli_quoteparagraph_content', null, ['id' => 'clt_cli_quoteparagraph_content']) }}

        
{!! Form::close() !!}

</section>

{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.4/js/bootstrap-select.min.js') !!}
{!!Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/js/bootstrap-switch.min.js') !!}
{!!Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js') !!}

<script>
$(document).ready( function() {


  $('#block-container,#block-container2,#block-container3,#block-container4,#block-container5')
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
    	openGalleryDialog('/admin/api/clients/gallery', $(this));
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
	.on('mouseenter', '#quote, #clt_cli_scenttextparagraph, #image, #video', function () {
		//var html = '<span class="block-actions"><i class="fa fa-sort sort"></i><i class="fa fa-times delete"></i></span>';
   		//$(this).append(html);
    })
	.on('mouseenter', '#summary', function () {
		//var html = '<span class="block-actions"><i class="fa fa-sort sort"></i></span>';
   		//$(this).append(html);
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


    $('#clipagweb_is_enabled').bootstrapToggle({
        size: 'small',
        on: '<i class="fa fa-check"></i> {{ $clientStatusNames[true] }}',
        off: '<i class="fa fa-times"></i> {{$clientStatusNames[false] }}',
        onstyle: "success",
        offstyle: "default",
    });

    $('#ban_text_align').selectpicker({
        title: " "
    });
    $('select[name="ban_title_colour"]').simplecolorpicker();
    $('select[name="ban_description_colour"]').simplecolorpicker();
    $('select[name="ban_overflow_colour"]').simplecolorpicker();

    $('.page')
    .on('click', '#hero-gallery', function () {
        openGalleryDialog('/admin/api/clients/gallery', $(this));
    })
        .on('click', '#banner-gallery', function () {
        openGalleryDialog('/admin/api/clients/gallery', $(this));
    })
        .on('click', '#feature-gallery', function () {
        openGalleryDialog('/admin/api/clients/gallery', $(this));
    })
        .on('click', '#tile1-gallery', function () {
        openGalleryDialog('/admin/api/clients/gallery', $(this));
    })
        .on('click', '#tile2-gallery', function () {
        openGalleryDialog('/admin/api/clients/gallery', $(this));
    })
    .on('click', '#save', function () {
        if ($('#clipagweb_is_enabled').val()) {
            setupParagraph();
            $('#form').submit();
        }
    })
    .on('click', '#save-publish', function () {
        $('#clipagweb_is_enabled').val('1');
        setupParagraph();
        $('#form').submit();
    })
    .on('click', '#save-draft', function () {
        $('#clipagweb_is_enabled').val('0');
        setupParagraph();
        $('#form').submit();
    })
    .on('click', '#discard', function () {
        if (! confirm('Are you sure?')) return false
        location.href='/admin/clients';
    })
    .on('change', 'select[name="ban_overflow_colour"]', function () {
        $('#banner-overflow-colour-live').css('background-color', $(this).val());
    })
    .on('change', 'select[name="ban_title_colour"]', function () {
        $('#banner-image-live h1').css('color', $(this).val());
    })
    .on('change', 'select[name="ban_description_colour"]', function () {
        $('#banner-image-live h3').css('color', $(this).val());
    })
    .on('change keyup input', '#ban_title', function () {
        $('#banner-image-live h1').html($(this).val());
    })
    .on('change keyup input', '#ban_description', function () {
        $('#banner-image-live h3').html($(this).val());
    })
    .on('change', '#ban_text_align', function () {
        $('#banner-text-align-live').removeClass().addClass($(this).val());
    });
});

function setupParagraph()
{
    debugger;
    var html = $.trim($('#clt_cli_scenttextparagraph p').html());
    $('#clt_cli_scenttextparagraph_content').val('<p>'+html+'</p>');

    html = $.trim($('#clt_cli_textinnerparagraph p').html());
    $('#clt_cli_textinnerparagraph_content').val('<p>'+html+'</p>');

    html = $.trim($('#clt_cli_quoteparagraph p').html());
    $('#clt_cli_quoteparagraph_content').val('<p>'+html+'</p>');


}

function openLinkDialog()
{
	var src = prompt('Write the URL here','http:\/\/');

	if(src && src !='' && src != 'http://') {
		document.execCommand('createLink', false, src);
	}
}
</script>

@stop