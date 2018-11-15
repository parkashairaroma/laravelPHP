@section('bodyClass', 'products dark subnav')
@section('currentNav', 2)
@section('currentSubNav', 1)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.products.nav-aromax')

<div class="hero-block aromax-hero-background large">
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>{!! $translate->token('h_aromax') !!}</h1>
				<h3>{!! $translate->token('text_aromax') !!}</h3>
			</div>
		</div>
	</div>
</div>

<div class="container">
	
	<div class="content-block cb-a">
		<div class="text-block">
			<h2>{!! $translate->token('h_meetaromax') !!}</h2>
			<p>{!! $translate->token('text_meetaromax') !!}</p>
			<figure>
				<img src="/images/products/aromax-silver-content.jpg" alt="{!! $translate->token('h_meetaromax', false) !!}">
			</figure>
		</div>	
	</div>
	
	<div class="hero-block hb-a aromax-product-background large page-block-black">
		<div class="hero-content">
			<div class="text-block">
				<h2>{!! $translate->token('h_formfunction') !!}</h2>
				<p>{!! $translate->token('text_formfunction') !!}</p>
			</div>
		</div>
	</div>

	<div class="content-block">
		<div class="text-block tb-a">
			<h2>{!! $translate->token('h_yourcolour') !!}</h2>
			<p>{!! $translate->token('text_yourcolour') !!}</p>

			{{-- Enable Store --}}
			@if ($enableStore)  
				<p>{!! $link->create('/store/aromax', ['class' => 'ui-button ui-a'])->full('link_buynow') !!}</p>
			@endif
			
		</div>
		
		<div class="grid square large gutter">
			<!-- Product Image -->
			<div class="box">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-info">
								<h3>{!! $translate->token('h_silver') !!}</h3>
							</div>
							<div class="tile-image">
								<img src="/images/tiles/tile-aromax-silver.jpg" alt="{!! $translate->token('h_silver', false) !!}">
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Product Image -->
			<div class="box">
				<div href="#" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-info">
								<h3>{!! $translate->token('h_gold') !!}</h3>
							</div>
							<div class="tile-image ">
								<img src="/images/tiles/tile-aromax-gold.jpg" alt="{!! $translate->token('h_gold', false) !!}">
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Product Image -->
			<div class="box">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-info">
								<h3>{!! $translate->token('h_black') !!}</h3>
							</div>
							<div class="tile-image">
								<img src="/images/tiles/tile-aromax-black.jpg" alt="{!! $translate->token('h_black', false) !!}">
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Product Image -->
			<div class="box">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-info">
								<h3>{!! $translate->token('h_blue') !!}</h3>
							</div>
							<div class="tile-image">
								<img src="/images/tiles/tile-aromax-blue.jpg" alt="{!! $translate->token('h_blue', false) !!}">
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Product Image -->
			<div class="box">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-info">
								<h3>{!! $translate->token('h_red') !!}</h3>
							</div>
							<div class="tile-image">
								<img src="/images/tiles/tile-aromax-red.jpg" alt="{!! $translate->token('h_red', false) !!}">
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Product Image -->
			<div class="box">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-info">
								<h3>{!! $translate->token('h_purple') !!}</h3>
							</div>
							<div class="tile-image">
								<img src="/images/tiles/tile-aromax-purple.jpg" alt="{!! $translate->token('h_purple', false) !!}">
							</div>
						</div>
					</div>
				</div>
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
							<p>{!! $link->create('/store/aromax')->full('link_buyaromax') !!}</p>
						</div>
					</div>
				</div>
			</div>
			@endif

		</div>
	</div>
	
</div>

@stop