@extends('admin.layouts.control')

@section('content')

<section class="banners page">

@if (isset($banner)) 
    {!! Form::model($banner, ['method' => 'post', 'id' => 'form']) !!}
@else
    {!! Form::open(['method' => 'post', 'id' => 'form']) !!} 
@endif

    <div class="actionbar">
        <div class="header">
            <h3>Create/Edit Banner</h3></div>
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
                {!! Form::hidden('ban_status', 'false', null) !!}
                {!! Form::checkbox('ban_status', 'true', null, ['id' => 'ban_status']) !!}
            </span>
        	{!! Form::hidden('ban_image', null, ['id' => 'ban_image']) !!}
        </div>
    </div>
    <div class="slider" id="banner-overflow-colour-live" style="background: @if (isset($banner)) {!! $banner->ban_overflow_colour !!} @else {!! Request::old('ban_overflow_colour') !!} @endif">
        <section class="carousel" style="background: url(@if (isset($banner)) {{ $banner->ban_image }} @else {{ Request::old('ban_image') }} @endif) 50%/110% no-repeat">
            <div id="banner-image-live">
                <div id="banner-text-align-live" class="@if (isset($banner)) {!! $banner->ban_text_align !!} @else {!! Request::old('ban_text_align') !!} @endif">
                    <h1 style="color: @if (isset($banner)) {!! $banner->ban_title_colour !!} @else {!! Request::old('ban_title_colour') !!} @endif">
                            @if (isset($banner)) {!! $banner->ban_title !!} @else {!! Request::old('ban_title') !!} @endif
                    </h1>
                    <h3 style="color: @if (isset($banner)) {!! $banner->ban_description_colour !!} @else {!! Request::old('ban_description_colour') !!} @endif">
                        @if (isset($banner)) {!! $banner->ban_description !!} @else {!! Request::old('ban_description') !!} @endif
                    </h3>
                </div>
            </div>
        </section>
    </div>
    <div class="block-fields">
        <div class="block-row block-flex {!! $errors->first('ban_name', 'missing-field') !!}">
            <div class="name block-2">
                <label>Name</label>
            </div>
            <div class="value block-10">{!! Form::text('ban_name', null, ['id' => 'ban_name', 'class' => 'form-control']) !!}</div>
        </div>
        <div class="block-row block-flex {!! $errors->first('ban_title', 'missing-field') !!}">
            <div class="name block-2">
                <label>Title</label>
            </div>
            <div class="value block-10">
	            {!! Form::textarea('ban_title', null, ['id' => 'ban_title', 'class' => 'form-control']) !!}
				{!! Form::select('ban_title_colour', $colours) !!}
            </div>
        </div>
        <div class="block-row block-flex {!! $errors->first('ban_description', 'missing-field') !!}">
            <div class="name block-2">
                <label>Description</label>
            </div>
            <div class="value block-10">
            	{!! Form::textarea('ban_description', null, ['id' => 'ban_description', 'class' => 'form-control']) !!}
            	{!! Form::select('ban_description_colour', $colours) !!}
            </div>
        </div>
        <div class="block-row block-flex">
            <div class="name block-2">
                <label>Link</label>
            </div>
            <div class="value block-10">{!!Form::text('ban_link', null, ['placeholder' => '/url.goes/here', 'class' => 'form-control']) !!}</div>
        </div>

        <div class="block-row block-flex">
            <div class="name block-2">
                <label>Banner for Store?</label>
            </div>
            <div class="value block-10 button">
                {!! Form::checkbox('ban_store', 'true', null, ['id' => 'ban_store']) !!}
            </div>
        </div>
        <div class="block-row block-flex">
            <div class="name block-2">
                <label>Background Image</label>
            </div>
            <div class="value block-10">
                <a id="banner-gallery">Gallery</a>
            </div>
        </div>
        <div class="block-row block-flex">
            <div class="name block-2">
                <label>Align Text</label>
            </div>
            <div class="value block-10">{!! Form::select('ban_text_align', ['banner-text-align-top-left' => 'Top Left', 'banner-text-align-top-right' => 'Top Right', 'banner-text-align-middle-left' => 'Middle Left', 'banner-text-align-middle-right' => 'Middle Right', 'banner-text-align-bottom-left' => 'Bottom Left', 'banner-text-align-bottom-right' => 'Bottom Right', 'banner-text-align-center' => 'Center'], null, ['id' => 'ban_text_align', 'class' => 'form-control']) !!}</div>
        </div>
        <div class="block-row block-flex">
            <div class="name block-2">
                <label>Overflow Colour</label>
            </div>
            <div class="value block-10">{!! Form::select('ban_overflow_colour', $colours) !!}</div>
        </div>
    </div>
    <div id="gallery-dialog"></div>

{!! Form::close() !!}

</section>

{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.4/js/bootstrap-select.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/js/bootstrap-switch.min.js') !!}

<script>
$(document).ready( function() {

    $('#ban_status').bootstrapToggle({
        size: 'small',
        on: '<i class="fa fa-check"></i> {{ $bannerStatusNames[true] }}',
        off: '<i class="fa fa-times"></i> {{ $bannerStatusNames[false] }}',
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
    .on('click', '#banner-gallery', function () {   
        openGalleryDialog('/admin/api/banners/gallery', $(this));
    })   
    .on('click', '#save', function () {   
        if ($('#ban_status').val()) {
            $('#form').submit();
        }
    })    
    .on('click', '#save-publish', function () {   
        $('#ban_status').val('1');
        $('#form').submit();
    })
    .on('click', '#save-draft', function () {   
        $('#ban_status').val('0');
        $('#form').submit();
    })
    .on('click', '#discard', function () {   
        if (! confirm('Are you sure?')) return false
        location.href='/admin/blog';
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
</script>

@stop