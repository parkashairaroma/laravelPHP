@section('bodyClass', 'products dark subnav')
@section('currentNav', 2)
@section('currentSubNav', 0)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-products')

<div class="hero-block products-hero-background">
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>{!! $translate->token('h_products') !!}</h1>
				<h2>{!! $translate->token('text_products') !!}</h2>
			</div>
		</div>
	</div>
</div>

<div class="container">
	
	<div class="content-block">
		<div class="grid square large grid-a">
			<!-- Product Image -->
			<div class="box">
				<a href="{{ $link->create('/diffusers')->url() }}" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-info">
								<h3>{!! $translate->token('h_diffusers') !!}</h3>
								<p>{!! $translate->token('text_diffusers') !!}</p>
							</div>
							<div class="tile-image">
								<img src="/images/tiles/tile-product-diffusers-new.jpg" alt="{!! $translate->token('h_diffusers', false) !!}">
							</div>
							<div class="tile-overlay"><span>{!! $translate->token('link_view') !!}</span></div>
						</div>
					</div>
				</a>
			</div>
			<!-- Product Image -->
			<div class="box">
				<a href="{{ $link->create('/signature-scent')->url() }}" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-info">
								<h3>{!! $translate->token('h_signaturescents') !!}</h3>
								<p>{!! $translate->token('text_signaturescents') !!}</p>
							</div>
							<div class="tile-image ">
								<img src="/images/tiles/tile-product-signature.jpg" alt="{!! $translate->token('h_signaturescents', false) !!}">
							</div>
							<div class="tile-overlay"><span>{!! $translate->token('link_view') !!}</span></div>
						</div>
					</div>
				</a>
			</div>
			<!-- Product Image -->
			<div class="box">
				<a href="{{ $link->create('/scents')->url() }}" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-info">
								<h3>{!! $translate->token('h_scents') !!}</h3>
								<p>{!! $translate->token('text_scents') !!}</p>
							</div>
							<div class="tile-image">
								<img src="/images/tiles/tile-product-scents.jpg" alt="{!! $translate->token('h_scents', false) !!}">
							</div>
							<div class="tile-overlay"><span>{!! $translate->token('link_view') !!}</span></div>
						</div>
					</div>
				</a>
			</div>
			<!-- Product Image -->
			<div class="box dark">
				<a  href="{{ $link->create('/aropromo')->url() }}" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-info">
								<h3>{!! $translate->token('h_aropromo') !!}</h3>
								<p>{!! $translate->token('text_aropromo') !!}</p>
							</div>
							<div class="tile-image ">
								<img src="/images/tiles/tile-product-aropromo.jpg" alt="{!! $translate->token('h_aropromo', false) !!}">
							</div>
							<div class="tile-overlay"><span>{!! $translate->token('link_view') !!}</span></div>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>
</div>

@stop