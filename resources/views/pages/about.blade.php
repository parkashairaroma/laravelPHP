@section('bodyClass', 'about subnav dark')
@section('currentNav', 0)
@section('currentSubNav', 1)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-about')

<div class="hero-block hero-about">
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>{!! $translate->token('h_about') !!}</h1>
				<h2>{!! $translate->token('text_about') !!}</h2>
			</div>
		</div>
	</div>
</div>

<div class="container">
	
	<div class="content-block cb-a">
		<div class="text-block">
			<h2>{!! $translate->token('h_weare') !!}</h2>
			<p>{!! $translate->token('text_weare') !!}</p>
		</div>
	</div>
	
	<div class="content-block">
		<div class="grid large divider div-a">
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							<div class="feature-icon icon-air-aroma"></div>
							<h3>{!! $translate->token('h_pioneers') !!}</h3>
							<p>{!! $translate->token('text_pioneers') !!}</p>
							<p>{!! $link->create('/why-air-aroma')->full('link_whyairaroma') !!}</p>
						</div>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							<div class="feature-icon fi-green icon-recycle"></div>
							<h3>{!! $translate->token('h_wearegreen') !!}</h3>
							<p>{!! $translate->token('text_wearegreen') !!}</p>
							<p>{!! $link->create('/environment')->full('link_learnmore') !!}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>

@stop