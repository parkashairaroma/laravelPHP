@section('bodyClass', 'products dark subnav')
@section('currentNav', 2)
@section('currentSubNav', 1)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.products.nav-aroscent')

<div class="hero-block aroscent-hero-background large" >
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>{!! $translate->token('h_aroscent') !!}</h1>
				<h3>{!! $translate->token('text_aroscent') !!}</h3>
			</div>
		</div>
	</div>
</div>

<div class="container ">

	<div class="content-block cb-a">
		<div class="text-block">
			<h2>{!! $translate->token('h_dimension') !!}</h2>
			<p>{!! $translate->token('text_dimension') !!}</p>
			<figure><img src="/images/products/aroscent-white.jpg" alt="{!! $translate->token('h_dimension', false) !!}"></figure>
		</div>
	</div>

	<div class="hero-block hb-a aroscent-product-background large page-block-black">
		<div class="hero-content">
			<div class="text-block">
				<h2>{!! $translate->token('h_flexible') !!}</h2>
				<p>{!! $translate->token('text_flexible') !!}</p>
			</div>
		</div>
	</div>

	<div class="content-block cb-a">
		<div class="grid large divider div-a">
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							<div class="feature-icon icon-interval"></div>
							<h3>{!! $translate->token('h_advancedtimer') !!}</h3>
							<p>{!! $translate->token('text_advancedtimer') !!}</p>
						</div>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							<div class="feature-icon icon-hvac"></div>
							<h3>{!! $translate->token('h_connecthvac') !!}</h3>
							<p>{!! $translate->token('text_connecthvac') !!}</p>
						</div>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							<div class="feature-icon icon-adjustable"></div>
							<h3>{!! $translate->token('h_adjustable') !!}</h3>
							<p>{!! $translate->token('text_adjustable') !!}</p>
						</div>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							<div class="feature-icon icon-placement"></div>
							<h3>{!! $translate->token('h_placement') !!}</h3>
							<p>{!! $translate->token('text_placement') !!}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="content-block">
		<div class="text-block tb-a">
			<h2>{!! $translate->token('h_blackwhite') !!}</h2>
			<p>{!! $translate->token('text_blackwhite') !!}</p>
			<p class="center">{!! $link->create('/contact', ['class' => 'ui-button ui-a'])->full('link_buynow') !!}</p>
		</div>
		<div class="grid square large">
			<!-- Product Image -->
			<div class="box">
				<a href="#" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-image">
								<img src="/images/tiles/tile-aroscent-white.jpg" alt="{!! $translate->token('h_blackwhite', false) !!}">
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
								<img src="/images/tiles/tile-aroscent-black.jpg" alt="{!! $translate->token('h_blackwhite', false) !!}">
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>
	<div class="content-block">
		<div class="grid large divider div-a">
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							<div class="feature-icon icon-phone"></div>
							<h3>{!! $translate->token('h_callus') !!}</h3>
							<p>{!! $translate->token('text_callus') !!}</p>
							<p>{!! $link->create('/contact')->full('link_contactus') !!}</p>
						</div>
					</div>
				</div>
			</div>
			{{-- Enable Store --}}
			@if ($enableStore)  
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							<div class="feature-icon icon-cart"></div>
							<h3>{!! $translate->token('h_shoponline') !!}</h3>
							<p>{!! $translate->token('text_shoponline') !!}</p>
							<p>{!! $link->create('/contact')->full('link_buyaroscent') !!}</p>
						</div>
					</div>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>

@stop