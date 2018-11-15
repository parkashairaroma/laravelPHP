@section('bodyClass', 'legal subnav')
@section('currentNav', 0)
@section('currentSubNav', 2)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-legal')

<div class="container">
	
	<div class="content-block">
		<div class="legal-block">
			<h2>{!! $translate->token('h_genuineproducts') !!}</h2>
			<h3>{!! $translate->token('h_buyerbeware') !!}</h3>
			
			<h4>{!! $translate->token('h_buygenuine') !!}</h4>
			<div>{!! $translate->token('text_buygenuine') !!}</div>

			<h4>{!! $translate->token('h_fooled') !!}</h4>
			<div>{!! $translate->token('text_fooled') !!}</div>

			<div>{!! $translate->token('text_bewareoffake') !!}</div>
			<ul>
				<li>{!! $translate->token('text_logobrand') !!}</li>
				<li>{!! $translate->token('text_fakebusinesscards') !!}</li>
				<li>{!! $translate->token('text_falsequotations') !!}</li>
			</ul>

			<h4>{!! $translate->token('h_approvedlist') !!}</h4>
			<div>{!! $translate->token('text_approvedlist') !!}</div>

			<h4>{!! $translate->token('h_therisks') !!}</h4>
			<div>{!! $translate->token('text_therisks') !!}</div>
			<ul>
				<li>{!! $translate->token('text_voidwarrenties') !!}</li>
				<li>{!! $translate->token('text_dangerous') !!}</li>
				<li>{!! $translate->token('text_poor') !!}</li>
				<li>{!! $translate->token('text_higherconsumption') !!}</li>
				<li>{!! $translate->token('text_poorinstallation') !!}</li>
			</ul>

			<h4>{!! $translate->token('h_takingaction') !!}</h4>
			<div>{!! $translate->token('text_takingaction') !!}</div>

			<h4>{!! $translate->token('h_questions') !!}</h4>
			<div>{!! $translate->token('text_questions') !!}</div>
		
		</div>
	</div>
		
</div>

@stop