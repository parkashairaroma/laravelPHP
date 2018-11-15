@section('bodyClass', 'contact subnav')
@section('currentNav', 5)
@section('currentSubNav', 1)

@extends('layouts.pages')

@section('content')

 <div class="container">

	<div class="content-block cb-a">
		
		<div class="legal-block">
			<h2>{!! $translate->token('h_selectcountry') !!}</h2>
			<h3>{!! $translate->token('h_internationalwebsites') !!}</h3>
			
			<div class="site-map country-list">
				<div class="nav-group">

					{{-- Online --}}
					@foreach ($websites->online as $key => $website)	
						<ul class="nav-map">
							<li><a rel="nofollow" href="http://{{ $website->domain }}"><span class="flag-icon"><img src="{{ $countryFlagPath }}{{ $website->code }}.png"></span>{{ $website->name }}</a></li>
						</ul>
						@if ($key++ == floor(count($websites->online) / 2))
						</div>
						<div class="nav-group">
						@endif	
					@endforeach

				</div>
			</div>
		</div>
	</div>
	
	<div class="content-block">
		
		<div class="legal-block">
			<h3>{!! $translate->token('h_comingsoon') !!}</h3>
			
			<div class="site-map country-list">
				<div class="nav-group">

					{{-- Coming Soon --}}
					@foreach ($websites->comingsoon as $key => $website)	
						<ul class="nav-map">
							<li><span class="flag-icon"><img src="{{ $countryFlagPath }}{{ $website->code }}.png"></span>{{ $website->name }}</li>
						</ul>
						@if ($key++ == floor(count($websites->comingsoon) / 2))
						</div>
						<div class="nav-group">
						@endif	
					@endforeach

				</div>
			</div>
		</div>
	</div>
	
</div>

@stop