@section('bodyClass', 'scents subnav')
@section('currentNav', 2)
@section('currentSubNav', 1)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.products.nav-arotec')

<div class="hero-block">	
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>{!! $translate->token('h_arotec') !!}</h1>
				<h3>{!! $translate->token('text_arotec') !!}</h3>
			</div>
		</div>
	</div>
</div>

<div class="container">
	
	<div class="content-block">
		
		<!-- 2x1 Grid -->
		<div class="grid square large">
			<!-- Image Tile -->
			<div class="box">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-image">
								<img src="/images/tiles/tile-arotec-bottle.jpg" alt="{!! $translate->token('h_arotec', false) !!}">
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Image Tile -->
			<div class="box">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-image">
								<img src="/images/tiles/tile-arotec-oil.jpg" alt="{!! $translate->token('h_arotec', false) !!}">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Text -->
		<div class="text-block">
			<h2>{!! $translate->token('h_odoreliminator') !!}</h2>
			<p>{!! $translate->token('text_odoreliminator') !!}</p>
		</div>
		
		<!-- 2x1 Grid -->
		<div class="grid square large">
			<!-- Text Tile -->
			<div class="box light">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-label cover">
								<h2>{!! $translate->token('h_odorremoval') !!}</h2>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Image Tile -->
			<div class="box light">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							
							<!-- Nested Tiles -->
							<div class="grid square nested">
								<div class="box">
									<div class="box-cell">
										<div class="tile">
											<div class="tile-content">
												<div class="tile-icon">
													<img src="/images/icons/arotec-stage-01.png" alt="{!! $translate->token('h_odoreliminator', false) !!}">
													<p>{!! $translate->token('h_step1') !!}</p>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="box">
									<div class="box-cell">
										<div class="tile">
											<div class="tile-content">
												<div class="tile-icon">
													<img src="/images/icons/arotec-stage-02.png" alt="{!! $translate->token('h_odoreliminator', false) !!}">
													<p>{!! $translate->token('h_step2') !!}</p>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="box">
									<div class="box-cell">
										<div class="tile">
											<div class="tile-content">
												<div class="tile-icon">
													<img src="/images/icons/arotec-stage-03.png" alt="{!! $translate->token('h_odoreliminator', false) !!}">
													<p>{!! $translate->token('h_step3') !!}</p>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="box">
									<div class="box-cell">
										<div class="tile">
											<div class="tile-content">
												<div class="tile-icon">
													<img src="/images/icons/arotec-stage-04.png" alt="{!! $translate->token('h_odoreliminator', false) !!}">
													<p>{!! $translate->token('h_step4') !!}</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	
		<div class="text-block">
			<h2>{!! $translate->token('h_naturalproperties') !!}</h2>
			<p>{!! $translate->token('text_naturalproperties') !!}</p>
		</div>
				
	</div>
	<div class="hero-block hb-a"></div>
	<div class="text-block cb-a">
			<h2>{!! $translate->token('h_removeodors') !!}</h2>
			<ul class="column-list">
				<li>Cigarette smoke</li>
				<li>Damp carpet</li>
				<li>Mould</li>
				<li>Rubbish</li>
				<li>Animals</li>
				<li>Oil paints</li>
				<li>Musty upholstery</li>
				<li>Bleach</li>
				<li>Laundry</li>
				<li>Deep fat fryers</li>
				<li>Sweat</li>
				<li>Food waste</li>
				<li>Body odors</li>
				<li>Bacteria</li>
				<li>Mildew</li>
				<li>Sport shoes</li>
				<li>Pets</li>
				<li>Trash</li>
			</ul>
	</div>
</div>


@stop