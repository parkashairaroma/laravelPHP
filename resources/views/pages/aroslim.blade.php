@section('bodyClass', 'products subnav')
@section('currentNav', 2)
@section('currentSubNav', 1)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.products.nav-aroslim')

<div class="hero-block hb-a aroslim-hero-background large">
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>{!! $translate->token('h_aroslim') !!}</h1>
				<h3>{!! $translate->token('text_aroslim') !!}</h3>
			</div>
		</div>
	</div>
</div>

<div class="container">
	
	<div class="content-block">
		<div class="text-block">
			<h2>{!! $translate->token('h_scentsystem') !!}</h2>
			<p>{!! $translate->token('text_scentsystem') !!}</p>
			<figure><img src="/images/products/aroslim-pair.jpg" alt="{!! $translate->token('h_scentsystem', false) !!}"></figure>
		</div>
	</div>
	
</div>

<div class="container">

	<div class="hero-block hb-a aroslim-product-background large page-block-white">
		<div class="hero-content">
			<div class="text-block">
				<h2>{!! $translate->token('h_easytouch') !!}</h2>
				<p>{!! $translate->token('text_easytouch') !!}</p>
			</div>
		</div>
	</div>
	
	<div class="content-block">
		<div class="text-block tb-a">
			<h2>{!! $translate->token('h_silverblack') !!}</h2>
			<p>{!! $translate->token('text_silverblack') !!}</p>
		</div>
		<div class="grid square large">
			<!-- Product Image -->
			<div class="box">
				<a href="#" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-image">
								<img src="/images/tiles/tile-aroslim-silver.jpg" alt="{!! $translate->token('h_silverblack', false) !!}">
							</div>
						</div>
					</div>
				</a>
			</div>

			<!-- Product Image -->
			<div class="box">
				<a href="#" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-image">
								<img src="/images/tiles/tile-aroslim-black.jpg" alt="{!! $translate->token('h_silverblack', false) !!}">
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>
	
	<div class="content-block">
		<div class="text-block tb-a">
			<h2>{!! $translate->token('h_startscenting') !!}</h2>
			<p>{!! $translate->token('text_startscenting') !!}</p>
			<p>{!! $link->create('/contact', ['class' => 'ui-button ui-a'])->full('link_contact') !!}</div>
		</div>
	</div>
	
</div>

@stop