@section('bodyClass', 'scenting marketing subnav')
@section('currentNav', 1)
@section('currentSubNav', 2)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-scent-marketing')

<div class="hero-block hb-a">
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>{!! $translate->token('h_whosscenting') !!}</h1>
				<h2>{!! $translate->token('text_whosscenting') !!}</h2>
			</div>
		</div>
	</div>
</div>

<div class="container">
	
	<div class="content-block">
		<div class="text-block tb-a">
			<h2>{!! $translate->token('h_scentbranding') !!}</h2>
			<p>{!! $translate->token('text_scentbranding') !!}</p>
		</div>
	</div>

	<div class="content-block">
		<div class="grid square small hairline">

			@foreach ($industries as $industry)
			<div class="box">
				<a href="{!! $link->create('/scenting')->url() !!}/{{ $industry->site_slug ?: $industry->base_slug }}" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-icon">
								<img src="/images/industry/icon-{{ $industry->base_slug }}.png" alt="{{ $industry->site_name ?: $industry->base_name }}">
								<p>{{ $industry->site_name ?: $industry->base_name }}</p>
							</div>
						</div>
					</div>
				</a>
			</div>
			@endforeach

		</div>
	</div>
</div>

@stop