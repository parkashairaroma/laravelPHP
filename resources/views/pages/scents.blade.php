@section('bodyClass', 'scents dark subnav')
@section('currentNav', 2)
@section('currentSubNav', 3)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-products')

<div class="hero-block hero-scents-home">	
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>{!! $translate->token('h_scents') !!}</h1>
				<h2>{!! $translate->token('text_scents') !!}</h2>
			</div>
		</div>
	</div>
</div>

<div class="container">
	
	<div class="content-block">
		
		<div class="grid square large grid-a">
			<!-- Product Image -->
			<div class="box">
				<a href="{{ $link->create('/essential-oils')->url() }}" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-info">
								<h3>{!! $translate->token('h_essentialoils') !!}</h3>
							</div>
							<div class="tile-image">
								<img src="/images/tiles/tile-scent-essential-oils.jpg" alt="{!! $translate->token('h_essentialoils', false) !!}">
							</div>
						</div>
						<div class="tile-overlay"><span>{!! $translate->token('link_view') !!}</span></div>
					</div>
				</a>
			</div>
			<!-- Product Image -->
			<div class="box">
				<a href="{{ $link->create('/aroma-oils')->url() }}" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-info">
								<h3>{!! $translate->token('h_aromaoils') !!}</h3>
							</div>
							<div class="tile-image ">
								<img src="/images/tiles/tile-scent-aroma-oils.jpg" alt="{!! $translate->token('h_aromaoils', false) !!}">
							</div>
						</div>
						<div class="tile-overlay"><span>{!! $translate->token('link_view') !!}</span></div>
					</div>
				</a>
			</div>
			<!-- Product Image -->
			<div class="box dark">
				<a href="{{ $link->create('/no-stress-arobalance')->url() }}" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-info">
								<h3>{!! $translate->token('h_arobalance') !!}</h3>
							</div>
							<div class="tile-image">
								<img src="/images/tiles/tile-scent-arobalance.jpg" alt="{!! $translate->token('h_arobalance', false) !!}">
							</div>
						</div>
						<div class="tile-overlay"><span>{!! $translate->token('link_view') !!}</span></div>
					</div>
				</a>
			</div>
			<!-- Product Image -->
			<div class="box">
				<a  href="{{ $link->create('/arotec')->url() }}" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-info">
								<h3>{!! $translate->token('h_arotec') !!}</h3>
							</div>
							<div class="tile-image ">
								<img src="/images/tiles/tile-scent-arotec.jpg" alt="{!! $translate->token('h_arotec', false) !!}">
							</div>
						</div>
						<div class="tile-overlay"><span>{!! $translate->token('link_view') !!}</span></div>
					</div>
				</a>
			</div>
		</div>
		
	</div>
	
</div>

@stop