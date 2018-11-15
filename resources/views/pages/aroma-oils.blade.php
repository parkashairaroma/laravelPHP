@section('bodyClass', 'scents subnav')
@section('currentNav', 2)
@section('currentSubNav', 1)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.products.nav-aroma-oils')

<div class="hero-block">	
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>{!! $translate->token('h_aromaoils') !!}</h1>
				<h3>{!! $translate->token('text_aromaoils') !!}</h3>
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
								<img src="/images/tiles/tile-aroma-oils-bottle.jpg" alt="{!! $translate->token('h_aromaoils', false) !!}">
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
								<img src="/images/tiles/tile-aroma-oils-mist.jpg" alt="{!! $translate->token('h_aromaoils', false) !!}">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Text -->
		<div class="text-block">
			<h2>{!! $translate->token('h_materials') !!}</h2>
			<p>{!! $translate->token('text_materials') !!}</p>
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
								<img src="/images/tiles/tile-aroma-oils-oil.jpg" alt="{!! $translate->token('h_materials', false) !!}">
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
								<img src="/images/tiles/tile-aroma-oils-sample.jpg" alt="{!! $translate->token('h_materials', false) !!}">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Text -->
		<div class="text-block">
			<h2>{!! $translate->token('h_anyfragrance') !!}</h2>
			<p>{!! $translate->token('text_anyfragrance') !!}</p>
		</div>
				
	</div>
	
	<div class="content-block cb-a">
		
		<!-- Text -->
		<div class="text-block">
			<h2>{!! $translate->token('h_retailrange') !!}</h2>
			<ul class="column-list">
				<li>Cedar Mood</li>
				<li>Vetiver Rain</li>
				<li>Lemongrass Tea</li>
				<li>Illuminate</li>
				<li>Longboard</li>
				<li>Fig Essence</li>
				<li>Vanilla Lace</li>
				<li>Amber Grand</li>
				<li>White Tea</li>
				<li>Oriental Blossom</li>
				<li>Fresh Grass</li>
				<li>Rainforest</li>
				<li>Sencha</li>
				<li>Zesty Champaca</li>
				<li>Cherry Blossom</li>
				<li>Guava Cucumber</li>
				<li>Th&egrave; vert oriental</li>
				<li>Classic Spice</li>
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