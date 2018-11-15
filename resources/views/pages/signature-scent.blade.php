@section('bodyClass', 'scents subnav')
@section('currentNav', 2)
@section('currentSubNav', 2)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-products')

<div class="hero-block hero-scents-signature">	
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>{!! $translate->token('h_signaturescent') !!}</h1>
				<h3>{!! $translate->token('text_signaturescent') !!}</h3>
			</div>
		</div>
	</div>
</div>

<div class="container">
	
	<div class="content-block cb-a">
		<div class="grid square large">
			<!-- Image -->
			<div class="box">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-image">
								<img src="/images/tiles/tile-signature-aroscent.jpg" alt="{!! $translate->token('h_signaturescent', false) !!}">
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Image -->
			<div class="box">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-image">
								<img src="/images/tiles/tile-signature-sample.jpg" alt="{!! $translate->token('h_signaturescent', false) !!}">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="text-block">
			<h2>{!! $translate->token('h_custombrands') !!}</h2>
			<p>{!! $translate->token('text_custombrands') !!}</p>
		</div>

		<div class="grid square large">
			<!-- Image -->
			<div class="box">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-image">
								<img src="/images/tiles/tile-signature-bottle.jpg" alt="{!! $translate->token('h_custombrands', false) !!}">
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Image -->
			<div class="box dark">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-label cover">
								<h2>{!! $translate->token('h_yourscent') !!}</h2>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="text-block">
			<h2>{!! $translate->token('h_creativeprocess') !!}</h2>
			<p>{!! $translate->token('text_creativeprocess') !!}</p>
		</div>
		
	</div>
	
	<div class="content-block cb-a">
		<div class="text-block tb-c">
			<h2>{!! $translate->token('h_exclusivity') !!}</h2>
			<p>{!! $translate->token('text_exclusivity') !!}</p>
			<figure class="fig-b"><img src="/images/products/signature-aromax-flush.jpg" alt="{!! $translate->token('h_exclusivity', false) !!}"></figure>
		</div>
		
	</div>
	
	<div class="content-block">
		<div class="text-block">
			<h2>{!! $translate->token('h_developscent') !!}</h2>
			<p>{!! $translate->token('text_developscent') !!}</p>
			<p class="center">{!! $link->create('/contact', ['class' => 'ui-button ui-a ui-b'])->full('link_contact') !!}</p>
		</div>
	</div>
	
</div>

@stop