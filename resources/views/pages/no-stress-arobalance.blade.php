@section('bodyClass', 'scents subnav')
@section('currentNav', 2)
@section('currentSubNav', 1)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.products.nav-no-stress-arobalance')

<div class="hero-block">	
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>{!! $translate->token('h_nostress') !!}</h1>
				<h3>{!! $translate->token('text_nostress') !!}</h3>
			</div>
		</div>
	</div>
</div>

<div class="container">
	
	<div class="content-block cb-a">
		
		<!-- 2x1 Grid -->
		<div class="grid square large">
			<!-- Image Tile -->
			<div class="box">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-image">
								<img src="/images/tiles/tile-arobalance-bottle.jpg" alt="{!! $translate->token('h_nostress', false) !!}">
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Image Tile -->
			<div class="box">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-image">
								<img src="/images/tiles/tile-arobalance-sample.jpg" alt="{!! $translate->token('h_nostress', false) !!}">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="text-block tb-a tb-c">
			<h2>{!! $translate->token('h_whatis') !!}</h2>
			<p>{!! $translate->token('text_whatis') !!}</p>
		</div>
		
		<!-- 2x2 Grid -->
		<div class="grid large divider div-a">
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							<div class="feature-icon icon-australia"></div>
							<h3>{!! $translate->token('h_madein') !!}</h3>
							<p>{!! $translate->token('text_madein') !!}</p>
						</div>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							<div class="feature-icon icon-science"></div>
							<h3>{!! $translate->token('h_science') !!}</h3>
							<p>{!! $translate->token('text_science') !!}</p>
						</div>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							<div class="feature-icon icon-natural"></div>
							<h3>{!! $translate->token('h_natural') !!}</h3>
							<p>{!! $translate->token('text_natural') !!}</p>
						</div>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							<div class="feature-icon icon-bottle"></div>
							<h3>{!! $translate->token('h_sprays') !!}</h3>
							<p>{!! $translate->token('text_sprays') !!}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
	
	<div class="content-block cb-a">
		<div class="text-block">
			<h2>{!! $translate->token('h_reduce') !!}</h2>
			<p>{!! $translate->token('text_reduce') !!}</p>
			<h2>{!! $translate->token('h_improve') !!}</h2>
			<p>{!! $translate->token('text_improve') !!}</p>
			<div class="center">{!! $link->create('/no-stress-arobalance/how-it-works')->full('link_howitworks') !!}</div>
		</div>
	</div>
	
	<div class="content-block">
	
		{{-- Enable Store --}}
		@if ($enableStore)  
		<div class="text-block tb-a">
			<h2>{!! $translate->token('h_buyonline') !!}</h2>
			<p>{!! $translate->token('text_buyonline') !!}</p>
			<p class="center">{!! $link->create('/contact', ['class' => 'ui-button ui-a ui-b'])->full('link_contact') !!}</p>		
		</div>
		@endif
		
	</div>
	
</div>

@stop