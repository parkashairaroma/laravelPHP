@section('bodyClass', 'marketing')
@section('currentNav', 1)

@extends('layouts.pages')

@section('content')

<div class="hero-block">
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>{!! $translate->token('h_banks') !!}</h1>
				<h2>{!! $translate->token('text_banks') !!}</h2>
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
								<img src="/images/industry/icon-banks.png" alt="{!! $translate->token('h_banks', false) !!}">
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
								<img src="/images/industry/tile-banks.jpg" alt="{!! $translate->token('h_banks', false) !!}">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="content-block cb-a">
		<div class="text-block">
			<h2>{!! $translate->token('h_customerretention') !!}</h2>
			<p>{!! $translate->token('text_customerretention') !!}</p>
		</div>
	</div>
	
	<div class="content-block cb-b">
		<div class="text-block">
			<blockquote>
				<p>{!! $translate->token('quote_content') !!}</p>
				<footer>{!! $translate->token('quote_signature') !!}</footer>
			</blockquote>
		</div>
	</div>
	
	<div class="content-block cb-a">
		<div class="text-block">
			<h2>{!! $translate->token('h_scentingbenefits') !!}</h2>
			<p>{!! $translate->token('text_scentingbenefits') !!}</p>
		</div>
	</div>
	
	<div class="content-block cb-a">
		<div class="grid large divider div-a">
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							<div class="feature-icon icon-tick"></div>
							<h3>{!! $translate->token('h_customersatisfaction') !!}</h3>
							<p>{!! $translate->token('text_customersatisfaction') !!}</p>
						</div>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							<div class="feature-icon icon-star"></div>
							<h3>{!! $translate->token('h_brandrecognition') !!}</h3>
							<p>{!! $translate->token('text_brandrecognition') !!}</p>
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
			<h2>{!! $translate->token('h_startscenting') !!}</h2>
			<p>{!! $translate->token('text_startscenting') !!}</p>
			<p class="center">{!! $link->create('/contact', ['class' => 'ui-button ui-a'])->full('link_contactus') !!}</p>	
		</div>
	</div>
	
</div>

@stop