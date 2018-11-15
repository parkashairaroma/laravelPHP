@section('bodyClass', 'marketing')
@section('currentNav', 1)

@extends('layouts.pages')

@section('content')

<div class="hero-block">
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>{!! $translate->token('h_events') !!}</h1>
				<h2>{!! $translate->token('text_events') !!}</h2>
			</div>
		</div>
	</div>
</div>

<div class="container">
	
	<div class="content-block">
		<div class="grid square large">
			<!-- Industry Icon -->
			<div class="box dark">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-icon">
								<img src="/images/industry/icon-events.png" alt="{!! $translate->token('h_events', false) !!}">
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
								<img src="/images/industry/tile-events.jpg" alt="{!! $translate->token('h_events', false) !!}">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="content-block cb-a">
		<div class="text-block">
			<h2>{!! $translate->token('h_scentedevents') !!}</h2>
			<p>{!! $translate->token('text_scentedevents') !!}</p>
		</div>
	</div>
	
	<div class="content-block cb-b">
		<div class="text-block">
			<blockquote>
				<p>{!! $translate->token('h_fragrancefact') !!} </p>
				<footer>{!! $translate->token('signature_fragrancefact') !!}</footer>
			</blockquote>
		</div>
	</div>
	
	<div class="content-block cb-a">
		<div class="text-block">
			<h2>{!! $translate->token('h_lastingmemory') !!}</h2>
			<p>{!! $translate->token('text_lastingmemory') !!}</p>
		</div>
	</div>
	
	<div class="content-block cb-a">
		<div class="grid large divider div-a">
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							<div class="feature-icon icon-tick"></div>
							<h3>{!! $translate->token('h_scentingstory') !!}</h3>
							<p>{!! $translate->token('text_scentingstory') !!}</p>
						</div>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							<div class="feature-icon icon-star"></div>
							<h3>{!! $translate->token('h_scentmemories') !!}</h3>
							<p>{!! $translate->token('text_scentmemories') !!}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="grid square small hairline">

			<!-- Client Logo -->
			@foreach ($clients as $client)
			<div class="box">
				<a class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-icon">
								<img src="{{ $clientLogoPath }}{{ $client->cli_slug }}.png" alt="{{ $client->cli_name }}">
							</div>
						</div>
					</div>
				</a>
			</div>
			@endforeach

		</div>
		
		<div class="grid more hairline">
			<!-- View More -->
			<div class="box">
       <a href="{{ $link->create('/clients')->url() }}" class="box-cell box-cell-link">
           <div class="tile">
               <div class="tile-content">
                   <div class="tile-label">
                       <h3>{!! $translate->token('link_viewmore') !!}</h3>
                   </div>
               </div>
           </div>
       </a>
			</div>
		</div>

	</div>
	
	<div class="content-block">
		<div class="text-block tb-a">
			<h2>{!! $translate->token('h_addscent') !!}</h2>
			<p>{!! $translate->token('text_addscent') !!}</p>
			<p class="center">{!! $link->create('/contact', ['class' => 'ui-button ui-a'])->full('link_contactus') !!}</p>	
		</div>
	</div>
	
</div>

@stop