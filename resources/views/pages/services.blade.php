@section('bodyClass', 'services dark subnav')
@section('currentNav', 2)
@section('currentSubNav', 3)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-about')

<div class="hero-block services-hero-background">
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>{!! $translate->token('h_services') !!}</h1>
				<h3>{!! $translate->token('text_services') !!}</h3>
			</div>
		</div>
	</div>
</div>

<div class="container">
	
	<div class="content-block cb-a">
		
		<!-- Text -->
		<div class="text-block">
			<h2>{!! $translate->token('h_rentorpurchase') !!}</h2>
			<p>{!! $translate->token('text_rentorpurchase') !!}</p>
			
			<!-- Inner Icon Row -->
			<div class="grid inner">
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="text-block">
								<div class="feature-icon icon-lease"></div>
								<h4>{!! $translate->token('h_leaseterms') !!}</h4>
							</div>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="text-block">
								<div class="feature-icon icon-support"></div>
								<h4>{!! $translate->token('h_customersupport') !!}</h4>
							</div>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="text-block">
								<div class="feature-icon icon-install"></div>
								<h4>{!! $translate->token('h_installation') !!}</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>

	</div>
	
	<div class="content-block">
		
		<!-- Text -->
		<div class="text-block">
			<h2>{!! $translate->token('h_care') !!}</h2>
			<p>{!! $translate->token('text_care') !!}</p>
		</div>
		
		<!-- 2x1 Grid -->
		<div class="grid square large">
			<!-- Text Tile -->
			<div class="box dark">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-label cover">
								<h2>{!! $translate->token('h_scentservice') !!}</h2>
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
								<img src="/images/tiles/tile-services.jpg" alt="{!! $translate->token('h_care', false) !!}">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Text -->
		<div class="text-block tb-c">
			<h2>{!! $translate->token('h_maintenance') !!}</h2>
			<p>{!! $translate->token('text_maintenance') !!}</p>
		</div>
		
		<!-- 2x2 Grid -->
		<div class="grid large divider div-a">
			<div class="box">
				<div class="box-cell">
					<div class="text-block">
						<div class="feature-icon icon-plug"></div>
						<h3>{!! $translate->token('h_plugplay') !!}</h3>
							{!! $link->create('/aromax')->full('link_aromax') !!}<br />
							{!! $link->create('/aromax')->full('link_aroslim') !!}<br />
							{!! $link->create('/aroscent')->full('link_aroscent') !!}<br />
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="text-block">
						<div class="feature-icon icon-spanner"></div>
						<h3>{!! $translate->token('h_requiresinstallation') !!}</h3>
						{!! $link->create('/aroscent')->full('link_aroscenthvac') !!}<br />
						{!! $link->create('/aroscent')->full('link_aroscenthlighttrack') !!}<br />
						{!! $link->create('/ecoscent')->full('link_ecoscent') !!}<br />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@stop