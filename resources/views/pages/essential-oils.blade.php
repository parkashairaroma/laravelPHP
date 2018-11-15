@section('bodyClass', 'scents subnav')
@section('currentNav', 2)
@section('currentSubNav', 1)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.products.nav-essential-oils')

<div class="hero-block">	
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>{!! $translate->token('h_essentialoils') !!}</h1>
				<h3>{!! $translate->token('text_essentialoils') !!}</h3>
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
								<img src="/images/tiles/tile-essential-oils-bottle.jpg" alt="{!! $translate->token('h_essentialoils', false) !!}">
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
								<img src="/images/tiles/tile-essential-oils-leaves.jpg" alt="{!! $translate->token('h_essentialoils', false) !!}">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Text -->
		<div class="text-block">
			<h2>{!! $translate->token('h_naturalingredients') !!}</h2>
			<p>{!! $translate->token('text_naturalingredients') !!}</p>
			<p class="center">{!! $link->create('/store/fragrances', ['class' => 'ui-button ui-a'])->full('link_viewrange') !!}</p>
		</div>
		
		<!-- 2x1 Grid -->
		<div class="grid square large">
			<!-- Image Tile -->
			<div class="box">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-image">
								<img src="/images/tiles/tile-essential-oils-model.jpg" alt="{!! $translate->token('h_naturalingredients', false) !!}">
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
								<img src="/images/tiles/tile-essential-oils-sample.jpg" alt="{!! $translate->token('h_naturalingredients', false) !!}">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Text -->
		<div class="text-block">
			<h2>{!! $translate->token('h_benefits') !!}</h2>
			<p>{!! $translate->token('text_benefits') !!}</p>
		</div>
				
	</div>
	
	<div class="content-block cb-a">
		
		<!-- Text -->
		<div class="text-block">
			<h2>{!! $translate->token('h_retailrange') !!}</h2>
			<ul class="column-list">
				<li>Bye Fly</li>
				<li>Captivating</li>
				<li>Mint Motion</li>
				<li>Imaya</li>
				<li>Conditioning</li>
				<li>Ayo</li>	
				<li>Breathe Easy</li>
				<li>Alpine Air</li>
				<li>Serene</li>
				<li>Redwood</li>
				<li>Pro Hygiene</li>
				<li>Lavender Forest</li>
				<li>Bergamot Burst</li>
				<li>Summer Bliss</li>
				<li>Tranquility</li>
				<li>Orange Fields</li>
				<li>Golden Sunset</li>
				<li>Zuri</li>
			</ul>
		</div>
		
	</div>
	
	<div class="content-block">
		<!-- Text -->
		<div class="text-block tb-a">
			<h2>{!! $translate->token('h_buyonline') !!}</h2>
			<p>{!! $translate->token('text_buyonline') !!}</p>
			<p>{!! $link->create('/store/fragrances', ['class' => 'ui-button ui-a'])->full('link_buynow') !!}</p>
		</div>
		
	</div>
	
</div>

@stop