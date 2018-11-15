@section('bodyClass', 'about subnav')
@section('currentNav', 0)
@section('currentSubNav', 2)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-about')

<div class="hero-block hb-a">
	<div class="container">
			<div class="hero-content">
			<div class="text-block tb-a">
				<h1>{!! $translate->token('h_gogreen') !!}</h1>
				<p>{!! $translate->token('text_gogreen') !!}</p>
			</div>
		</div>
	</div>
</div>

<div class="container">
	
	<div class="content-block cb-a">
		
		<!-- Text -->
		<div class="text-block">
			<h2>{!! $translate->token('h_recycling') !!}</h2>
			<p>{!! $translate->token('text_recycling') !!}</p>
			
			<!-- Inner Icon Row -->
			<div class="grid inner">
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="text-block">
								<div class="feature-icon fi-green icon-recycle-pp"></div>
								<h3>{!! $translate->token('h_pp') !!}</h3>
								<p>{!! $translate->token('text_pp') !!}</p>
							</div>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="text-block">
								<div class="feature-icon fi-green icon-recycle-pet"></div>
								<h3>{!! $translate->token('h_pet') !!}</h3>
								<p>{!! $translate->token('text_pet') !!}</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	
	<div class="content-block cb-a">
		<div class="text-block">
			<h2>{!! $translate->token('h_compliance') !!}</h2>
			<p>{!! $translate->token('text_compliance') !!}</p>
		</div>
	</div>
	
	<div class="content-block">
		<div class="text-block">
			<h2>{!! $translate->token('h_footprint') !!}</h2>
			<p>{!! $translate->token('text_footprint') !!}</p>		
		</div>
	</div>
	
</div>

@stop