@section('bodyClass', 'scents subnav arobalance')
@section('currentNav', 2)
@section('currentSubNav', 2)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.products.nav-no-stress-arobalance')

<div class="hero-block">	
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>{!! $translate->token('h_howitworks') !!}</h1>
				<h3>{!! $translate->token('text_howitworks') !!}</h3>
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
								<img src="/images/tiles/tile-arobalance-icon.png" alt="{!! $translate->token('h_howitworks', false) !!}">
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
								<img src="/images/tiles/tile-arobalance-leaves.jpg" alt="{!! $translate->token('h_howitworks', false) !!}">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Text -->
		<div class="text-block">
			<h2>{!! $translate->token('h_reducestress') !!}</h2>
			<p>{!! $translate->token('text_reducestress') !!}</p>
		</div>
	
	</div>
	
	<div class="content-block">
		
		<!-- Text -->
		<div class="text-block">
			<h2>{!! $translate->token('h_stresseffects') !!}</h2>
			<p>{!! $translate->token('text_stresseffects') !!}</p>
			<div id="stress-graph">
				<ul class="graph-legend">
					<li>{!! $translate->token('h_nerveactivity') !!} (μV)</li>
				</ul>
				<div class="chart">
					<ul class="x-axis">
						<li>A</li>
						<li>B</li>
						<li>C</li>
						<li>D</li>
						<li>E</li>
						<li>F</li>
						<li>G</li>
						<li>H</li>
					</ul>
					<ul class="y-axis">
						<li>160</li>
						<li>120</li>
						<li>80</li>
						<li>40</li>
					</ul>
					<div class="plot">
						<div class="y-marker y-marker-01"></div>
						<div class="y-marker y-marker-02"></div>
						<div class="y-marker y-marker-03"></div>
						<div class="plot-bar plot-bar-a"></div>
						<div class="plot-bar plot-bar-b"></div>
						<div class="plot-bar plot-bar-c"></div>
						<div class="plot-bar plot-bar-d"></div>
						<div class="plot-bar plot-bar-e"></div>
						<div class="plot-bar plot-bar-f"></div>
						<div class="plot-bar plot-bar-g"></div>
						<div class="plot-bar plot-bar-h"></div>
					</div>
				</div>
			</div>
			<p>{!! $translate->token('text_nerveactivity') !!}</p>
		</div>
		
	</div>
	
	<div class="content-block cb-a cb-b">
		
		<!-- Text -->
		<div class="text-block">
			<blockquote class="pull">
				<p>{!! $translate->token('h_quote_braintests') !!}</p>
				<footer>{!! $translate->token('text_quote_braintests') !!}</footer>
			</blockquote>
		</div>
		
	</div>
	
	<div class="content-block">
	
		{{-- Enable Store --}}
		@if ($enableStore)  
		<div class="text-block tb-a">
			<h2>{!! $translate->token('h_buyarobalance') !!}</h2>
			<p>{!! $translate->token('text_buyarobalance') !!}</p>
			<p class="center">{!! $link->create('/contact', ['class' => 'ui-button ui-a ui-b'])->full('link_contact') !!}</p>
		</div>
		@endif
		
	</div>
	
</div>


@stop