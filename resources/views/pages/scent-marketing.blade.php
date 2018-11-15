@section('bodyClass', 'marketing dark subnav')
@section('currentNav', 1)
@section('currentSubNav',1)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-scent-marketing')

<div class="hero-block hero-scent-marketing">
	<div class="container">
			<div class="hero-content">
			<div class="text-block">
				<h1>{!! $translate->token('h_scentmarketing') !!}</h1>
				<h2>{!! $translate->token('text_scentmarketing') !!}</h2>
			</div>
		</div>
	</div>
</div>

<div class="container">
	
	<div class="content-block">
		<div class="text-block">
			<h2>{!! $translate->token('h_whyscent') !!}</h2>
			<p>{!! $translate->token('text_whyscent') !!}</p>
		</div>
	</div>
	
    <div class="content-block cb-b">
		<div class="text-block tb-b">
			<h1 class="pull">{!! $translate->token('h_scentmarketing') !!};<em>{!! $translate->token('h_quote_scentmarketing') !!}</em></h1>
			<p>{!! $translate->token('text_quote_scentmarketing') !!}</p>
		</div>
	</div>
	
	<div class="grid square large">
		<!-- Stretch Image -->
		<div class="box dark">
			<div class="box-cell">
				<div class="tile">
					<div class="tile-content">
						<div class="tile-image">
							<img src="/images/tiles/tile-aromax-woman.jpg" alt="{!! $translate->token('h_scentmarketing', false) !!}">
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Stretch Image -->
		<div class="box dark">
			<div class="box-cell">
				<div class="tile">
					<div class="tile-content">
						<div class="tile-label cover">
							<h2>{!! $translate->token('h_olfactory') !!}</h2>
						</div>
						<div class="tile-image">
							<img src="/images/tiles/tile-gold.png" alt="{!! $translate->token('h_scentmarketing', false) !!}">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="content-block">
		<div class="text-block">
			<p>{!! $translate->token('text_whyscent2') !!}</p>
		</div>
	</div>


	<div class="content-block cb-b">
		<div class="text-block">
			<blockquote class="pull">
				<header>{!! $translate->token('text_quote2_content') !!}</header>
				<footer>{!! $translate->token('text_quote2_signature') !!}</footer>
			</blockquote>
		</div>
	</div>


	<div class="content-block">
		<div class="text-block">
			<h2>{!! $translate->token('h_theresults') !!}</h2>
			<p>{!! $translate->token('text_theresults') !!}</p>
		</div>
	</div>
	
</div>

@stop