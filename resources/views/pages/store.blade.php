@section('bodyClass', 'store subnav')
@section('currentNav', 6)
@section('currentSubNav', 0)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-store')

<div class="carousel">
    <!-- Slides -->
    @foreach ($banners as $key => $banner)
    @if ($banner->ban_store == true) 
    <div class="slide @if ($key > 0) preload @endif" style="background: {{ $banner->ban_overflow }};">
        <a href="{{ $banner->ban_link }}" class="hero-block" style="background-image: url('{{ $banner->ban_image }}')">
            <div class="container">
                <div class="hero-content">
                    <div class="text-block">
                        <h1 style="color: {{ $banner->ban_title_colour }}">{!! $banner->ban_title !!}</h1>
                        <h3 style="color: {{ $banner->ban_description_colour }}">{!! $banner->ban_description !!}</h3>
                    </div>
                </div>
            </div>
        </a>
    </div>
    @endif
    @endforeach
</div>

<div class="container">
	
	<div class="content-block">
		
		<div class="text-block">
			<h3>{!! $translate->token('h_featureproducts') !!}</h3>
      <p>
          {!! $translate->token('text_featureproducts') !!}
      </p>
		</div>
		
     <div class="grid square large gutter">
         @foreach ($products as $prod)
            @include('pages.store.partials.product-tile')
         @endforeach
     </div>     
	</div>
	
</div>

@stop