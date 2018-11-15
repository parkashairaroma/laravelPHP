@section('bodyClass', 'products subnav')
@section('currentNav', 2)
@section('currentSubNav', 1)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-products')

<div class="hero-block">	
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>{!! $translate->token('h_diffusers') !!}</h1>
				<h2>{!! $translate->token('text_diffusers') !!}</h2>
			</div>
		</div>
	</div>
</div>

<div class="container">
	
	<div class="content-block">
		
		<div class="grid square large grid-a">
			<!-- Product Image -->
			<div class="box">
				<a href="/aromax" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-info">
								<h3>{!! $translate->token('h_aromax') !!}</h3>
							</div>
							<div class="tile-image">
								<img src="/images/tiles/tile-product-aromax.jpg" alt="{!! $translate->token('h_aromax', false) !!}">
							</div>
							<div class="tile-overlay"><span>{!! $translate->token('link_view') !!}</span></div>
						</div>
					</div>
				</a>
			</div>
			<!-- Product Image -->
			<div class="box dark">
				<a href="/aroscent" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-info">
								<h3>{!! $translate->token('h_aroscent') !!}</h3>
							</div>
							<div class="tile-image ">
								<img src="/images/tiles/tile-product-aroscent.jpg" alt="{!! $translate->token('h_aroscent', false) !!}">
							</div>
							<div class="tile-overlay"><span>{!! $translate->token('link_view') !!}</span></div>
						</div>
					</div>
				</a>
			</div>
			<!-- Product Image -->
			<div class="box">
				<a href="/aroslim" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-info">
								<h3>{!! $translate->token('h_aroslim') !!}</h3>
							</div>
							<div class="tile-image">
								<img src="/images/tiles/tile-product-aroslim.jpg"alt="{!! $translate->token('h_aroslim', false) !!}">
							</div>
							<div class="tile-overlay"><span>{!! $translate->token('link_view') !!}</span></div>
						</div>
					</div>
				</a>
			</div>
			<!-- Product Image -->
			<div class="box">
				<a  href="/ecoscent" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-info">
								<h3>{!! $translate->token('h_ecoscent') !!}</h3>
							</div>
							<div class="tile-image ">
								<img src="/images/tiles/tile-product-ecoscent.jpg"alt="{!! $translate->token('h_ecoscent', false) !!}">
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