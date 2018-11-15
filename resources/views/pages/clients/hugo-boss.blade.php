@section('titleTag', '')
@section('descriptionTag', '')
@section('bodyClass', 'clients dark')
@section('currentNav', 3)

@extends('layouts.pages')

@section('content')

<div class="hero-block hero-image" style="background-image: url(/images/clients/featured/hero-hugo-boss.jpg);background-position: center center;">
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>{!! $translate->token('h_hugoboss') !!}</h1>
				<h2>{!! $translate->token('text_hugoboss') !!}</h2>
			</div>
		</div>
	</div>
</div>

<div class="container">
	
	<div class="content-block">
		<div class="text-block">
			<h2>{!! $translate->token('h_instorescent') !!}</h2>
			<p>{!! $translate->token('text_instorescent') !!}</p>
		</div>
	</div>

	<div class="content-block">
		<img src="/images/clients/featured/banner-hugo-boss.jpg" alt="{!! $translate->token('h_hugoboss', false) !!}">
	</div>
	
	<div class="content-block">
		<div class="text-block">
			<p>{!! $translate->token('h_elegance') !!}</p>
		</div>
	</div>
	
	<div class="content-block">
		<div class="grid large divider div-a">
			<div class="box">
				<div class="box-cell">
					<div class="text-block">
						<div class="feature-icon icon-phone"></div>
						<h3>{!! $translate->token('h_callus') !!}</h3>
						<p>{!! $translate->token('text_callus') !!}</p>
						<p class="center">{!! $link->create('/contact')->full('link_trysample') !!}</p>	
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="text-block">
						<div class="feature-icon icon-scent"></div>
						<h3>{!! $translate->token('h_scentdevelopment') !!}</h3>
						<p>{!! $translate->token('text_scentdevelopment') !!}</p>
						<p class="center">{!! $link->create('/contact')->full('link_designscent') !!}</p>		
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>

@stop