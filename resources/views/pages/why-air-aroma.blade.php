@section('bodyClass', 'marketing subnav dark why-air-aroma')
@section('currentNav', 1)
@section('currentSubNav', 3)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-scent-marketing')

<div class="hero-block hero-why-air-aroma">
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>{!! $translate->token('h_whyairaroma') !!}</h1>
				<h2>{!! $translate->token('text_whyairaroma') !!}</h2>
			</div>
		</div>
	</div>
</div>

<div class="container">

	<div class="content-block cb-a">
		<div class="text-block">
			<h2>{!! $translate->token('h_scentbranding') !!}</h2>
			<p>{!! $translate->token('text_scentbranding') !!}</p>
			<div class="center">{!! $link->create('/clients')->full('link_scentbranding') !!}</div>
		</div>
	</div>
	
	<div class="content-block">
		<div class="text-block">
			<h2>{!! $translate->token('h_leadingdiffusion') !!}</h2>
			<p>{!! $translate->token('text_leadingdiffusion') !!}</p>
			<div id="diffusion-graph">
				<ul class="graph-legend">
					<li class="legend-aa">{!! $translate->token('text_airaroma') !!}</li>
					<li class="legend-comp">{!! $translate->token('text_competitor') !!}</li>
				</ul>
				<div class="chart">
					<ul class="x-axis">
						<li>Day 1</li>
						<li>Day 7</li>
						<li>Day 14</li>
						<li>Day 21</li>
						<li>Day 30</li>
					</ul>
					<ul class="y-axis">
						<li>100%</li>
						<li>75%</li>
						<li>50%</li>
						<li>25%</li>
					</ul>
					<div class="plot">
						<div class="x-marker x-marker-01"></div>
						<div class="x-marker x-marker-02"></div>
						<div class="x-marker x-marker-03"></div>
						<div class="plot-line plot-line-aa"></div>
						<div class="plot-line plot-line-comp"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>
	
<div class="content-block cb-network">
	<div class="container">
		<div class="text-block tb-a tb-c">
			<h2>{!! $translate->token('h_globalnetwork') !!}</h2>
			<p>{!! $translate->token('text_globalnetwork') !!}</p>
			<div class="center">{!! $link->create('/contact')->full('link_globalnetwork') !!}</div>
		</div>
		<figure><img src="/images/static/world-map.png" alt="{!! $translate->token('h_globalnetwork', false) !!}"></figure>
	</div>
</div>
	
<div class="container">
	
	<div class="content-block">
		<div class="text-block">
			<h2>{!! $translate->token('h_ingredients') !!}</h2>
			<p>{!! $translate->token('text_ingredients') !!}</p>
			<figure><img src="/images/static/ifra-badge.png" style="max-width:240px; width: 33%;"  alt="{!! $translate->token('h_ingredients', false) !!}" /></figure>
		</div>
	</div>
	
</div>

@stop