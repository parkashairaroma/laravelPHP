@section('bodyClass', 'clients dark')
@section('currentNav', 3)

@extends('layouts.pages')

@section('content')

<div class="hero-block hero-image" style="background-image: url(/images/clients/featured/hero-dom-perignon.jpg);background-position: center center;">
    <div class="container">
        <div class="hero-content">
            <div class="text-block">
                <h1>{!! $translate->token('h_domperignon') !!}</h1>
                <h2>{!! $translate->token('text_domperignon') !!}</h2>
            </div>
        </div>
    </div>
</div>

<div class="container">
	
	<div class="content-block">
		<div class="text-block">
			<h2>{!! $translate->token('h_scentdomperignon') !!}</h2>
			<p>{!! $translate->token('text_scentdomperignon') !!}</p>
		</div>
	</div>
	
	<div class="content-block">
		<!--<div class="text-block">
			<p>{!! $translate->token('text_seamlessintegration') !!}</p>
		</div>-->
		{{--
		<div class="video-block">
			<iframe width="560" height="315" src="https://www.youtube.com/embed/NdAp6f-rMV8" frameborder="0" allowfullscreen></iframe>
		</div>
		--}}

		<div class="grid square large">
			<!-- Stretch Image -->
			<div class="box dark">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-image">
           <img src="/images/clients/featured/tile-dom-perignon-01.jpg" alt="{!! $translate->token('h_domperignon', false) !!}" />
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
           <img src="/images/clients/featured/tile-dom-perignon-02.jpg" alt="{!! $translate->token('h_domperignon', false) !!}" />
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
						<p class="center">{!! $link->create('/contact')->full('link_designscent') !!}</p>	
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>

@stop