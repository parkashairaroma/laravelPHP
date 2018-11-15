@section('bodyClass', 'clients dark')
@section('currentNav', 3)

@extends('layouts.pages')

@section('content')

<div class="hero-block hero-image" style="background-image: url(/images/clients/featured/hero-sofitel.jpg);background-position: center center;">
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>{!! $translate->token('h_sofitel') !!}</h1>
				<h2>{!! $translate->token('text_sofitel') !!}</h2>
			</div>
		</div>
	</div>
</div>

<div class="container">
	
	<div class="content-block">
		<div class="text-block">
			<h2>{!! $translate->token('h_eaude') !!}</h2>
			<p>{!! $translate->token('text_eaude') !!}</p>
		</div>
	</div>

	<div class="content-block">
		<img src="/images/clients/featured/banner-sofitel.jpg" alt="{!! $translate->token('h_sofitel', false) !!}">
	</div>
	
	<div class="content-block">

	<div class="content-block cb-b">
		<div class="text-block tb-b">
			<p>{!! $translate->token('quote_bespokefragrance') !!}	</p>
			<p><i>{!! $translate->token('signature_bespokefragrance') !!}</i></p>
		</div>
	</div>


		<div class="grid square large">
			<!-- Stretch Image -->
			<div class="box dark">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-image">
								<img src="/images/clients/featured/tile-sofitel-01.jpg" alt="{!! $translate->token('h_sofitel', false) !!}">
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
							<div class="tile-image">
								<img src="/images/clients/featured/tile-sofitel-02.jpg" alt="{!! $translate->token('h_sofitel', false) !!}">
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
						<p class="center">{!! $link->create('/contact')->full('link_scentdesign') !!}</p>	
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>

@stop